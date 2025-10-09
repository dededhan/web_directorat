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
            <h3 class="text-2xl font-bold mb-4" x-text="modalTitle"></h3>
            
            <form @submit.prevent="saveContent">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                        <input type="text" x-model="form.title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Konten</label>
                        <select x-model="form.content_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="text">Text</option>
                            <option value="link">Link</option>
                        </select>
                    </div>

                    <div x-show="form.content_type === 'text'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konten Text</label>
                        <textarea x-model="form.content" rows="6"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <div x-show="form.content_type === 'link'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL Link</label>
                        <input type="url" x-model="form.link_url"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contentEditor', () => ({
        sdgId: {{ $sdg->id }},
        contents: [],
        showModal: false,
        modalTitle: '',
        editingId: null,
        form: {
            title: '',
            content_type: 'text',
            content: '',
            link_url: '',
            parent_id: null
        },

        init() {
            console.log('Editor initialized');
            this.loadContents();
        },

        async loadContents() {
            try {
                console.log('Loading contents for SDG:', this.sdgId);
                const response = await axios.get(`/admin_pemeringkatan/the-impact-cms/${this.sdgId}/contents`);
                console.log('Contents loaded:', response.data);
                this.contents = response.data.map(c => ({...c, showChildren: false}));
            } catch (error) {
                console.error('Error loading contents:', error);
                Swal.fire('Error!', 'Gagal memuat konten', 'error');
            }
        },

        toggleChildren(content) {
            content.showChildren = !content.showChildren;
        },

        renderChildren(children, level = 1) {
            if (!children || children.length === 0) return '';
            
            return children.map(child => {
                const childData = JSON.stringify(child).replace(/"/g, '&quot;');
                return `
                    <div class="content-item ml-${level * 4}">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3 flex-1">
                                <span class="font-semibold text-blue-600">${child.point_number}</span>
                                <span class="font-medium">${child.title}</span>
                                <span class="text-xs px-2 py-1 rounded ${child.content_type === 'text' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'}">
                                    ${child.content_type}
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="window.addSubContent(${child.id})" class="text-green-600 hover:text-green-800 px-2 py-1 text-sm">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <button onclick='window.editContentItem(${childData})' class="text-blue-600 hover:text-blue-800 px-2 py-1 text-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="window.deleteContentItem(${child.id})" class="text-red-600 hover:text-red-800 px-2 py-1 text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        ${child.children && child.children.length > 0 ? this.renderChildren(child.children, level + 1) : ''}
                    </div>
                `;
            }).join('');
        },

        openAddModal(parentId) {
            console.log('Opening add modal, parent:', parentId);
            this.editingId = null;
            this.form = {
                title: '',
                content_type: 'text',
                content: '',
                link_url: '',
                parent_id: parentId
            };
            this.modalTitle = parentId ? 'Tambah Sub Konten' : 'Tambah Konten Root';
            this.showModal = true;
            console.log('Modal opened, showModal:', this.showModal);
        },

        editContent(content) {
            this.editingId = content.id;
            this.form = {
                title: content.title,
                content_type: content.content_type,
                content: content.content || '',
                link_url: content.link_url || '',
                parent_id: content.parent_id
            };
            this.modalTitle = 'Edit Konten';
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        async saveContent() {
            try {
                console.log('Saving content:', this.form);
                
                if (this.editingId) {
                    console.log('Updating content:', this.editingId);
                    const response = await axios.put(`/admin_pemeringkatan/the-impact-cms/content/${this.editingId}`, this.form);
                    console.log('Update response:', response.data);
                    Swal.fire('Berhasil!', 'Konten berhasil diupdate', 'success');
                } else {
                    console.log('Creating new content for SDG:', this.sdgId);
                    const response = await axios.post(`/admin_pemeringkatan/the-impact-cms/${this.sdgId}/content`, this.form);
                    console.log('Create response:', response.data);
                    Swal.fire('Berhasil!', 'Konten berhasil ditambahkan', 'success');
                }
                
                await this.loadContents();
                this.closeModal();
            } catch (error) {
                console.error('Save error:', error);
                const errorMsg = error.response?.data?.message || 'Gagal menyimpan konten';
                Swal.fire('Error!', errorMsg, 'error');
            }
        },

        async deleteContent(id) {
            const result = await Swal.fire({
                title: 'Hapus konten?',
                text: 'Konten dan semua sub-kontennya akan dihapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                try {
                    await axios.delete(`/admin_pemeringkatan/the-impact-cms/content/${id}`);
                    Swal.fire('Berhasil!', 'Konten berhasil dihapus', 'success');
                    this.loadContents();
                } catch (error) {
                    Swal.fire('Error!', 'Gagal menghapus konten', 'error');
                }
            }
        }
    }));
});

// Global functions for nested children actions
window.addSubContent = function(parentId) {
    const editor = Alpine.$data(document.querySelector('[x-data]'));
    if (editor && editor.openAddModal) {
        editor.openAddModal(parentId);
    }
};

window.editContentItem = function(content) {
    const editor = Alpine.$data(document.querySelector('[x-data]'));
    if (editor && editor.editContent) {
        editor.editContent(content);
    }
};

window.deleteContentItem = function(id) {
    const editor = Alpine.$data(document.querySelector('[x-data]'));
    if (editor && editor.deleteContent) {
        editor.deleteContent(id);
    }
};
</script>
@endpush

@endsection
