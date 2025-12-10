@extends('layouts.pemeringkatan')

@section('title', 'Subdirektorat Pemeringkatan dan Sistem Informasi')

@push('styles')
    {{-- Landing Page V2 Styles --}}
    @vite('resources/css/pemeringkatan/landing/landing-v2.css')
    
    <style>
        /* Global Font */
        body, p, h1, h2, h3, h4, h5, h6, span, div, a, button, input, textarea, select, label {
            font-family: 'Inter', Arial, sans-serif !important;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Section scroll offset for fixed navbar */
        section {
            scroll-margin-top: 80px;
        }
        
        /* Navbar scroll effect */
        .navbar.scrolled {
            background-color: rgba(39, 113, 119, 0.95) !important;
            backdrop-filter: blur(10px);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            transition: all 0.3s ease;
        }
        
        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    {{-- Hero Section --}}
    @include('pemeringkatan.landing-sections.hero')
    
    {{-- Stats Section --}}
    @include('pemeringkatan.landing-sections.stats', ['stats' => $stats])
    
    {{-- Featured Rankings Section --}}
    @include('pemeringkatan.landing-sections.featured-rankings', ['featuredRankings' => $featuredRankings])
    
    {{-- Programs Section --}}
    @include('pemeringkatan.landing-sections.programs')
    
    {{-- News Section --}}
    @include('pemeringkatan.landing-sections.news', ['regularNews' => $regularNews])
    
    {{-- CTA Section --}}
    @include('pemeringkatan.landing-sections.cta')
@endsection

@push('scripts')
    {{-- Landing Page V2 Scripts --}}
    @vite('resources/js/pemeringkatan/landing/landing-v2.js')
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });
        
        // Sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarClose = document.getElementById('sidebar-close');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    document.body.classList.toggle('sidebar-open');
                });
            }
            
            if (sidebarClose && sidebar) {
                sidebarClose.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    document.body.classList.remove('sidebar-open');
                });
            }
        });
    </script>
@endpush
