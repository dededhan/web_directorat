<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeTahap;
use App\Models\InovChalengeTahapField;
use App\Models\InovChalengeTahapSection;
use Illuminate\Http\Request;

class TahapController extends Controller
{
    public function edit(InovChalengeTahap $tahap)
    {
        $tahap->load(['session', 'sections.fields', 'unsectionedFields']);

        return view('admin_inovasi.inovchalenge.tahap.edit', compact('tahap'));
    }

    public function update(Request $request, InovChalengeTahap $tahap)
    {
        $validated = $request->validate([
            'nama_tahap' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
        ]);

        $tahap->update($validated);

        return back()->with('success', 'Tahap berhasil diperbarui.');
    }

    // --- Field CRUD ---

    public function storeField(Request $request, InovChalengeTahap $tahap)
    {
        $validated = $request->validate([
            'field_label'  => 'required|string|max:255',
            'field_type'   => 'required|in:text,textarea,number,date,dropdown,checkbox,file,url',
            'field_options'   => 'nullable|array',
            'field_options.*' => 'nullable|string|max:255',
            'is_required'  => 'boolean',
            'section_id'   => 'nullable|integer|exists:inov_chalenge_tahap_sections,id',
        ]);

        // Clear or filter options based on field type
        if (!in_array($validated['field_type'], ['dropdown', 'checkbox'])) {
            $validated['field_options'] = null;
        } else {
            $validated['field_options'] = array_values(
                array_filter($validated['field_options'] ?? [], fn($v) => $v !== null && $v !== '')
            ) ?: null;
        }

        $sectionId = $validated['section_id'] ?? null;

        $maxUrutan = InovChalengeTahapField::where('inov_chalenge_tahap_id', $tahap->id)
            ->where('inov_chalenge_tahap_section_id', $sectionId)
            ->max('urutan') ?? 0;

        $tahap->fields()->create([
            'field_label'                    => $validated['field_label'],
            'field_type'                     => $validated['field_type'],
            'field_options'                  => $validated['field_options'],
            'is_required'                    => $validated['is_required'] ?? true,
            'urutan'                         => $maxUrutan + 1,
            'inov_chalenge_tahap_section_id' => $sectionId,
        ]);

        return back()->with('success', 'Field berhasil ditambahkan.');
    }

    public function updateField(Request $request, InovChalengeTahapField $field)
    {
        $validated = $request->validate([
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|in:text,textarea,number,date,dropdown,checkbox,file,url',
            'field_options' => 'nullable|array',
            'field_options.*' => 'string|max:255',
            'is_required' => 'boolean',
        ]);

        // Clear or filter options based on field type
        if (!in_array($validated['field_type'], ['dropdown', 'checkbox'])) {
            $validated['field_options'] = null;
        } else {
            $validated['field_options'] = array_values(
                array_filter($validated['field_options'] ?? [], fn($v) => $v !== null && $v !== '')
            ) ?: null;
        }

        $validated['is_required'] = $validated['is_required'] ?? false;

        $field->update($validated);

        return back()->with('success', 'Field berhasil diperbarui.');
    }

    public function destroyField(InovChalengeTahapField $field)
    {
        $field->delete();

        return back()->with('success', 'Field berhasil dihapus.');
    }

    public function reorderFields(Request $request, InovChalengeTahap $tahap)
    {
        $validated = $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:inov_chalenge_tahap_fields,id',
        ]);

        foreach ($validated['order'] as $index => $fieldId) {
            InovChalengeTahapField::where('id', $fieldId)
                ->where('inov_chalenge_tahap_id', $tahap->id)
                ->update(['urutan' => $index + 1]);
        }

        return response()->json(['message' => 'Urutan field berhasil diperbarui.']);
    }

    // ── Section CRUD ─────────────────────────────────────────────────────────

    public function storeSection(Request $request, InovChalengeTahap $tahap)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        InovChalengeTahapSection::create([
            'inov_chalenge_tahap_id' => $tahap->id,
            'judul'                  => $validated['judul'],
            'deskripsi'              => $validated['deskripsi'] ?? null,
            'urutan'                 => ($tahap->sections()->max('urutan') ?? 0) + 1,
        ]);

        return back()->with('success', 'Seksi berhasil ditambahkan.');
    }

    public function updateSection(Request $request, InovChalengeTahapSection $section)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $section->update($validated);

        return back()->with('success', 'Seksi berhasil diperbarui.');
    }

    public function destroySection(InovChalengeTahapSection $section)
    {
        // Fields inside the section become unsectioned (nullOnDelete migration)
        $section->delete();

        return back()->with('success', 'Seksi dihapus. Field dipindah ke Umum.');
    }

    public function reorderSections(Request $request, InovChalengeTahap $tahap)
    {
        $validated = $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:inov_chalenge_tahap_sections,id',
        ]);

        foreach ($validated['order'] as $index => $sectionId) {
            InovChalengeTahapSection::where('id', $sectionId)
                ->where('inov_chalenge_tahap_id', $tahap->id)
                ->update(['urutan' => $index + 1]);
        }

        return response()->json(['message' => 'Urutan seksi berhasil diperbarui.']);
    }

    /**
     * Move a field into a different section (or unsectioned when section_id = null).
     */
    public function moveField(Request $request, InovChalengeTahapField $field)
    {
        $validated = $request->validate([
            'section_id' => 'nullable|integer|exists:inov_chalenge_tahap_sections,id',
        ]);

        $newSectionId = $validated['section_id'] ?? null;

        $maxUrutan = InovChalengeTahapField::where('inov_chalenge_tahap_id', $field->inov_chalenge_tahap_id)
            ->where('inov_chalenge_tahap_section_id', $newSectionId)
            ->max('urutan') ?? 0;

        $field->update([
            'inov_chalenge_tahap_section_id' => $newSectionId,
            'urutan'                         => $maxUrutan + 1,
        ]);

        return back()->with('success', 'Field berhasil dipindah.');
    }
}
