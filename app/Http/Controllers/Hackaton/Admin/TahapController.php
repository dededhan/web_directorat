<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonTahap;
use App\Models\HackatonTahapField;
use App\Models\HackatonTahapSection;
use Illuminate\Http\Request;

class TahapController extends Controller
{
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
        ]);

        $tahap->update($validated);

        return back()->with('success', 'Tahap berhasil diperbarui.');
    }

    // --- Field CRUD ---

    public function storeField(Request $request, HackatonTahap $tahap)
    {
        $validated = $request->validate([
            'field_label'     => 'required|string|max:255',
            'field_type'      => 'required|in:text,textarea,number,date,dropdown,checkbox,file,url',
            'field_options'   => 'nullable|array',
            'field_options.*' => 'nullable|string|max:255',
            'is_required'     => 'boolean',
            'section_id'      => 'nullable|integer|exists:hackaton_tahap_sections,id',
        ]);

        if (!in_array($validated['field_type'], ['dropdown', 'checkbox'])) {
            $validated['field_options'] = null;
        } else {
            $validated['field_options'] = array_values(
                array_filter($validated['field_options'] ?? [], fn($v) => $v !== null && $v !== '')
            ) ?: null;
        }

        $sectionId = $validated['section_id'] ?? null;

        $maxUrutan = HackatonTahapField::where('hackaton_tahap_id', $tahap->id)
            ->where('hackaton_tahap_section_id', $sectionId)
            ->max('urutan') ?? 0;

        $tahap->fields()->create([
            'field_label'               => $validated['field_label'],
            'field_type'                => $validated['field_type'],
            'field_options'             => $validated['field_options'],
            'is_required'               => $validated['is_required'] ?? true,
            'urutan'                    => $maxUrutan + 1,
            'hackaton_tahap_section_id' => $sectionId,
        ]);

        return back()->with('success', 'Field berhasil ditambahkan.');
    }

    public function updateField(Request $request, HackatonTahapField $field)
    {
        $validated = $request->validate([
            'field_label'     => 'required|string|max:255',
            'field_type'      => 'required|in:text,textarea,number,date,dropdown,checkbox,file,url',
            'field_options'   => 'nullable|array',
            'field_options.*' => 'string|max:255',
            'is_required'     => 'boolean',
        ]);

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

    public function destroyField(HackatonTahapField $field)
    {
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
