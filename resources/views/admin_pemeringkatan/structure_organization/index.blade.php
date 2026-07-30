@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="space-y-6" x-data="organizationChart()">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manajemen Struktur Organisasi</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola struktur dan bagan organisasi</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="font-semibold text-teal-600">Manajemen Struktur Organisasi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="space-y-6">

        <!-- Main Content: Chart & List -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Org Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Bagan Organisasi</h2>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 max-w-[95rem] mx-auto overflow-auto h-[70vh]">
                    <div id="orgChartContainer" class="relative" class="inline-block min-w-full" :style="`width:${chartWidth * zoom}px; height:${chartHeight * zoom}px;`">
                        <div class="absolute top-0 left-0 origin-top-left" :style="`transform: scale(${zoom}); width:${chartWidth}px; height:${chartHeight}px;`">
                            <!-- SVG -->
                            <div class="absolute top-0 left-0" :style="{width: chartWidth + 'px', height: chartHeight + 'px'}">
                                <svg :width="chartWidth" :height="chartHeight" x-html="generateSVGLines()"></svg>
                            </div>

                            <!-- Nodes -->
                            <div class="relative z-10" :style="{ width: chartWidth + 'px', height: chartHeight + 'px' }">
                                <template x-for="node in treeNodes" :key="node.id">
                                    <div class="absolute" :style="{ left: node.x + 'px', top: node.y + 'px' }">
                                        <div class="org-node bg-white border-2 border-teal-500 rounded-lg shadow-md p-3 w-48 text-center hover:shadow-lg transition-shadow cursor-pointer" @click="editMember(node.id)" :class="node.level === 0 ? 'border-teal-600 border-4 bg-teal-50' : ''">
                                            <!-- Foto -->
                                            <template x-if="node.photo">
                                                <div class="mb-2 flex justify-center">
                                                    <img :src="'{{ asset('storage') }}/' + node.photo" class="w-20 h-20 rounded-full object-cover object-center border-2 border-teal-500 shadow-sm">
                                                </div>
                                            </template>
                                            <template x-if="!node.photo">
                                                <div class="mb-2 flex justify-center">
                                                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300">
                                                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                                                    </div>
                                                </div>
                                            </template>
                                            <!-- Nama -->
                                            <p class="font-semibold text-sm text-gray-900 whitespace-normal break-words" x-text="node.name"></p>
                                            <!-- Jabatan -->
                                            <p class="text-xs text-teal-600 font-medium mb-2 whitespace-normal break-words" x-text="node.title"></p>
                                            <!-- Action Buttons -->
                                            <div class="flex items-center justify-center gap-1">
                                                <div class="flex items-center justify-center">
                                                    <button @click.stop="moveLeft(node.id)" class="text-gray-600 hover:text-teal-600 text-xs mr-3" title="Geser ke kiri">
                                                        <i class="fas fa-arrow-left text-lg"></i>
                                                    </button>
                                                    <div class="flex gap-2">
                                                        <button @click.stop="editMember(node.id)" class="text-blue-500 hover:text-blue-700 text-xs flex items-center gap-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button @click.stop="deleteMember(node.id)" class="text-red-500 hover:text-red-700 text-xs flex items-center gap-1">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                    <button @click.stop="moveRight(node.id)" class="text-gray-600 hover:text-teal-600 text-xs ml-3" title="Geser ke kanan">
                                                        <i class="fas fa-arrow-right text-lg"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-t-lg px-6 py-4 border-b border-teal-200 flex items-center justify-between">
                    <p class="text-sm text-slate-600">💡 Klik kotak untuk edit. Scroll ke samping untuk melihat struktur lengkap.</p>
                    <div class="flex items-center gap-2">
                        <button @click="zoomOut" class="w-9 h-9 rounded-lg border bg-white hover:bg-gray-100" :disabled="zoom <= minZoom">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button @click="zoomIn" class="w-9 h-9 rounded-lg border bg-white hover:bg-gray-100" :disabled="zoom >= maxZoom">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <!-- Info -->
                <div class="flex-1 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Info Sistem
                    </h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li><strong>Total Anggota:</strong> <span x-text="totalMembers"></span></li>
                        <li><strong>Pimpinan Tertinggi:</strong> <span x-text="rootMember ? rootMember.name : '-'"></span></li>
                    </ul>
                </div>
                <!-- Tombol -->
                <div class="lg:w-auto">
                    <button @click="openForm()" class="bg-teal-600 text-white px-6 py-3 rounded-lg hover:bg-teal-700 transition-colors flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-plus"></i> Tambah Anggota
                    </button>
                </div>
            </div>

            <!-- List Table -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Daftar Anggota</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-center px-4 py-2 font-semibold text-gray-700 w-16">No</th>
                                <th class="text-left px-4 py-2 font-semibold text-gray-700">Nama</th>
                                <th class="text-left px-4 py-2 font-semibold text-gray-700">Jabatan</th>
                                <th class="text-left px-4 py-2 font-semibold text-gray-700">Atasan</th>
                                <th class="text-center px-4 py-2 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(member, index) in sortedFlatMembers" :key="member.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <!-- Nomor -->
                                    <td class="px-4 py-2 text-center" x-text="index + 1"></td>
                                    <!-- Nama -->
                                    <td class="px-4 py-2" x-text="'  '.repeat(member.level) + member.name"></td>
                                    <td class="px-4 py-2 text-gray-600" x-text="member.title"></td>
                                    <td class="px-4 py-2 text-gray-600" x-text="member.parentName || '-'"></td>
                                    <td class="px-4 py-2 text-center space-x-2">
                                        <button @click="editMember(member.id)" class="text-blue-500 hover:text-blue-700 text-xs font-medium">Edit</button>
                                        <button @click="deleteMember(member.id)" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Form -->
        <div x-show="showForm" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40 p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4" x-text="editingId ? 'Edit Anggota' : 'Tambah Anggota Baru'"></h2>
                <form @submit.prevent="saveMember()" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Nama dan Gelar* </label>
                        <input type="text" x-model="form.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Nama lengkap" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Jabatan* </label>
                        <input type="text" x-model="form.title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Jabatan" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Atasan </label>
                        <select x-model="form.parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value=""> -- Pilih Atasan - Kosongkan jika tidak ada -- </option>
                            <template x-for="member in getParentOptions()" :key="member.id">
                                <option :value="member.id" x-text="member.name + ' (' + member.title + ')'"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> Foto </label>
                        <input x-ref="photoInput" type="file" @change="handlePhotoUpload($event)" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1"> Max 5MB. Format: JPG, PNG, GIF </p>
                        <p class="text-xs text-blue-600 mt-1"> Disarankan menggunakan foto persegi (1:1) dengan wajah berada di tengah agar hasil pada bagan organisasi terlihat seimbang dan rapi. </p>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="flex-1 bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition-colors font-medium">
                            <span x-show="!editingId">Tambah</span>
                            <span x-show="editingId">Simpan</span>
                        </button>
                        <button type="button" @click="closeForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium"> Batal </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div x-show="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-600 mx-auto mb-4"></div>
                <p class="text-gray-700">Loading...</p>
            </div>
        </div>
    </div>
</div>

<script>
function organizationChart() {
    return {
        members: [],
        showForm:false,
        form: {
            name: '',
            title: '',
            parent_id: '',
            photo: null,
        },
        editingId: null,
        loading: false,
        treeNodes: [],
        flatMembers: [],
        connectorLines: [],
        totalMembers: 0,
        rootMember: null,
        chartWidth: 2000,
        chartHeight: 1200,
        canvasPadding: 30,
        zoom: 1,
        minZoom: 0.5,
        maxZoom: 1,
        zoomStep: 0.1,

        init() {
            this.loadMembers();
            // Trigger chart recalculation
            this.$watch('members', () => this.recalculateChart(), { deep: true });
        },

        async loadMembers() {
            this.loading = true;
            try {
                const response = await fetch('{{ route("admin_pemeringkatan.structure-organization.tree") }}');
                const data = await response.json();
                if (data.success && data.data) {
                    this.members = [data.data];
                    this.totalMembers = this.countMembers(data.data);
                    this.rootMember = data.data;
                    this.recalculateChart();
                } else {
                    // No root yet, create it if needed
                    this.members = [];
                }
            } catch (error) {
                alert('Error loading');
            } finally {
                this.loading = false;
            }
        },

        countMembers(node) {
            let count = 1;
            if (node.children && node.children.length) {
                for (let child of node.children) {
                    count += this.countMembers(child);
                }
            }
            return count;
        },

        recalculateChart() {
            this.treeNodes = [];
            this.flatMembers = [];
            this.connectorLines = [];
            if (!this.members.length) return;
            this.calculateNodePositions();
            this.buildFlatMembersList();
        },

        calculateNodePositions() {
            const nodeWidth = 200;
            const defaultHeight = 140;
            const siblingGap = 70;
            const padding = this.canvasPadding;
            const levelGap = 60;
            let currentX = padding;
            // menyimpan tinggi terbesar tiap level
            const levelHeights = {};
            const walk = (node, level = 0) => {
                if (!node.children || node.children.length === 0) {
                    node._x = currentX;
                    currentX += nodeWidth + siblingGap;
                } else {
                    node.children.forEach(child => walk(child, level + 1));
                    node._x =
                        (node.children[0]._x +
                        node.children[node.children.length - 1]._x) / 2;
                }
                node._level = level;
                let visualLevel = node.level;
                const parent = this.findNodeInTree(this.members[0], node.parent_id);
                const parentTitles = ["direktur", "direktor"];
                const childTitles = ["staf", "driver"];
                if (
                    parent &&
                    parentTitles.some(title =>
                        parent.title.toLowerCase().includes(title)
                    ) &&
                    childTitles.some(title =>
                        node.title.toLowerCase().includes(title)
                    )
                ) {
                    visualLevel++;
                }
                this.treeNodes.push({
                    id: node.id,
                    name: node.name,
                    title: node.title,
                    photo: node.photo,
                    level: node.level,
                    visualLevel: visualLevel,
                    x: node._x,
                    y: 0,
                    width: nodeWidth,
                    height: defaultHeight
                });
                levelHeights[level] = Math.max(
                    levelHeights[level] || defaultHeight,
                    defaultHeight
                );
            };
            walk(this.members[0]);

            // center horizontal
            const minX = Math.min(...this.treeNodes.map(n => n.x));
            const maxX = Math.max(...this.treeNodes.map(n => n.x));
            const usedWidth = maxX - minX + nodeWidth;
            const extraSpace =
                (this.chartWidth - usedWidth) / 2 - minX;
            if (extraSpace > 0) {
                this.treeNodes.forEach(node => {
                    node.x += extraSpace;
                });
                const shiftTree = node => {
                    node._x += extraSpace;
                    if (node.children)
                        node.children.forEach(shiftTree);
                };
                shiftTree(this.members[0]);
            }
            // tinggi sementara
            let currentY = padding;
            Object.keys(levelHeights)
                .sort((a,b)=>a-b)
                .forEach(level=>{
                    this.treeNodes
                        .filter(n=>n.visualLevel==level)
                        .forEach(n=>{
                            n.y=currentY;
                        });
                    currentY += levelHeights[level] + levelGap;
                });
            this.chartWidth =
                currentX - siblingGap + padding;
            this.chartHeight =
                currentY + padding;
            // baca tinggi card asli
            this.$nextTick(()=>{
                document.querySelectorAll(".org-node")
                    .forEach((el,index)=>{
                        this.treeNodes[index].height =
                            el.offsetHeight;
                    });
                // hitung ulang tinggi tiap level
                const realLevelHeights={};
                this.treeNodes.forEach(node=>{

                    realLevelHeights[node.visualLevel]=Math.max(
                        realLevelHeights[node.visualLevel]||0,
                        node.height
                    );
                });
                let y=padding;
                Object.keys(realLevelHeights)
                    .sort((a,b)=>a-b)
                    .forEach(level=>{
                        this.treeNodes
                            .filter(n=>n.visualLevel==level)
                            .forEach(n=>{
                                n.y=y;
                            });
                        y+=realLevelHeights[level]+levelGap;
                    });
                this.chartHeight=y+padding;
                this.calculateConnectorLines();
            });
        },

        calculateConnectorLines() {
            const connectorOffset = 30;
            const processedParents = new Set();
            this.treeNodes.forEach(node => {
                // Find children
                const childrenOfThisNode = this.treeNodes.filter(n => {
                    // Find node in original tree
                    const original = this.findNodeInTree(this.members[0], n.id);
                    if (original && Number(original.parent_id) === Number(node.id)) return true;
                    return false;
                });
                if (childrenOfThisNode.length > 0 && !processedParents.has(node.id)) {
                    processedParents.add(node.id);
                    const parentCenterX = node.x + node.width / 2;
                    const parentBottomY = node.y + node.height;
                    // Vertical line from parent
                    const midY = parentBottomY + connectorOffset;
                    const line = {
                        id: node.id,
                        x1: parentCenterX,
                        y1: parentBottomY,
                        x2: parentCenterX,
                        y2: midY,
                        x3: childrenOfThisNode[0].x + childrenOfThisNode[0].width / 2,
                        y3: midY,
                        x4: childrenOfThisNode[childrenOfThisNode.length - 1].x + childrenOfThisNode[childrenOfThisNode.length - 1].width / 2,
                        y4: midY,
                        childLines: [],
                    };

                    // Lines to each child
                    childrenOfThisNode.forEach(child => {
                        line.childLines.push({
                            id: `${node.id}-${child.id}`,
                            x1: child.x + child.width / 2,
                            y1: midY,
                            x2: child.x + child.width / 2,
                            y2: child.y,
                        });
                    });
                    this.connectorLines.push(line);
                }
            });
        },

        generateSVGLines() {
            let svg = '';
            this.connectorLines.forEach(line => {
                // garis vertikal parent
                svg += `<line x1="${line.x1}" y1="${line.y1}" x2="${line.x2}" y2="${line.y2}" stroke="#374151" stroke-width="2"/>`

                // garis horizontal
                svg += `<line x1="${line.x3}" y1="${line.y3}" x2="${line.x4}" y2="${line.y4}" stroke="#374151" stroke-width="2"/>`;

                // garis menuju anak
                line.childLines.forEach(child => {
                    svg += `<line x1="${child.x1}" y1="${child.y1}" x2="${child.x2}" y2="${child.y2}" stroke="#374151" stroke-width="2"/>`;
                });
            });
            return svg;
        },

        findNodeInTree(node, id) {
            if (node.id === id) return node;
            if (node.children) {
                for (let child of node.children) {
                    const found = this.findNodeInTree(child, id);
                    if (found) return found;
                }
            }
            return null;
        },

        buildFlatMembersList() {
            this.flatMembers = [];
            this.flattenTree(this.members[0], new Map());
        },

        flattenTree(node, memberMap) {
            memberMap.set(node.id, node);
            const parentName = node.parent_id ? memberMap.get(node.parent_id)?.name : null;
            this.flatMembers.push({
                id: node.id,
                name: node.name,
                title: node.title,
                level: node.level,
                parentName: parentName,
            });

            if (node.children) {
                node.children.forEach(child => this.flattenTree(child, memberMap));
            }
        },

        getParentOptions() {
            const options = [];
            if (!this.members.length || !this.members[0]) {
                return options;
            }
            this.collectFlatMembers(this.members[0], options, this.editingId);
            options.sort((a, b) => {
                if (a.level !== b.level) {
                    return a.level - b.level;
                }
                return a.name.localeCompare(b.name);
            });
            return options;
        },

        collectFlatMembers(node, arr, excludeId) {
            if (node.id !== excludeId) {
                arr.push({
                    id: node.id,
                    name: node.name,
                    title: node.title,
                    level: node.level,
                });
            }
            if (node.children) {
                node.children.forEach(child => this.collectFlatMembers(child, arr, excludeId));
            }
        },

        async saveMember() {
            this.loading = true;
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('title', this.form.title);
                if (this.form.parent_id) {
                    formData.append('parent_id', this.form.parent_id);
                }
                if (this.form.photo) {
                    formData.append('photo', this.form.photo);
                }

                let url = '{{ route("admin_pemeringkatan.structure-organization.store") }}';
                let method = 'POST';
                if (this.editingId) {
                    url = `{{ route("admin_pemeringkatan.structure-organization.update", ":id") }}`
                        .replace(':id', this.editingId);
                    method = 'POST';
                    formData.append('_method','PUT');
                }

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData,
                });

                const text = await response.text();

                const data = JSON.parse(text);

                if (data.success) {
                    Alert.success(data.message);
                    this.showForm = false;
                    this.resetForm();
                    await this.loadMembers();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                Alert.error('Error saving');
            } finally {
                this.loading = false;
            }
        },

        editMember(id){
            const member = this.findMemberInFlat(id);
            if(member){
                this.form.name = member.name;
                this.form.title = member.title;
                this.form.parent_id = member.parent_id || '';
                this.form.photo = null;
                this.editingId=id;
                this.showForm=true;
            }
        },

        findMemberInFlat(id) {
            const found = (node) => {
                if (node.id === id) return node;
                if (node.children) {
                    for (let child of node.children) {
                        const result = found(child);
                        if (result) return result;
                    }
                }
                return null;
            };
            return found(this.members[0]);
        },

        async deleteMember(id) {
            const result = await Alert.confirm(
                'Hapus anggota?',
                'Seluruh anggota di bawahnya juga akan terhapus.'
            );

            if (!result.isConfirmed) return;
            this.loading = true;
            try {
                const response = await fetch(`{{ route("admin_pemeringkatan.structure-organization.destroy", ":id") }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                const data = await response.json();

                if (data.success) {
                    Alert.success(data.message);
                    this.loadMembers();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                alert('Error deleting');
            } finally {
                this.loading = false;
            }
        },

        getTitlePriority(title, level) {
            const t = title.toLowerCase();
            if (level === 3) {
                if (t.includes('direktur') || t.includes('direktor')) {
                    return 1;
                }
            }
            if (level >= 4) {
                if (t.includes('sekretaris')) {
                    return 1;
                }
                if (t.includes('kepala')) {
                    return 2;
                }
                if (t.includes('driver')) {
                    return 999;
                }
            }
            return 99;
        },

        handlePhotoUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.photo = file;
            }
        },

        resetForm() {
            this.form = {
                name: '',
                title: '',
                parent_id: '',
                photo: null,
            };
            this.editingId = null;
            if (this.$refs.photoInput) {
                this.$refs.photoInput.value = '';
            }
        },

        openForm(){
            this.resetForm();
            this.showForm=true;
        },

        closeForm(){
            this.showForm=false;
            this.resetForm();
        },

        get sortedFlatMembers() {
            return [...this.flatMembers].sort((a, b) => {
                // 1. Level
                if (a.level !== b.level) {
                    return a.level - b.level;
                }
                // 2. Prioritas jabatan
                const priorityA = this.getTitlePriority(a.title, a.level);
                const priorityB = this.getTitlePriority(b.title, b.level);
                if (priorityA !== priorityB) {
                    return priorityA - priorityB;
                }
                // 3. Nama
                return a.name.localeCompare(b.name);
            });
        },

        async moveLeft(id) {
            this.loading = true;
            try {
                const response = await fetch(
                    `{{ route("admin_pemeringkatan.structure-organization.move-left", ":id") }}`
                        .replace(":id", id),
                    {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                    }
                );
                const data = await response.json();
                if (data.success) {
                    await this.loadMembers();
                }
            } finally {
                this.loading = false;
            }
        },

        async moveRight(id) {
            this.loading = true;
            try {
                const response = await fetch(
                    `{{ route("admin_pemeringkatan.structure-organization.move-right", ":id") }}`
                        .replace(":id", id),
                    {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                    }
                );
                const data = await response.json();
                if (data.success) {
                    await this.loadMembers();
                }
            } finally {
                this.loading = false;
            }
        },

        zoomIn() {
            if (this.zoom < this.maxZoom) {
                this.zoom = Math.min(
                    this.maxZoom,
                    +(this.zoom + this.zoomStep).toFixed(2)
                );
            }
        },

        zoomOut() {
            if (this.zoom > this.minZoom) {
                this.zoom = Math.max(
                    this.minZoom,
                    +(this.zoom - this.zoomStep).toFixed(2)
                );
            }
        },
    };
}
</script>
@endsection