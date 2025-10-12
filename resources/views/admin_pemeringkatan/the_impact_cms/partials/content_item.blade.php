<div class="content-item mb-2">
    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
        <div class="flex items-center space-x-3 flex-1">
            <span class="font-semibold text-blue-600">{{ $content->point_number }}</span>
            <span class="font-medium">{{ $content->title }}</span>
            <span class="text-xs px-2 py-1 rounded {{ $content->content_type === 'text' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                {{ $content->content_type }}
            </span>
            @if($content->year)
                <span class="text-xs px-2 py-1 rounded bg-purple-100 text-purple-700">
                    <i class="fas fa-calendar-alt mr-1"></i>{{ $content->year }}
                </span>
            @endif
            @if($content->children->count() > 0)
                <span class="text-xs text-gray-500">({{ $content->children->count() }} sub)</span>
            @endif
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="moveContentModal({{ $content->id }}, '{{ $content->point_number }}', {{ $content->sdg_id }}, {{ $content->parent_id ?? 'null' }})"
                    class="text-purple-600 hover:text-purple-800 px-3 py-1 text-sm inline-flex items-center">
                <i class="fas fa-arrows-alt mr-1"></i> Pindah
            </button>
            <a href="{{ route('admin_pemeringkatan.the-impact-cms.content.create', ['sdg' => $sdg->id, 'parent_id' => $content->id]) }}" 
               class="text-green-600 hover:text-green-800 px-3 py-1 text-sm inline-flex items-center">
                <i class="fas fa-plus-circle mr-1"></i> Sub
            </a>
            <a href="{{ route('admin_pemeringkatan.the-impact-cms.content.edit', $content->id) }}" 
               class="text-blue-600 hover:text-blue-800 px-3 py-1 text-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    
    <!-- Children -->
    @if($content->children->count() > 0)
        <div class="ml-8 mt-2 space-y-2">
            @foreach($content->children as $child)
                @include('admin_pemeringkatan.the_impact_cms.partials.content_item', ['content' => $child, 'sdg' => $sdg])
            @endforeach
        </div>
    @endif
</div>
