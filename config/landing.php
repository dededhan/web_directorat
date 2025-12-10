<?php

return [

    'pemeringkatan' => [
        'hero' => [
            'title' => 'Subdirektorat Pemeringkatan dan Sistem Informasi',
            'subtitle' => 'Mendorong Universitas Negeri Jakarta menuju peringkat dunia melalui data, inovasi, dan kolaborasi global',
            'cta_text' => 'Jelajahi Pemeringkatan UNJ',
            'cta_link' => '/pemeringkatan/ranking-unj',
            'logo_path' => 'images/unj-logo.png',
        ],

        'stats' => [
            'title' => 'Pencapaian Kami',
            'subtitle' => 'Data terkini performa UNJ di kancah internasional',
            'cards' => [
                [
                    'key' => 'totalRankings',
                    'label' => 'Pemeringkatan Tercatat',
                    'icon' => 'fas fa-trophy',
                    'color' => 'yellow',
                ],
                [
                    'key' => 'totalPrograms',
                    'label' => 'Program Internasional',
                    'icon' => 'fas fa-globe',
                    'color' => 'blue',
                ],
                [
                    'key' => 'totalStudents',
                    'label' => 'Mahasiswa Internasional',
                    'icon' => 'fas fa-user-graduate',
                    'color' => 'green',
                ],
                [
                    'key' => 'totalFaculty',
                    'label' => 'Tenaga Pengajar Internasional',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'color' => 'purple',
                ],
            ],
        ],

        'featured_rankings' => [
            'title' => 'Pemeringkatan Universitas Terkini',
            'subtitle' => 'Pencapaian UNJ di berbagai lembaga pemeringkatan internasional',
            'cta_text' => 'Lihat Semua Pemeringkatan',
            'cta_link' => '/pemeringkatan/ranking-unj',
            'limit' => 3,
        ],

        'programs' => [
            'title' => 'Program & Inisiatif Kami',
            'items' => [
                [
                    'title' => 'THE Impact Rankings',
                    'description' => 'Mengukur kontribusi universitas terhadap Sustainable Development Goals (SDGs) PBB',
                    'icon' => 'fas fa-globe-americas',
                    'color' => 'blue',
                    'link' => '/pemeringkatan/the-ir-initiatives',
                ],
                [
                    'title' => 'Program Sustainability',
                    'description' => 'Inisiatif kampus hijau dan berkelanjutan untuk masa depan yang lebih baik',
                    'icon' => 'fas fa-leaf',
                    'color' => 'green',
                    'link' => '/pemeringkatan/sustainability/program',
                ],
            ],
        ],

        'news' => [
            'title' => 'Berita & Pengumuman Terkini',
            'subtitle' => 'Update terbaru seputar pemeringkatan dan pencapaian UNJ',
            'cta_text' => 'Lihat Semua Berita',
            'cta_link' => '/Berita/kategori/pemeringkatan',
            'limit' => 3,
        ],

        'cta' => [
            'title' => 'Bergabunglah dengan Kami dalam Perjalanan Menuju Keunggulan',
            'subtitle' => 'Dapatkan informasi terbaru tentang pemeringkatan dan pencapaian UNJ',
            'buttons' => [
                [
                    'text' => 'Lihat Pemeringkatan',
                    'icon' => 'fas fa-chart-line',
                    'link' => '/pemeringkatan/ranking-unj',
                    'style' => 'primary', // primary or secondary
                ],
                [
                    'text' => 'Baca Berita',
                    'icon' => 'fas fa-newspaper',
                    'link' => '/Berita/kategori/pemeringkatan',
                    'style' => 'secondary',
                ],
            ],
        ],
    ],
];
