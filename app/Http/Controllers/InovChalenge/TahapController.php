<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeTahap;
use App\Models\InovChalengeTahapField;
use Illuminate\Http\Request;

class TahapController extends Controller
{
    public function edit(InovChalengeTahap $tahap)
    {
        $tahap->load(['session', 'fields']);

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
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|in:text,textarea,number,date,dropdown,file,url',
            'field_options' => 'nullable|array',
            'field_options.*' => 'string|max:255',
            'is_required' => 'boolean',
        ]);

        $validated['urutan'] = $tahap->fields()->max('urutan') + 1;

        $tahap->fields()->create($validated);

        return back()->with('success', 'Field berhasil ditambahkan.');
    }

    public function updateField(Request $request, InovChalengeTahapField $field)
    {
        $validated = $request->validate([
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|in:text,textarea,number,date,dropdown,file,url',
            'field_options' => 'nullable|array',
            'field_options.*' => 'string|max:255',
            'is_required' => 'boolean',
        ]);

        // Clear options if field type is not dropdown
        if ($validated['field_type'] !== 'dropdown') {
            $validated['field_options'] = null;
        }

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
            'order' => 'required|array',
            'order.*' => 'integer|exists:inov_chalenge_tahap_fields,id',
        ]);

        foreach ($validated['order'] as $index => $fieldId) {
            InovChalengeTahapField::where('id', $fieldId)
                ->where('inov_chalenge_tahap_id', $tahap->id)
                ->update(['urutan' => $index + 1]);
        }

        return response()->json(['message' => 'Urutan field berhasil diperbarui.']);
    }
}
