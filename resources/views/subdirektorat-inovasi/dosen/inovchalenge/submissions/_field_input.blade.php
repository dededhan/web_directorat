{{--
  Partial: single field input row for a submission tahap form.
  Variables expected:
    $field        – InovChalengeTahapField instance
    $fieldValues  – Collection keyed by field id
    $isEditable   – bool
--}}
@php
    $fieldKey = 'field_' . $field->id;
    $fv = $fieldValues[$field->id] ?? null;
    $currentValue = null;
    if ($fv) {
        if ($field->field_type === 'file') {
            $currentValue = $fv->value_file_path;
        } elseif ($field->field_type === 'url') {
            $currentValue = $fv->value_url;
        } elseif ($field->field_type === 'checkbox') {
            $decoded = json_decode($fv->value_text ?? '', true);
            $currentValue = is_array($decoded) ? $decoded : [];
        } else {
            $currentValue = $fv->value_text;
        }
    }
@endphp

<div>
    <label for="{{ $fieldKey }}"
        class="block text-sm font-semibold text-gray-700 mb-1.5">
        {{ $field->field_label }}
        @if ($field->is_required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if (isset($field->field_placeholder) && $field->field_placeholder)
        <p class="text-xs text-gray-400 mb-1">{{ $field->field_placeholder }}</p>
    @endif

    @switch($field->field_type)
        @case('text')
            <input type="text" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                placeholder="{{ $field->field_placeholder ?? '' }}"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('textarea')
            <textarea name="{{ $fieldKey }}" id="{{ $fieldKey }}" rows="4"
                placeholder="{{ $field->field_placeholder ?? '' }}"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>{{ old($fieldKey, $currentValue) }}</textarea>
        @break

        @case('number')
            <input type="number" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                placeholder="{{ $field->field_placeholder ?? '' }}"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('date')
            <input type="date" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('dropdown')
            <select name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
                <option value="">-- Pilih --</option>
                @if ($field->field_options)
                    @foreach ($field->field_options as $opt)
                        <option value="{{ $opt }}"
                            {{ old($fieldKey, $currentValue) == $opt ? 'selected' : '' }}>
                            {{ $opt }}
                        </option>
                    @endforeach
                @endif
            </select>
        @break

        @case('file')
            @if ($currentValue)
                <div class="mb-2 flex items-center gap-2 text-sm">
                    <i class="fas fa-paperclip text-teal-500"></i>
                    <a href="{{ asset('storage/' . $currentValue) }}" target="_blank"
                        class="text-teal-600 hover:underline">
                        {{ $fv->original_filename ?? basename($currentValue) }}
                    </a>
                    <span class="text-gray-400 text-xs">(sudah diunggah)</span>
                </div>
            @endif
            @if ($isEditable)
                <input type="file" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                @if ($currentValue)
                    <p class="text-[11px] text-gray-400 mt-1">Upload file baru untuk mengganti file yang sudah ada</p>
                @endif
            @endif
        @break

        @case('url')
            <input type="url" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                placeholder="{{ $field->field_placeholder ?? 'https://...' }}"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5 {{ !$isEditable ? 'bg-gray-50' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('checkbox')
            @php
                $checkedValues = old($fieldKey, $currentValue ?? []);
                if (!is_array($checkedValues)) {
                    $checkedValues = [];
                }
            @endphp
            <div class="space-y-2 {{ !$isEditable ? 'opacity-60 pointer-events-none' : '' }}">
                @if ($field->field_options)
                    @foreach ($field->field_options as $opt)
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="checkbox"
                                name="{{ $fieldKey }}[]"
                                value="{{ $opt }}"
                                {{ in_array($opt, $checkedValues) ? 'checked' : '' }}
                                {{ !$isEditable ? 'disabled' : '' }}
                                class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                            <span class="text-sm text-gray-700 group-hover:text-teal-700 transition">{{ $opt }}</span>
                        </label>
                    @endforeach
                @else
                    <p class="text-xs text-gray-400">Tidak ada opsi tersedia.</p>
                @endif
            </div>
        @break
    @endswitch
</div>
