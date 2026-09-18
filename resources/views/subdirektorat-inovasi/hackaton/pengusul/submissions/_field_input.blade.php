{{--
  Partial: single field input row for a hackaton submission tahap form.
  Variables expected:
    $field        – HackatonTahapField instance
    $fieldValues  – Collection keyed by field id
    $isEditable   – bool
--}}
@php
    $fieldKey = 'field_' . $field->id;
    $fv = $fieldValues[$field->id] ?? null;
    $currentValue = null;
    if ($fv) {
        if ($field->field_type === 'checkbox') {
            $decoded = json_decode($fv->value ?? '', true);
            $currentValue = is_array($decoded) ? $decoded : [];
        } else {
            $currentValue = $fv->value;
        }
    }
@endphp

<div>
    <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
        <label for="{{ $fieldKey }}" class="block text-xs font-bold uppercase tracking-wider text-gray-800">
            {{ $field->field_label }}
            @if ($field->is_required)
                <span class="text-rose-600">*</span>
            @endif
        </label>

        @if ($field->template_url || $field->template_file)
            <div class="flex flex-wrap items-center gap-2">
                @if ($field->template_file)
                    <a href="{{ route('hackaton.templates.download', $field) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 rounded-lg text-xs font-semibold transition">
                        <i class="fas fa-file-download text-amber-600"></i>
                        <span>{{ $field->template_file_name ?: 'Unduh Template' }}</span>
                    </a>
                @endif
                @if ($field->template_url)
                    <a href="{{ $field->template_url }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200 rounded-lg text-xs font-semibold transition">
                        <i class="fas fa-external-link-alt text-[10px] text-blue-600"></i>
                        <span>Buka Link Template</span>
                    </a>
                @endif
            </div>
        @endif
    </div>

    @switch($field->field_type)
        @case('text')
            <input type="text" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                class="w-full rounded-xl border border-gray-300 text-sm px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500 {{ !$isEditable ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('textarea')
            <textarea name="{{ $fieldKey }}" id="{{ $fieldKey }}" rows="4"
                class="w-full rounded-xl border border-gray-300 text-sm px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500 {{ !$isEditable ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>{{ old($fieldKey, $currentValue) }}</textarea>
        @break

        @case('number')
            <input type="number" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                class="w-full rounded-xl border border-gray-300 text-sm px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500 {{ !$isEditable ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('date')
            <input type="date" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}"
                class="w-full rounded-xl border border-gray-300 text-sm px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500 {{ !$isEditable ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
        @break

        @case('dropdown')
            <select name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                class="w-full rounded-xl border border-gray-300 text-sm px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500 {{ !$isEditable ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
                <option value="">-- Pilih --</option>
                @if ($field->field_options)
                    @foreach ($field->field_options as $opt)
                        <option value="{{ $opt }}" {{ old($fieldKey, $currentValue) == $opt ? 'selected' : '' }}>
                            {{ $opt }}
                        </option>
                    @endforeach
                @endif
            </select>
        @break

        @case('file')
            @if ($currentValue)
                <div class="mb-2 p-3 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file text-amber-500"></i>
                        <a href="{{ asset('storage/' . $currentValue) }}" target="_blank" class="font-bold text-blue-700 hover:underline">
                            {{ basename($currentValue) }}
                        </a>
                        <span class="text-emerald-700 font-semibold">(Telah Diunggah)</span>
                    </div>
                    <a href="{{ asset('storage/' . $currentValue) }}" target="_blank" class="text-xs text-gray-600 hover:text-black">
                        <i class="fas fa-external-link-alt"></i> Buka
                    </a>
                </div>
            @endif
            @if ($isEditable)
                <input type="file" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-900 hover:file:bg-amber-200">
                @if ($currentValue)
                    <p class="text-[11px] text-gray-400 mt-1 italic">* Unggah file baru jika ingin mengganti file yang sudah ada.</p>
                @endif
            @endif
        @break

        @case('url')
            <input type="url" name="{{ $fieldKey }}" id="{{ $fieldKey }}"
                value="{{ old($fieldKey, $currentValue) }}" placeholder="https://..."
                class="w-full rounded-xl border border-gray-300 text-sm px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500 {{ !$isEditable ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : '' }}"
                {{ !$isEditable ? 'disabled' : '' }}>
            @if ($currentValue && !$isEditable)
                <a href="{{ $currentValue }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline mt-1">
                    <i class="fas fa-external-link-alt text-[10px]"></i> Buka Tautan
                </a>
            @endif
        @break

        @case('checkbox')
            @php
                $checkedList = (array) (old($fieldKey, $currentValue) ?? []);
            @endphp
            <div class="space-y-2 mt-2">
                @if ($field->field_options)
                    @foreach ($field->field_options as $opt)
                        <label class="flex items-center gap-2.5 text-xs text-gray-800 cursor-pointer">
                            <input type="checkbox" name="{{ $fieldKey }}[]" value="{{ $opt }}"
                                {{ in_array($opt, $checkedList) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500"
                                {{ !$isEditable ? 'disabled' : '' }}>
                            <span>{{ $opt }}</span>
                        </label>
                    @endforeach
                @else
                    <p class="text-xs text-gray-400 italic">Tidak ada opsi</p>
                @endif
            </div>
        @break
    @endswitch
</div>
