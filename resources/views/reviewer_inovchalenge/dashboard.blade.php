@extends('reviewer_inovchalenge.layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Reviewer Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">Innovation Challenge — Ringkasan tugas review Anda</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                {{-- Assigned --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-5 py-3">
                        <p class="text-white/70 text-xs font-medium uppercase tracking-wider">Total Assigned</p>
                    </div>
                    <div class="p-5 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-800">{{ $assigned }}</span>
                        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-xl text-cyan-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Reviewed --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-5 py-3">
                        <p class="text-white/70 text-xs font-medium uppercase tracking-wider">Sudah Direview</p>
                    </div>
                    <div class="p-5 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-800">{{ $reviewed }}</span>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-double text-xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-3">
                        <p class="text-white/70 text-xs font-medium uppercase tracking-wider">Belum Direview</p>
                    </div>
                    <div class="p-5 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-800">{{ $pending }}</span>
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-xl text-amber-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Action --}}
            <div class="text-center">
                <a href="{{ route('reviewer_inovchalenge.assignments.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-semibold text-sm rounded-xl hover:from-cyan-600 hover:to-cyan-700 transition shadow">
                    <i class="fas fa-tasks mr-2"></i> Lihat Tugas Review
                </a>
            </div>

        </div>
    </div>
@endsection
