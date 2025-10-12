<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\ProgramLayanan;
use App\Models\Dokumen;
use App\Models\Youtube;
use App\Models\Instagram;
use App\Models\Sustainability;
use App\Models\MataKuliah;
use App\Models\AlumniBerdampak;
use App\Models\RespondenAnswer;
use App\Models\InternationalStudent;
use App\Models\Akreditasi;
use App\Models\InternationalFacultyStaff;
use App\Models\Katsinov;
use App\Models\ProdukInovasi;
use App\Models\ProgramKegiatan;
use App\Models\PublikasiRiset;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Card configuration for different admin modules
        $cardConfig = collect([
            [
                'key' => 'berita',
                'label' => 'Berita',
                'icon' => 'bxs-news',
                'route' => route('admin.news.index'),
                'description' => 'Kelola berita dan artikel',
                'model' => Berita::class,
            ],
            [
                'key' => 'users',
                'label' => 'Users',
                'icon' => 'bxs-user',
                'route' => route('admin.manageuser.index'),
                'description' => 'Manajemen pengguna sistem',
                'model' => User::class,
            ],
            [
                'key' => 'program_layanan',
                'label' => 'Program & Layanan',
                'icon' => 'bx-list-ul',
                'route' => route('admin.program-layanan.index'),
                'description' => 'Program dan layanan direktorat',
                'model' => ProgramLayanan::class,
            ],
            [
                'key' => 'dokumen',
                'label' => 'Dokumen',
                'icon' => 'bxs-file',
                'route' => route('admin.document.index'),
                'description' => 'Manajemen dokumen',
                'model' => Dokumen::class,
            ],
            [
                'key' => 'sustainability',
                'label' => 'Sustainability',
                'icon' => 'bxs-leaf',
                'route' => route('admin.sustainability.index'),
                'description' => 'Data sustainability',
                'model' => Sustainability::class,
            ],
            [
                'key' => 'responden',
                'label' => 'Responden',
                'icon' => 'bxs-user-voice',
                'route' => route('admin.responden.index'),
                'description' => 'Data responden dan jawaban',
                'model' => RespondenAnswer::class,
            ],
            [
                'key' => 'mahasiswa_international',
                'label' => 'Mahasiswa International',
                'icon' => 'bxs-graduation',
                'route' => route('admin.mahasiswainternational.index'),
                'description' => 'Data mahasiswa internasional',
                'model' => InternationalStudent::class,
            ],
            [
                'key' => 'katsinov',
                'label' => 'Katsinov',
                'icon' => 'bxs-bulb',
                'route' => route('admin.katsinov.TableKatsinov'),
                'description' => 'Katalis inovasi',
                'model' => Katsinov::class,
            ],
            [
                'key' => 'sdgs_program',
                'label' => 'SDGs Program',
                'icon' => 'bx-planet',
                'route' => route('admin.SDGs.program-kegiatan.index'),
                'description' => 'Program dan kegiatan SDGs',
                'model' => ProgramKegiatan::class,
            ],
            [
                'key' => 'sdgs_publikasi',
                'label' => 'SDGs Publikasi',
                'icon' => 'bx-file-find',
                'route' => route('admin.SDGs.publikasi-riset.index'),
                'description' => 'Publikasi dan riset SDGs',
                'model' => PublikasiRiset::class,
            ],
        ]);

        // Get counts for each module
        $counts = [];
        foreach ($cardConfig as $card) {
            $counts[$card['key']] = $card['model']::count();
        }

        // Build summary cards with totals
        $summaryCards = $cardConfig
            ->map(function (array $card) use ($counts) {
                $card['total'] = $counts[$card['key']] ?? 0;
                return $card;
            })
            ->values();

        // Build recent activities
        $recentItems = $this->buildRecentActivities($summaryCards->keyBy('key'));
        $recentTotal = $recentItems->count();
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage('recent_page');
        $recentActivities = new LengthAwarePaginator(
            $recentItems->forPage($currentPage, $perPage)->values(),
            $recentTotal,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'recent_page',
                'query' => request()->except('recent_page'),
            ]
        );

        $totalRecords = array_sum($counts);
        $activeModules = $summaryCards->where('total', '>', 0)->count();

        return view('admin.dashboardadmin', [
            'user' => $user,
            'summaryCards' => $summaryCards,
            'recentActivities' => $recentActivities,
            'recentTotal' => $recentTotal,
            'totalRecords' => $totalRecords,
            'activeModules' => $activeModules,
        ]);
    }

    private function buildRecentActivities(Collection $cardMap): Collection
    {
        $items = collect();

        // Recent News
        if ($card = $cardMap->get('berita')) {
            $items = $items->merge(
                Berita::latest()
                    ->limit(3)
                    ->get()
                    ->map(fn (Berita $berita) => $this->makeTimelineItem(
                        $card,
                        $berita->title ?: 'Berita Baru',
                        'Published',
                        null,
                        $berita->created_at
                    ))
            );
        }

        // Recent Users
        if ($card = $cardMap->get('users')) {
            $items = $items->merge(
                User::latest()
                    ->limit(3)
                    ->get()
                    ->map(fn (User $user) => $this->makeTimelineItem(
                        $card,
                        $user->name . ' - ' . $user->role,
                        'User Registered',
                        null,
                        $user->created_at
                    ))
            );
        }

        // Recent Documents
        if ($card = $cardMap->get('dokumen')) {
            $items = $items->merge(
                Dokumen::latest()
                    ->limit(3)
                    ->get()
                    ->map(fn (Dokumen $doc) => $this->makeTimelineItem(
                        $card,
                        $doc->nama_dokumen ?: 'Dokumen Baru',
                        'Uploaded',
                        null,
                        $doc->created_at
                    ))
            );
        }

        // Recent Sustainability Data
        if ($card = $cardMap->get('sustainability')) {
            $items = $items->merge(
                Sustainability::latest()
                    ->limit(3)
                    ->get()
                    ->map(fn (Sustainability $sust) => $this->makeTimelineItem(
                        $card,
                        'Data Sustainability',
                        'Created',
                        null,
                        $sust->created_at
                    ))
            );
        }

        // Recent Katsinov
        if ($card = $cardMap->get('katsinov')) {
            $items = $items->merge(
                Katsinov::latest()
                    ->limit(3)
                    ->get()
                    ->map(fn (Katsinov $kat) => $this->makeTimelineItem(
                        $card,
                        $kat->project_name ?: ($kat->title ?: 'Katsinov Entry'),
                        'Created',
                        null,
                        $kat->created_at
                    ))
            );
        }

        // Recent SDGs Programs
        if ($card = $cardMap->get('sdgs_program')) {
            $items = $items->merge(
                ProgramKegiatan::latest()
                    ->limit(3)
                    ->get()
                    ->map(fn (ProgramKegiatan $prog) => $this->makeTimelineItem(
                        $card,
                        $prog->judul ?: 'Program SDGs',
                        'Created',
                        null,
                        $prog->created_at
                    ))
            );
        }

        return $items
            ->filter(fn (array $item) => $item['created_at'] !== null)
            ->sortByDesc('created_at')
            ->values();
    }

    private function makeTimelineItem(array $card, string $title, ?string $status, ?string $note, $createdAt): array
    {
        return [
            'feature' => $card['label'],
            'title' => $title,
            'status' => $status ?: 'Created',
            'status_color' => $this->statusColor($status ?: 'Created'),
            'note' => $note ? trim($note) : null,
            'created_at' => $createdAt,
            'manage_url' => $card['route'],
        ];
    }

    private function statusColor(string $status): string
    {
        $statusLower = strtolower($status);

        return match (true) {
            str_contains($statusLower, 'published') ||
            str_contains($statusLower, 'approved') ||
            str_contains($statusLower, 'completed') => 'bg-emerald-100 text-emerald-700',

            str_contains($statusLower, 'uploaded') ||
            str_contains($statusLower, 'created') ||
            str_contains($statusLower, 'registered') => 'bg-blue-100 text-blue-700',

            str_contains($statusLower, 'pending') ||
            str_contains($statusLower, 'review') => 'bg-amber-100 text-amber-700',

            str_contains($statusLower, 'rejected') ||
            str_contains($statusLower, 'deleted') => 'bg-rose-100 text-rose-700',

            default => 'bg-gray-100 text-gray-700',
        };
    }
}
