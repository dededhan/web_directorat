@extends('layouts.pemeringkatan')

@section('title', 'Struktur Organisasi - DITISIP UNJ')

@push('styles')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .org-chart-container {
        overflow-x: auto;
        overflow-y: auto;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,.1);
    }

    .org-chart-svg {
        min-width: 100%;
        height: auto;
        display: block;
    }

    .org-node {
        filter: drop-shadow(0 2px 4px rgba(0,0,0,.1));
        transition: .3s;
    }

    .org-node:hover {
        filter: drop-shadow(0 6px 12px rgba(0,0,0,.2));
    }

    .connector-line {
        stroke: #64748b;
        stroke-width: 2;
        fill: none;
        stroke-linecap: round;
    }

    @media (max-width:768px){
        .org-chart-container{
            min-height:400px;
        }
    }
</style>
@endpush

@section('content')
<main class="w-full px-4 lg:px-8 pt-24 pb-8 lg:pt-12 lg:pb-12">

    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-teal-800 uppercase tracking-wider mb-2">
            Struktur Organisasi
        </h1>
        <p class="text-slate-600 text-lg" style="margin-bottom: 80px;">
            Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan
        </p>
    </div>

    <!-- Chart Container with Alpine -->
    <div x-data="organizationChartView()" class="space-y-4">
        <!-- Loading State -->
        <div x-show="loading" class="flex justify-center items-center py-20">
            <div class="flex flex-col items-center gap-4">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-600"></div>
                <p class="text-slate-600">Memuat struktur organisasi...</p>
            </div>
        </div>

        <!-- Main Chart -->
        <div x-show="!loading && members.length" class="w-full bg-white rounded-lg shadow-lg overflow-hidden border-2 border-gray-300 rounded-xl shadow-sm">
            <div class="bg-white rounded-t-lg px-6 py-4 border-b border-teal-200 flex items-center justify-between">
                <p class="text-sm text-slate-600"> Scroll ke samping untuk melihat seluruh struktur organisasi </p>
                <div class="flex items-center gap-2">
                    <button @click="zoomOut" class="w-9 h-9 rounded-lg border bg-white hover:bg-gray-100" :disabled="zoom <= minZoom">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button @click="zoomIn" class="w-9 h-9 rounded-lg border bg-white hover:bg-gray-100" :disabled="zoom >= maxZoom">
                        <i class="fas fa-search-plus"></i>
                    </button>
                </div>
            </div>

            <div class="relative overflow-auto h-[83vh] bg-gray-50">
                <div class="relative bg-gray-50" :style="`width:${chartWidth * zoom}px; height:${chartHeight * zoom}px;`">
                    <div class="absolute top-0 left-0 origin-top-left" :style="`transform: scale(${zoom}); width:${chartWidth}px; height:${chartHeight}px;`">

                        <!-- Garis -->
                        <div class="absolute top-0 left-0" :style="{width: chartWidth + 'px', height: chartHeight + 'px'}">
                            <svg :width="chartWidth" :height="chartHeight" x-html="generateSVGLines()"></svg>
                        </div>

                        <!-- Node -->
                        <div class="relative z-10" :style="{width: chartWidth + 'px', height: chartHeight + 'px'}">
                            <template x-for="node in treeNodes" :key="node.id">
                                <div class="absolute" :style="{left: node.x + 'px', top: node.y + 'px'}">
                                    <div class="org-node bg-white border-2 border-teal-500 rounded-lg shadow-md p-3 w-48 text-center">
                                        <!-- Foto -->
                                        <template x-if="node.photo">
                                            <div class="flex justify-center mb-2">
                                                <img :src="'{{ asset('storage') }}/' + node.photo" class="w-20 h-20 rounded-full object-cover border-2 border-teal-500">
                                            </div>
                                        </template>
                                        <template x-if="!node.photo">
                                            <div class="flex justify-center mb-2">
                                                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-400"></i>
                                                </div>
                                            </div>
                                        </template>
                                        <p class="font-semibold text-sm" x-text="node.name"></p>
                                        <p class="text-xs text-teal-600" x-text="node.title"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Data State -->
        <div x-show="!loading && !members.length" class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
            <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl mb-2"></i>
            <p class="text-yellow-800">Struktur organisasi belum tersedia. Silakan hubungi administrator.</p>
        </div>
    </div>

</main>
@endsection

@push('scripts')
<script>
    function organizationChartView() {
        return {
            members: [],
            treeNodes: [],
            connectorLines: [],
            loading: false,
            totalMembers: 0,
            rootMember: null,
            maxLevel: 0,
            chartWidth: 2000,
            chartHeight: 1200,
            canvasPadding: 30,
            zoom: 1,
            minZoom: 0.5,
            maxZoom: 1,
            zoomStep: 0.1,

            init() {
                this.loadMembers();
            },

            async loadMembers() {
                this.loading = true;
                try {
                    const response = await fetch('{{ route("pemeringkatan.struktur-organisasi.tree") }}');
                    const data = await response.json();
                    
                    if (data.success && data.data) {
                        this.members = [data.data];
                        this.totalMembers = this.countMembers(data.data);
                        this.rootMember = data.data;
                        this.maxLevel = this.calculateMaxLevel(data.data);
                        this.recalculateChart();
                    } else {
                        // No root yet, create it if needed
                        this.members = [];
                    }
                } catch (error) {
                    console.error(error);
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

            calculateMaxLevel(node) {
                let max = node.level;
                if (node.children && node.children.length) {
                    for (let child of node.children) {
                        max = Math.max(max, this.calculateMaxLevel(child));
                    }
                }
                return max;
            },

            recalculateChart() {
                this.treeNodes = [];
                this.connectorLines = [];
                if (!this.members.length) return;
                this.calculateNodePositions();
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
                        parentTitles.some(title => parent.title.toLowerCase().includes(title)) &&
                        childTitles.some(title => node.title.toLowerCase().includes(title))
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
                this.$nextTick(() => {
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
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
                    });
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
@endpush