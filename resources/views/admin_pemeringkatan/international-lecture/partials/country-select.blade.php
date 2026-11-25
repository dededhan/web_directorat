@php
    $countryItems = $countryOptions ?? \App\Services\LecturerDataSanitizer::countrySearchIndex();
    $canonicalList = array_column($countryItems, 'name');
    $normalizedSelected = \App\Services\LecturerDataSanitizer::normalizeCountry($selectedCountry ?? null);
    $resolvedCountry = ($normalizedSelected && in_array($normalizedSelected, $canonicalList, true)) ? $normalizedSelected : '';
@endphp

<div class="relative" id="negara_combobox">
    <label class="label">Negara <span class="text-red-500">*</span></label>

    <input type="hidden" name="negara" id="negara_final" value="{{ $resolvedCountry }}">

    <button type="button"
            id="negara_trigger"
            aria-haspopup="listbox"
            aria-expanded="false"
            class="input flex items-center justify-between gap-2 text-left cursor-pointer">
        <span id="negara_trigger_label" class="{{ $resolvedCountry ? 'text-gray-800' : 'text-gray-400' }}">
            {{ $resolvedCountry ?: 'Pilih Negara' }}
        </span>
        <svg id="negara_trigger_icon" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div id="negara_dropdown"
         class="hidden absolute left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-lg shadow-lg z-40 overflow-hidden">
        <div class="p-2 border-b border-gray-100 bg-gray-50">
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
                <input type="text"
                       id="negara_search"
                       autocomplete="off"
                       placeholder="Cari negara..."
                       class="w-full pl-8 pr-3 py-1.5 text-sm border border-gray-200 rounded-md bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15">
            </div>
        </div>

        <div id="negara_list" role="listbox" class="max-h-60 overflow-y-auto py-1">
            @foreach($countryItems as $item)
                @php $isSelected = $resolvedCountry === $item['name']; @endphp
                <button type="button"
                        role="option"
                        aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                        data-country="{{ $item['name'] }}"
                        data-keywords="{{ $item['keywords'] }}"
                        class="negara-option w-full px-3.5 py-2 text-left text-sm flex items-center justify-between gap-2 hover:bg-blue-50 transition-colors {{ $isSelected ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <span>{{ $item['name'] }}</span>
                    <svg class="negara-check w-4 h-4 text-blue-600 shrink-0 {{ $isSelected ? '' : 'hidden' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            @endforeach
            <div id="negara_empty" class="hidden px-3.5 py-3 text-xs text-gray-500 text-center">
                Negara tidak ditemukan.
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const combobox = document.getElementById('negara_combobox');
    const trigger = document.getElementById('negara_trigger');
    const triggerLabel = document.getElementById('negara_trigger_label');
    const triggerIcon = document.getElementById('negara_trigger_icon');
    const dropdown = document.getElementById('negara_dropdown');
    const searchInput = document.getElementById('negara_search');
    const finalInput = document.getElementById('negara_final');
    const emptyNotice = document.getElementById('negara_empty');
    const options = Array.from(document.querySelectorAll('#negara_list .negara-option'));

    if (!combobox || !trigger || !dropdown || !searchInput || !finalInput) return;

    const filterOptions = () => {
        const q = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        options.forEach((opt) => {
            const keywords = (opt.dataset.keywords || '').toLowerCase();
            const name = (opt.dataset.country || '').toLowerCase();
            const match = !q || name.includes(q) || keywords.includes(q);
            opt.classList.toggle('hidden', !match);
            if (match) visibleCount++;
        });

        if (emptyNotice) {
            emptyNotice.classList.toggle('hidden', visibleCount > 0);
        }
    };

    const openDropdown = () => {
        dropdown.classList.remove('hidden');
        trigger.setAttribute('aria-expanded', 'true');
        if (triggerIcon) triggerIcon.classList.add('rotate-180');
        searchInput.value = '';
        filterOptions();
        setTimeout(() => searchInput.focus(), 10);
    };

    const closeDropdown = () => {
        dropdown.classList.add('hidden');
        trigger.setAttribute('aria-expanded', 'false');
        if (triggerIcon) triggerIcon.classList.remove('rotate-180');
    };

    const selectCountry = (country) => {
        finalInput.value = country;
        triggerLabel.textContent = country || 'Pilih Negara';
        triggerLabel.classList.toggle('text-gray-800', Boolean(country));
        triggerLabel.classList.toggle('text-gray-400', !country);

        options.forEach((opt) => {
            const active = opt.dataset.country === country;
            opt.setAttribute('aria-selected', active ? 'true' : 'false');
            opt.classList.toggle('bg-blue-50', active);
            opt.classList.toggle('text-blue-700', active);
            opt.classList.toggle('font-semibold', active);
            opt.classList.toggle('text-gray-700', !active);
            const check = opt.querySelector('.negara-check');
            if (check) check.classList.toggle('hidden', !active);
        });

        closeDropdown();
    };

    trigger.addEventListener('click', () => {
        if (dropdown.classList.contains('hidden')) {
            openDropdown();
        } else {
            closeDropdown();
        }
    });

    searchInput.addEventListener('input', filterOptions);

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDropdown();
            trigger.focus();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            const firstVisible = options.find((opt) => !opt.classList.contains('hidden'));
            if (firstVisible) {
                selectCountry(firstVisible.dataset.country || '');
            }
        }
    });

    options.forEach((opt) => {
        opt.addEventListener('click', () => {
            selectCountry(opt.dataset.country || '');
        });
    });

    document.addEventListener('click', (e) => {
        if (!combobox.contains(e.target)) {
            closeDropdown();
        }
    });
});
</script>
