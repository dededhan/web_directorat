@extends('layouts.pemeringkatan')

@section('title', 'International Faculty & Staff')

@push('styles')
    <style>
        .faculty-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .faculty-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .stat-card {
            background: linear-gradient(135deg, #176369 0%, #277177 100%);
        }
    </style>
@endpush

@section('content')
    <main class="min-h-screen relative z-0 bg-gray-50">
        <!-- Hero Section -->
        <section class="relative bg-cover bg-center py-24" style="background-image: linear-gradient(rgba(23, 99, 105, 0.8), rgba(39, 113, 119, 0.8)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920');">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">International Faculty & Staff</h1>
                <p class="text-xl text-white/90">Enhancing Global Academic Excellence</p>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-12 -mt-12 relative z-10">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="stat-card rounded-lg p-8 text-white text-center shadow-lg">
                        <div class="text-5xl font-bold mb-2">{{ $stats['adjunctProfessors'] ?? 0 }}</div>
                        <div class="text-lg opacity-90">Adjunct Professors</div>
                    </div>
                    <div class="stat-card rounded-lg p-8 text-white text-center shadow-lg">
                        <div class="text-5xl font-bold mb-2">{{ $stats['fullTimeProfessors'] ?? 0 }}</div>
                        <div class="text-lg opacity-90">Full-Time Professors</div>
                    </div>
                    <div class="stat-card rounded-lg p-8 text-white text-center shadow-lg">
                        <div class="text-5xl font-bold mb-2">{{ $stats['uniqueUniversities'] ?? 0 }}</div>
                        <div class="text-lg opacity-90">Partner Universities</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Faculty Staff Section -->
        <section class="py-12">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our International Faculty Members</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Meet our distinguished international faculty members who contribute to academic excellence and global perspectives.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($facultyStaffs as $staff)
                        <div class="faculty-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="aspect-w-3 aspect-h-4 bg-gray-200">
                                @if($staff->foto_path)
                                    <img src="{{ Storage::url($staff->foto_path) }}" alt="{{ $staff->nama }}" class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 flex items-center justify-center bg-gradient-to-br from-teal-600 to-teal-700">
                                        <span class="text-white text-5xl font-bold">{{ substr($staff->nama, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $staff->nama }}</h3>
                                <p class="text-teal-600 font-medium mb-2">{{ $staff->universitas_asal }}</p>
                                <p class="text-gray-600 text-sm mb-3">{{ $staff->bidang_keahlian }}</p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full">{{ ucfirst($staff->category) }}</span>
                                    <span class="text-gray-500">{{ $staff->tahun }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">No faculty staff data available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Activities Section -->
        @if(isset($activities) && $activities->count() > 0)
        <section class="py-12 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Recent Activities</h2>
                    <p class="text-gray-600">Collaborative activities and programs with our international faculty</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($activities as $activity)
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $activity->judul }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($activity->deskripsi, 150) }}</p>
                            <div class="text-sm text-teal-600">{{ $activity->tanggal }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>
@endsection
