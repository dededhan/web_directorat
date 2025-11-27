<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Engagement UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        * { font-family: 'Poppins', sans-serif !important; }
        :root {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        .bg-primary { background-color: var(--primary-color); }
        .text-primary { color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        .bg-accent { background-color: var(--accent-color); }
        .text-accent { color: var(--accent-color); }
        .global-hero { background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434') center/cover no-repeat; height: 500px; display: flex; align-items: center; justify-content: center; color: white; text-align: center; position: relative; margin-bottom: 0; }
        .global-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 5rem; background: linear-gradient(to top, white, transparent); }
        .global-hero-content { max-width: 900px; padding: 2rem; z-index: 10; }
        .global-intro { background-color: white; margin-top: -4rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); position: relative; z-index: 20; padding: 3rem; }
        .global-program { margin-bottom: 2.5rem; padding: 2rem; background-color: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05); transition: all 0.3s ease; border-left: 5px solid var(--primary-color); position: relative; overflow: hidden; }
        .global-program:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); }
        .global-program::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(24, 104, 98, 0.05) 0%, rgba(255, 255, 255, 0) 100%); z-index: 0; }
        .global-program-content { position: relative; z-index: 1; }
        .global-program h3 { color: var(--primary-color); margin-bottom: 1.5rem; display: flex; align-items: center; font-weight: 600; }
        .program-number { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background-color: var(--primary-color); color: white; border-radius: 50%; margin-right: 12px; font-size: 1.1rem; font-weight: 600; flex-shrink: 0; }
        .section-heading { position: relative; display: inline-block; padding-bottom: 1rem; margin-bottom: 2rem; }
        .section-heading::after { content: ''; position: absolute; left: 0; bottom: 0; width: 80px; height: 4px; background-color: var(--accent-color); }
        .list-icon { color: var(--primary-color); margin-right: 8px; }
        .back-to-top { position: fixed; bottom: 2rem; right: 2rem; background-color: var(--primary-color); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; z-index: 100; }
        .back-to-top:hover { background-color: var(--accent-color); color: var(--primary-color); transform: translateY(-5px); }
        .partners-section { padding: 4rem 0; background-color: #f8f9fa; }
        .partner-logo { filter: grayscale(100%); transition: all 0.3s ease; }
        .partner-logo:hover { filter: grayscale(0%); transform: scale(1.1); }

        @media (max-width: 768px) {
            .global-hero { height: 400px; }
            .global-hero h2 { font-size: 1.8rem; }
            .global-intro { padding: 2rem; margin-top: -3rem; }
            .global-program { padding: 1.5rem; }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layout.navbarpemeringkatan')

    <div x-data="{ showBackToTop: false }" @scroll.window="showBackToTop = window.pageYOffset > 500">
        <div class="global-hero">
            <div class="global-hero-content">
                <h2 class="text-5xl font-bold mb-6">Global <span class="text-accent">Engagement</span></h2>
                <p class="text-xl font-light mb-8">Program strategis untuk memperluas jejaring internasional dan meningkatkan reputasi Universitas Negeri Jakarta di kancah global</p>
                <a href="#programs" class="inline-flex items-center justify-center bg-primary hover:bg-accent hover:text-primary px-8 py-3 rounded-full text-white font-medium transition-all duration-300 transform hover:scale-105">
                    <span>Jelajahi Program</span>
                    <i class="fas fa-arrow-down ml-2"></i>
                </a>
            </div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- "TENTANG" SECTION --}}
            <div class="global-intro">
                <h2 class="section-heading text-3xl font-bold text-primary">Tentang Global Engagement</h2>
                <div class="space-y-6 text-gray-700 leading-relaxed">
                    @if(isset($about) && $about)
                        {!! $about->content !!}
                    @else
                        <p>Information about Global Engagement will be available soon. Please check back later.</p>
                    @endif
                </div>
            </div>

            {{-- "PROGRAM" SECTION --}}
            <section id="programs" class="mt-16 mb-20">
                <div class="flex items-center justify-center mb-12">
                    <div class="h-1 bg-primary rounded-full w-12 mr-3"></div>
                    <h2 class="text-4xl font-bold text-primary">Program Global Engagement</h2>
                    <div class="h-1 bg-primary rounded-full w-12 ml-3"></div>
                </div>
                
                <div class="space-y-8">
                    @forelse ($programs ?? [] as $program)
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">{{ $loop->iteration }}</span>
                                {{ $program->title }}
                            </h3>
                            <p class="mb-4 text-gray-700">{{ $program->description }}</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan utama:</p>
                                <div class="space-y-2 ck-content">
                                    {!! $program->objectives !!}
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <div class="space-y-2 ck-content">
                                     {!! $program->activities !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-gray-500">Program details will be available soon.</p>
                    </div>
                    @endforelse
                </div>
            </section>
            
            {{-- "MITRA/PARTNERS" SECTION --}}
            @if(isset($partners) && $partners->isNotEmpty())
            <section id="partners" class="partners-section">
                <div class="container mx-auto px-4">
                    <div class="flex items-center justify-center mb-12">
                        <div class="h-1 bg-primary rounded-full w-12 mr-3"></div>
                        <h2 class="text-4xl font-bold text-primary text-center">Mitra Kami</h2>
                        <div class="h-1 bg-primary rounded-full w-12 ml-3"></div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
                        @foreach ($partners as $partner)
                        <a href="{{ $partner->website_url ?? '#' }}" target="_blank" rel="noopener noreferrer" class="text-center partner-logo">
                            <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="mx-auto h-20 object-contain">
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

        </div>
        
        <a href="#" class="back-to-top" x-show="showBackToTop" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-10" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-10">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    
    @include('layout.footer')
    
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
