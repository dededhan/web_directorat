<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonSession;
use App\Models\HackatonTahap;
use App\Models\HackatonTahapField;
use App\Models\HackatonTahapSection;
use App\Models\HackatonSubmissionTahap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TahapController extends Controller
{
    public function store(Request $request, HackatonSession $session)
    {
        $validated = $request->validate([
            'nama_tahap'    => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'periode_awal'  => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'has_anggota'   => 'nullable|boolean',
            'has_fakultas'  => 'nullable|boolean',
        ]);

        $maxTahapKe = HackatonTahap::where('hackaton_session_id', $session->id)->max('tahap_ke') ?? 0;
        $nextTahapKe = $maxTahapKe + 1;

        DB::transaction(function () use ($session, $validated, $nextTahapKe) {
            $tahap = $session->tahap()->create([
                'tahap_ke'      => $nextTahapKe,
                'nama_tahap'    => $validated['nama_tahap'],
                'deskripsi'     => $validated['deskripsi'] ?? null,
                'periode_awal'  => $validated['periode_awal'] ?? null,
                'periode_akhir' => $validated['periode_akhir'] ?? null,
                'has_anggota'   => $validated['has_anggota'] ?? false,
                'has_fakultas'  => $validated['has_fakultas'] ?? false,
            ]);

            // Sync with existing submissions in this session if any
            $submissions = $session->submissions;
            foreach ($submissions as $submission) {
                HackatonSubmissionTahap::firstOrCreate([
                    'hackaton_submission_id' => $submission->id,
                    'hackaton_tahap_id'      => $tahap->id,
                ], [
                    'status'                 => 'belum_diisi',
                    'admin_status'           => 'menunggu',
                ]);
            }
        });

        return back()->with('success', "Tahap {$nextTahapKe} ({$validated['nama_tahap']}) berhasil ditambahkan.");
    }

    public function edit(HackatonTahap $tahap)
    {
        $tahap->load(['session', 'sections.fields', 'unsectionedFields']);

        return view('admin_hackaton.tahap.edit', compact('tahap'));
    }

    public function update(Request $request, HackatonTahap $tahap)
    {
        $validated = $request->validate([
            'nama_tahap'    => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'periode_awal'  => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'has_anggota'   => 'nullable|boolean',
            'has_fakultas'  => 'nullable|boolean',
        ]);

        $validated['has_anggota'] = $request->boolean('has_anggota');
        $validated['has_fakultas'] = $request->boolean('has_fakultas');

        $tahap->update($validated);

        return back()->with('success', 'Tahap berhasil diperbarui.');
    }

    public function destroy(HackatonTahap $tahap)
    {
        $session = $tahap->session;

        // Check if there are submissions submitted on this tahap
        $hasSubmittedData = HackatonSubmissionTahap::where('hackaton_tahap_id', $tahap->id)
            ->whereIn('status', ['draft', 'diajukan'])
            ->exists();

        if ($hasSubmittedData) {
            return back()->with('error', 'Tahap tidak dapat dihapus karena sudah memiliki data pengajuan dari peserta.');
        }

        DB::transaction(function () use ($tahap, $session) {
            $deletedTahapKe = $tahap->tahap_ke;
            $sessionId = $tahap->hackaton_session_id;

            $tahap->delete();

            // Re-order remaining tahap_ke so there are no gaps
            $remainingTahaps = HackatonTahap::where('hackaton_session_id', $sessionId)
                ->orderBy('tahap_ke')
                ->get();

            foreach ($remainingTahaps as $index => $item) {
                $item->update(['tahap_ke' => $index + 1]);
            }
        });

        return redirect()
            ->route('admin_hackaton.sessions.show', $session)
            ->with('success', 'Tahap berhasil dihapus.');
    }

    // --- Field CRUD ---

    public function storeField(Request $request, HackatonTahap $tahap)
    {
        // If field_options_raw is provided as newline-delimited string, convert to array
        if ($request->filled('field_options_raw') && !$request->has('field_options')) {
            $options = preg_split('/\r\n|\r|\n/', (string) $request->input('field_options_raw'));
            $request->merge([
                'field_options' => array_values(array_filter(array_map('trim', $options), fn($v) => $v !== ''))
            ]);
        }

        $validated = $request->validate([
            'field_label'        => 'required|string|max:255',
            'field_type'         => 'required|in:text,textarea,number,date,dropdown,checkbox,file,url',
            'field_options'      => 'nullable|array',
            'field_options.*'    => 'nullable|string|max:255',
            'field_options_raw'  => 'nullable|string',
            'template_url'       => 'nullable|string|max:1000',
            'template_file'      => 'nullable|file|max:20480',
            'template_file_name' => 'nullable|string|max:255',
            'is_required'        => 'boolean',
            'section_id'         => 'nullable|integer|exists:hackaton_tahap_sections,id',
        ]);

        if (!in_array($validated['field_type'], ['dropdown', 'checkbox'])) {
            $validated['field_options'] = null;
        } else {
            $validated['field_options'] = array_values(
                array_filter($validated['field_options'] ?? [], fn($v) => $v !== null && $v !== '')
            ) ?: null;
        }

        $templateFilePath = null;
        $templateFileName = null;

        if ($request->hasFile('template_file')) {
            $file = $request->file('template_file');
            $templateFilePath = $file->store('hackaton/templates', 'public');
            $templateFileName = $request->filled('template_file_name')
                ? $request->input('template_file_name')
                : $file->getClientOriginalName();
        }

        $sectionId = $validated['section_id'] ?? null;

        $maxUrutan = HackatonTahapField::where('hackaton_tahap_id', $tahap->id)
            ->where('hackaton_tahap_section_id', $sectionId)
            ->max('urutan') ?? 0;

        $tahap->fields()->create([
            'field_label'               => $validated['field_label'],
            'field_type'                => $validated['field_type'],
            'field_options'             => $validated['field_options'],
            'template_url'              => $validated['template_url'] ?? null,
            'template_file'             => $templateFilePath,
            'template_file_name'        => $templateFileName,
            'is_required'               => $request->boolean('is_required', true),
            'urutan'                    => $maxUrutan + 1,
            'hackaton_tahap_section_id' => $sectionId,
        ]);

        return back()->with('success', 'Field berhasil ditambahkan.');
    }

    public function updateField(Request $request, HackatonTahapField $field)
    {
        // If field_options_raw is provided as newline-delimited string, convert to array
        if ($request->has('field_options_raw') && !$request->has('field_options')) {
            $options = preg_split('/\r\n|\r|\n/', (string) $request->input('field_options_raw'));
            $request->merge([
                'field_options' => array_values(array_filter(array_map('trim', $options), fn($v) => $v !== ''))
            ]);
        }

        $validated = $request->validate([
            'field_label'          => 'required|string|max:255',
            'field_type'           => 'required|in:text,textarea,number,date,dropdown,checkbox,file,url',
            'field_options'        => 'nullable|array',
            'field_options.*'      => 'string|max:255',
            'field_options_raw'    => 'nullable|string',
            'template_url'         => 'nullable|string|max:1000',
            'template_file'        => 'nullable|file|max:20480',
            'template_file_name'   => 'nullable|string|max:255',
            'remove_template_file' => 'nullable|boolean',
            'is_required'          => 'boolean',
        ]);

        if (!in_array($validated['field_type'], ['dropdown', 'checkbox'])) {
            $validated['field_options'] = null;
        } else {
            $validated['field_options'] = array_values(
                array_filter($validated['field_options'] ?? [], fn($v) => $v !== null && $v !== '')
            ) ?: null;
        }

        $validated['is_required'] = $request->boolean('is_required');

        $templateFilePath = $field->template_file;
        $templateFileName = $request->filled('template_file_name') ? $request->input('template_file_name') : $field->template_file_name;

        if ($request->boolean('remove_template_file')) {
            if ($field->template_file && Storage::disk('public')->exists($field->template_file)) {
                Storage::disk('public')->delete($field->template_file);
            }
            $templateFilePath = null;
            $templateFileName = null;
        } elseif ($request->hasFile('template_file')) {
            if ($field->template_file && Storage::disk('public')->exists($field->template_file)) {
                Storage::disk('public')->delete($field->template_file);
            }
            $file = $request->file('template_file');
            $templateFilePath = $file->store('hackaton/templates', 'public');
            $templateFileName = $request->filled('template_file_name')
                ? $request->input('template_file_name')
                : $file->getClientOriginalName();
        }

        $field->update([
            'field_label'        => $validated['field_label'],
            'field_type'         => $validated['field_type'],
            'field_options'      => $validated['field_options'],
            'template_url'       => $validated['template_url'] ?? null,
            'template_file'      => $templateFilePath,
            'template_file_name' => $templateFileName,
            'is_required'        => $validated['is_required'],
        ]);

        return back()->with('success', 'Field berhasil diperbarui.');
    }

    public function destroyField(HackatonTahapField $field)
    {
        if ($field->template_file && Storage::disk('public')->exists($field->template_file)) {
            Storage::disk('public')->delete($field->template_file);
        }

        $field->delete();

        return back()->with('success', 'Field berhasil dihapus.');
    }

    public function reorderFields(Request $request, HackatonTahap $tahap)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:hackaton_tahap_fields,id',
        ]);

        foreach ($request->order as $index => $fieldId) {
            HackatonTahapField::where('id', $fieldId)
                ->where('hackaton_tahap_id', $tahap->id)
                ->update(['urutan' => $index + 1]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function moveField(Request $request, HackatonTahapField $field)
    {
        $request->validate([
            'section_id' => 'nullable|integer|exists:hackaton_tahap_sections,id',
        ]);

        $newSectionId = $request->section_id ?: null;

        $maxUrutan = HackatonTahapField::where('hackaton_tahap_id', $field->hackaton_tahap_id)
            ->where('hackaton_tahap_section_id', $newSectionId)
            ->max('urutan') ?? 0;

        $field->update([
            'hackaton_tahap_section_id' => $newSectionId,
            'urutan'                    => $maxUrutan + 1,
        ]);

        return back()->with('success', 'Field berhasil dipindahkan.');
    }

    // --- Section CRUD ---

    public function storeSection(Request $request, HackatonTahap $tahap)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $maxUrutan = HackatonTahapSection::where('hackaton_tahap_id', $tahap->id)->max('urutan') ?? 0;

        $tahap->sections()->create([
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan'    => $maxUrutan + 1,
        ]);

        return back()->with('success', 'Section berhasil ditambahkan.');
    }

    public function updateSection(Request $request, HackatonTahapSection $section)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $section->update($validated);

        return back()->with('success', 'Section berhasil diperbarui.');
    }

    public function destroySection(HackatonTahapSection $section)
    {
        // Move fields in this section to unsectioned before deleting
        HackatonTahapField::where('hackaton_tahap_section_id', $section->id)
            ->update(['hackaton_tahap_section_id' => null]);

        $section->delete();

        return back()->with('success', 'Section berhasil dihapus.');
    }

    public function reorderSections(Request $request, HackatonTahap $tahap)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:hackaton_tahap_sections,id',
        ]);

        foreach ($request->order as $index => $sectionId) {
            HackatonTahapSection::where('id', $sectionId)
                ->where('hackaton_tahap_id', $tahap->id)
                ->update(['urutan' => $index + 1]);
        }

        return response()->json(['status' => 'ok']);
    }
}
