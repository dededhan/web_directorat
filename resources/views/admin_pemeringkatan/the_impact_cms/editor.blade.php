@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')

<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('admin_pemeringkatan.the-impact-cms.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-800">
            <span class="inline-block w-12 h-12 rounded-full text-white flex items-center justify-center text-xl font-bold mr-3" 
                  style="background-color: {{ $sdg->color }};">{{ $sdg->number }}</span>
            {{ $sdg->title }}
        </h1>
        @if($sdg->subtitle)
        <p class="text-gray-600 mt-1 ml-14">{{ $sdg->subtitle }}</p>
        @endif
    </div>
    <a href="{{ route('admin_pemeringkatan.the-impact-cms.content.create', $sdg->id) }}" 
       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Konten Root
    </a>
</div>

<!-- Content Tree -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">Struktur Konten</h2>
        <span class="text-sm text-gray-500">Total: {{ $sdg->rootContents->count() }} konten root</span>
    </div>

    @if($sdg->rootContents->count() === 0)
        <div class="text-center py-16 border-2 border-dashed border-gray-300 rounded-lg">
            <i class="fas fa-folder-open text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg mb-2">Belum ada konten</p>
            <p class="text-gray-400 text-sm">Klik "Tambah Konten Root" untuk memulai</p>
        </div>
    @else
        <div class="space-y-2">
            @foreach($sdg->rootContents as $content)
                @include('admin_pemeringkatan.the_impact_cms.partials.content_item', ['content' => $content, 'sdg' => $sdg])
            @endforeach
        </div>
    @endif
</div>

@endsection
