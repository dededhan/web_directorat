{{--
    Partial tabel data dosen asing.
    Dipakai di halaman utama International Lecture & halaman Kirim Email.

    Parameter:
    - $showActions (bool) : tampilkan kolom "Aksi" (default: true).
    - $selectable  (bool) : tampilkan kolom checkbox pilih penerima (default: false).
                            Membutuhkan komponen Alpine induk yang menyediakan
                            isSelected(), toggle(), pageAllSelected(), togglePage().
--}}
@php
    $showActions = $showActions ?? true;
    $selectable = $selectable ?? false;
    $colspan = 11 + ($showActions ? 1 : 0) + ($selectable ? 1 : 0);
@endphp
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800">
                <tr>
                    @if($selectable)
                        <th class="px-4 py-3 text-center w-10">
                            <input type="checkbox" id="select-page-checkbox"
                                   class="h-4 w-4 rounded border-gray-400 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                   title="Pilih semua di halaman ini"
                                   :checked="pageAllSelected()"
                                   @change="togglePage($event)">
                        </th>
                    @endif
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Nama Dosen Asing</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Jabatan</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Gender</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Institusi</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Negara</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Subject</th>
                    <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Email</th>
                    <th class="px-4 py-3 text-center text-xs text-gray-200 uppercase">Tahun</th>
                    <th class="px-4 py-3 text-center text-xs text-gray-200 uppercase">Kegiatan</th>
                    <th class="px-4 py-3 text-center text-xs text-gray-200 uppercase">Status Email</th>
                    @if($showActions)
                        <th class="px-4 py-3 text-center text-xs text-gray-200 uppercase min-w-[140px]">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse($lecturers as $index => $lecturer)
                @php
                    $emailInvalidReason = null;
                    $isEmailValid = \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($lecturer->email, $emailInvalidReason);

                    $missingFields = [];
                    if (empty($lecturer->nama)) $missingFields[] = 'Nama Dosen Asing';
                    if (empty($lecturer->jabatan)) $missingFields[] = 'Jabatan';
                    if (empty($lecturer->jenis_kelamin)) $missingFields[] = 'Gender';
                    if (empty($lecturer->universitas_asal)) $missingFields[] = 'Institusi';
                    if (empty($lecturer->negara)) $missingFields[] = 'Negara';
                    if (empty($lecturer->subject_1)) $missingFields[] = 'Subject';
                    if (empty($lecturer->email)) {
                        $missingFields[] = 'Email (Kosong)';
                    } elseif (!$isEmailValid) {
                        $missingFields[] = 'Email (Belum Fix/Sembarang)';
                    }
                    if (empty($lecturer->tahun)) $missingFields[] = 'Tahun';
                    if (($lecturer->activities_count ?? 0) < 1) $missingFields[] = 'Kegiatan';
                    $hasMissing = count($missingFields) > 0;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors {{ $selectable ? 'cursor-pointer' : '' }}"
                    @if($selectable)
                        :class="isSelected({{ $lecturer->id }}) ? 'bg-blue-50/70 hover:bg-blue-50' : ''"
                        @click="handleRowClick($event, {{ $lecturer->id }})"
                    @endif>
                    @if($selectable)
                        <td class="px-4 py-4 text-center">
                            @if($isEmailValid)
                                <input type="checkbox"
                                       class="recipient-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                       data-id="{{ $lecturer->id }}"
                                       data-name="{{ $lecturer->nama }}"
                                       data-email="{{ $lecturer->email ?: '' }}"
                                       data-email-valid="true"
                                       data-missing='@json($missingFields)'
                                       data-edit-url="{{ route('admin_pemeringkatan.international-lecture.edit', $lecturer->id) }}"
                                       :checked="isSelected({{ $lecturer->id }})"
                                       @change="toggle($event.target)">
                            @else
                                <span class="inline-block" title="Email belum fix atau sembarang ({{ $emailInvalidReason }}). Email harus fix sebelum dapat dikirim.">
                                    <input type="checkbox" disabled
                                           class="recipient-checkbox h-4 w-4 rounded border-gray-200 text-gray-300 bg-gray-100 cursor-not-allowed opacity-50"
                                           data-id="{{ $lecturer->id }}"
                                           data-name="{{ $lecturer->nama }}"
                                           data-email="{{ $lecturer->email ?: '' }}"
                                           data-email-valid="false"
                                           data-missing='@json($missingFields)'
                                           data-edit-url="{{ route('admin_pemeringkatan.international-lecture.edit', $lecturer->id) }}">
                                </span>
                            @endif
                        </td>
                    @endif
                    <td class="px-4 py-4 text-sm">{{ $lecturers->firstItem() + $index }}</td>
                    <td class="px-4 py-4">
                        <div class="font-semibold text-gray-900 flex items-center gap-1.5 flex-wrap">
                            <span>{{ $lecturer->nama }}</span>
                            @if($hasMissing)
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200" title="Data belum lengkap: {{ implode(', ', $missingFields) }}">
                                    <i class='bx bx-error text-xs'></i> Belum Lengkap
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">{{ strtoupper($lecturer->fakultas) }} · {{ $lecturer->prodi }}</div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        @if($lecturer->jabatan)
                            {{ $lecturer->jabatan }}
                        @else
                            <span class="text-xs text-amber-600 italic font-medium">(Kosong)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        @if($lecturer->jenis_kelamin)
                            {{ $lecturer->jenis_kelamin }}
                        @else
                            <span class="text-xs text-amber-600 italic font-medium">(Kosong)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm">
                        @if($lecturer->universitas_asal)
                            {{ $lecturer->universitas_asal }}
                        @else
                            <span class="text-xs text-amber-600 italic font-medium">(Kosong)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm">
                        @if($lecturer->negara)
                            {{ $lecturer->negara }}
                        @else
                            <span class="text-xs text-amber-600 italic font-medium">(Kosong)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm">
                        @if($lecturer->subject_1)
                            {{ $lecturer->subject_1 }}
                            @if($lecturer->subject_2)<div class="text-xs text-gray-500">+ {{ $lecturer->subject_2 }}</div>@endif
                        @else
                            <span class="text-xs text-amber-600 italic font-medium">(Kosong)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm">
                        @if($lecturer->email)
                            @if($isEmailValid)
                                <div>{{ $lecturer->email }}</div>
                            @else
                                <div class="font-mono text-xs text-rose-700 font-semibold">{{ $lecturer->email }}</div>
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 mt-1" title="{{ $emailInvalidReason }}">
                                    <i class='bx bx-error-circle'></i> Email Belum Fix
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Email Kosong
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center text-sm text-gray-700">
                        @if($lecturer->tahun)
                            {{ $lecturer->tahun }}
                        @else
                            <span class="text-xs text-amber-600 italic font-medium">(Kosong)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center text-sm">{{ $lecturer->activities_count }}</td>
                    <td class="px-4 py-4 text-center">
                        @php
                            $rawEmailStatus = $lecturer->email_status ?: 'not_sent';
                            $isSent = $rawEmailStatus === 'sent';
                            $isQueued = in_array($rawEmailStatus, ['queued', 'sending'], true);
                            $isFailed = $rawEmailStatus === 'failed';

                            if ($isSent) {
                                $emailClass = 'bg-green-50 text-green-700 border border-green-200';
                                $emailLabel = 'Sudah Terkirim';
                                $emailIcon = 'bx bx-check';
                            } elseif ($isQueued) {
                                $emailClass = 'bg-amber-50 text-amber-700 border border-amber-200';
                                $emailLabel = $rawEmailStatus === 'sending' ? 'Sedang Dikirim' : 'Dalam Antrean';
                                $emailIcon = 'bx bx-time-five';
                            } elseif ($isFailed) {
                                $emailClass = 'bg-red-50 text-red-700 border border-red-200';
                                $emailLabel = 'Gagal';
                                $emailIcon = 'bx bx-x';
                            } else {
                                $emailClass = 'bg-gray-100 text-gray-600 border border-gray-200';
                                $emailLabel = 'Belum Terkirim';
                                $emailIcon = 'bx bx-envelope';
                            }
                        @endphp
                        <div class="flex flex-col items-center gap-1">
                            <span class="inline-flex items-center justify-center min-w-[105px] px-3 py-1.5 rounded-lg text-xs font-medium {{ $emailClass }}">
                                <i class='{{ $emailIcon }} mr-1'></i>
                                {{ $emailLabel }}
                            </span>
                            @if($isSent && $lecturer->email_sent_at)
                                <span class="text-[10px] text-gray-400">{{ $lecturer->email_sent_at->format('d M Y, H:i') }}</span>
                            @elseif($isFailed && $lecturer->email_error)
                                <span title="{{ $lecturer->email_error }}" class="text-[10px] text-red-500 cursor-help">Lihat error</span>
                            @endif
                        </div>
                    </td>
                    @if($showActions)
                        <td class="px-3 py-4 text-center align-middle">
                            <div class="flex items-center justify-center gap-1 min-w-[105px]">
                                <a href="{{ route('admin_pemeringkatan.international-lecture.show', $lecturer->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 transition hover:bg-blue-50 hover:text-blue-600 focus:outline-none"
                                   title="Lihat" aria-label="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-[18px] w-[18px]" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6S2.25 12 2.25 12Z"/>
                                        <circle cx="12" cy="12" r="2.75"/>
                                    </svg>
                                </a>

                                <a href="{{ route('admin_pemeringkatan.international-lecture.edit', $lecturer->id) }}"
                                   onclick="try{sessionStorage.setItem('intl_lecture_show_table', 'true')}catch(e){}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 transition hover:bg-amber-50 hover:text-amber-600 focus:outline-none"
                                   title="Edit" aria-label="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-[18px] w-[18px]" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 3.487 3.65 3.65M4.5 19.5l3.91-.782L19.58 7.548a2.25 2.25 0 0 0-3.182-3.182L5.228 15.455 4.5 19.5Z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin_pemeringkatan.international-lecture.destroy', $lecturer->id) }}" method="POST" class="delete-form inline-flex">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="delete-btn inline-flex h-8 w-8 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50 hover:text-red-600 focus:outline-none"
                                            title="Hapus" aria-label="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-[18px] w-[18px]" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7.5h15M9.75 10.5v6M14.25 10.5v6M6.75 7.5l.75 12h9l.75-12M9 7.5V5.25h6V7.5"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr><td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-500">Belum ada data dosen asing.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($lecturers->hasPages())
        @php
            $lecturers->appends(array_merge(request()->query(), $persistQuery ?? []));
            if (!empty($filterAnchor)) {
                $lecturers->fragment($filterAnchor);
            }
        @endphp
        <div class="p-4 border-t">{{ $lecturers->links() }}</div>
    @endif
</div>
