<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG {{ $sdg['number'] }}: {{ $sdg['title'] }} - UNJ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .sdg-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        .year-btn {
            border: 2px solid {{ $sdg['color'] }};
            color: {{ $sdg['color'] }};
            background: white;
            padding: 8px 20px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .year-btn:hover,
        .year-btn.active {
            background-color: {{ $sdg['color'] }};
            color: white;
        }
        .initiative-box {
            border: 2px solid {{ $sdg['color'] }};
            background-color: {{ $sdg['color'] }}10;
            border-radius: 8px;
            padding: 24px;
        }
        .goal-item {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: white;
            transition: all 0.2s;
            overflow: hidden;
        }
        .goal-item-header {
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
        }
        .goal-item-header:hover {
            background-color: #f9fafb;
        }
        .goal-item.active .goal-item-header {
            background-color: #f9fafb;
            border-left: 4px solid {{ $sdg['color'] }};
        }
        .goal-item-title::before {
            content: "›";
            margin-right: 8px;
            font-size: 1.2em;
            font-weight: bold;
        }
        .goal-item-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background-color: #f9fafb;
        }
        .goal-item.active .goal-item-content {
            max-height: 500px;
        }
        .goal-item-body {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
        }
        .chevron {
            transition: transform 0.3s;
        }
        .goal-item.active .chevron {
            transform: rotate(180deg);
        }
        .sdg-icon-large {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layout.navbarpemeringkatan')

    <main class="min-h-screen relative z-0">
        <section class="sdg-header py-8 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-700 mb-2">Our actions and goals</h2>
                    <p class="text-gray-500">Click the SDG Goals to read the initiatives</p>
                </div>

                <div class="flex justify-center gap-2 mb-8 flex-wrap">
                    @for ($i = 1; $i <= 17; $i++)
                        <a href="{{ route('sdg.detail', $i) }}" class="transform hover:scale-110 transition-transform">
                            <img src="{{ asset('images/sdgs/sdg-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.jpg') }}" 
                                 alt="SDG {{ $i }}" 
                                 class="w-16 h-16 {{ $i == $sdg['number'] ? 'ring-4 ring-blue-500' : '' }}">
                        </a>
                    @endfor
                </div>
            </div>
        </section>

        <section class="py-12 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row gap-8 items-start mb-12">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/sdgs/sdg-' . str_pad($sdg['number'], 2, '0', STR_PAD_LEFT) . '.jpg') }}" 
                             alt="SDG {{ $sdg['number'] }}" 
                             class="sdg-icon-large rounded-lg shadow-lg">
                    </div>
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">SDG {{ $sdg['number'] }}: {{ $sdg['title'] }}</h1>
                        <p class="text-lg text-gray-600 mb-6">{{ $sdg['subtitle'] }}</p>
                        
                        <div class="flex gap-3 mb-6">
                            @foreach ($years as $year)
                                <button class="year-btn {{ $loop->first ? 'active' : '' }}" data-year="{{ $year }}">
                                    {{ $year }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="initiative-box mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $sdg['featured_initiative']['title'] }}</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $sdg['featured_initiative']['description'] }}</p>
                </div>

                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Our Goals in Action</h2>
                    
                    @foreach ($sdg['goals'] as $goalCategory)
                        <div class="mb-12">
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $goalCategory['category'] }}</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $goalCategory['description'] }}</p>
                            </div>

                            <div class="space-y-3">
                                @foreach ($goalCategory['items'] as $index => $item)
                                    <div class="goal-item">
                                        <div class="goal-item-header">
                                            <span class="goal-item-title">{{ $item }}</span>
                                            <svg class="chevron w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        <div class="goal-item-content">
                                            <div class="goal-item-body">
                                                <h5 class="font-semibold text-gray-800 mb-2">Program Description</h5>
                                                <p class="text-gray-700 mb-3">
                                                    This initiative focuses on {{ strtolower($item) }} through comprehensive programs and strategic partnerships. We implement evidence-based approaches to ensure maximum impact and sustainable outcomes for all stakeholders involved.
                                                </p>
                                                <h5 class="font-semibold text-gray-800 mb-2">Key Activities</h5>
                                                <ul class="list-disc list-inside text-gray-700 space-y-1 mb-3">
                                                    <li>Regular monitoring and evaluation of program effectiveness</li>
                                                    <li>Collaboration with local and international partners</li>
                                                    <li>Capacity building workshops for students and staff</li>
                                                    <li>Development of innovative solutions and best practices</li>
                                                </ul>
                                                <h5 class="font-semibold text-gray-800 mb-2">Impact Metrics (2024)</h5>
                                                <div class="grid grid-cols-3 gap-4 text-center">
                                                    <div class="bg-white p-3 rounded border">
                                                        <div class="text-2xl font-bold" style="color: {{ $sdg['color'] }}">{{ 150 + ($index * 50) }}+</div>
                                                        <div class="text-xs text-gray-600">Beneficiaries</div>
                                                    </div>
                                                    <div class="bg-white p-3 rounded border">
                                                        <div class="text-2xl font-bold" style="color: {{ $sdg['color'] }}">{{ 10 + $index }}</div>
                                                        <div class="text-xs text-gray-600">Programs</div>
                                                    </div>
                                                    <div class="bg-white p-3 rounded border">
                                                        <div class="text-2xl font-bold" style="color: {{ $sdg['color'] }}">{{ 85 + ($index * 2) }}%</div>
                                                        <div class="text-xs text-gray-600">Success Rate</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.year-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.year-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        document.querySelectorAll('.goal-item-header').forEach(header => {
            header.addEventListener('click', function() {
                const goalItem = this.closest('.goal-item');
                const isActive = goalItem.classList.contains('active');
                
                document.querySelectorAll('.goal-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                if (!isActive) {
                    goalItem.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
