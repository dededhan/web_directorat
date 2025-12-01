@extends('layouts.pemeringkatan')

@section('title', 'Indikator Pemeringkatan')

@push('styles')
    @vite(['resources/css/home.css', 'resources/css/pemeringkatan/indikator.css', 'resources/css/admin/ckeditor-list.css'])
@endpush

@section('content')
    <a href="{{ route('pemeringkatan.ranking-unj.index') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Rankings
    </a>
    <div class="page-title">
        Indikator Penilaian
    </div>

    <div class="info-section">
        <div class="info-sidebar">
            <ul>
                @forelse ($indikators as $index => $indikator)
                    <li>
                        <a href="#indikator-{{ $indikator->id }}" class="{{ $index === 0 ? 'active' : '' }}">
                            {{ $indikator->judul }}
                        </a>
                    </li>
                @empty
                    <li><a href="#default" class="active">Default</a></li>
                @endforelse
            </ul>
        </div>

        <!-- Content Area -->
        @if ($indikators->isNotEmpty())
            <div class="info-content" id="indikator-{{ $indikators->first()->id }}">
                <h2>{{ $indikators->first()->judul }}</h2>
                <div class="ck-content">
                    {!! $indikators->first()->deskripsi !!}
                </div>
            </div>
        @else
            <div class="info-content" id="default">
                <h2>Default</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed sapien quam. Sed dapibus est id
                    enim facilisis, at posuere turpis adipiscing. Quisque sit amet dui dui. Duis rhoncus velit nec est
                    condimentum feugiat. Donec aliquam augue nec gravida lobortis. Nunc arcu mi, pretium quis dolor id,
                    iaculis euismod libero. Pellentesque ultricies ante eu velit vulputate, nec mattis justo suscipit.
                </p>
                <p>Curabitur mollis metus in nunc malesuada, vel placerat tellus vestibulum. Maecenas dignissim egestas
                    lacus, ac elementum metus ultrices ac. Vestibulum ante ipsum primis in faucibus orci luctus et
                    ultrices posuere cubilia curae; Nullam quis sapien a nulla venenatis ullamcorper. Suspendisse
                    euismod, mauris non gravida placerat, ipsum velit sollicitudin ipsum.</p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href*="#"]');
            const indikators = @json($indikators);

            for (const link of links) {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');

                    if (href.startsWith('#')) {
                        e.preventDefault();

                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }

                        if (this.closest('.info-sidebar')) {
                            const sidebarLinks = document.querySelectorAll('.info-sidebar a');
                            sidebarLinks.forEach(link => link.classList.remove('active'));
                            this.classList.add('active');

                            const contentArea = document.querySelector('.info-content');
                            contentArea.id = targetId;

                            if (indikators.length > 0) {
                                if (targetId.startsWith('indikator-')) {
                                    const indikatorId = parseInt(targetId.replace('indikator-', ''));
                                    const indikator = indikators.find(item => item.id === indikatorId);

                                    if (indikator) {
                                        contentArea.innerHTML =
                                            `<h2>${indikator.judul}</h2><div class="ck-content">${indikator.deskripsi}</div>`;
                                    }
                                } else {
                                    const labelText = this.textContent.trim();
                                    contentArea.innerHTML =
                                        `<h2>${labelText}</h2><div class="ck-content"><p>Informasi akan segera ditambahkan.</p></div>`;
                                }
                            } else {
                                // Default content when no database entries
                                const labelText = this.textContent.trim();
                                contentArea.innerHTML =
                                    `<h2>${labelText}</h2><div class="ck-content"><p>Informasi akan segera ditambahkan.</p></div>`;
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
