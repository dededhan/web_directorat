{{-- File Upload Field Component --}}
<div class="border border-gray-200 rounded-lg p-4 hover:border-{{ $color }}-400 transition-colors duration-200">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
    </label>
    
    @if(isset($lampiran[$aspek][$key]))
        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-sm text-green-700">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium break-all">{{ basename($lampiran[$aspek][$key]->path) }}</span>
                </div>
                <div class="flex gap-2 ml-2 flex-shrink-0">
                    <a href="{{ route('subdirektorat-inovasi.dosen.katsinov-v2.lampiran.preview', ['katsinov_id' => $katsinov->id, 'lampiran_id' => $lampiran[$aspek][$key]->id]) }}" 
                       target="_blank"
                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat
                    </a>
                   
                    @if($katsinov->status === 'draft')
                        <button type="button" onclick="deleteFile({{ $lampiran[$aspek][$key]->id }}, '{{ $aspek }}', '{{ $key }}')"
                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    @else
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded cursor-not-allowed" title="Tidak dapat menghapus file (status: {{ $katsinov->status }})">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Terkunci
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    <input type="file" name="{{ $aspek }}[{{ $key }}]" accept=".pdf,.doc,.docx"
           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-{{ $color }}-50 file:text-{{ $color }}-700 hover:file:bg-{{ $color }}-100"
           @if($katsinov->status !== 'draft') disabled @endif>
    <p class="mt-1 text-xs text-gray-500">
        @if($katsinov->status !== 'draft')
            <span class="text-orange-600 font-medium">⚠️ Form terkunci (status: {{ $katsinov->status }}), tidak dapat mengubah file</span>
        @else
            {{ isset($lampiran[$aspek][$key]) ? 'Upload file baru untuk mengganti' : 'Format: PDF, DOC, DOCX (Max: 50MB)' }}
        @endif
    </p>
    
    @error($aspek.'.'.$key)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
