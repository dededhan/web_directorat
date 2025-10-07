<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ApcSubmission;
use App\Models\ComdevSubmission;
use App\Models\FeeEditorReport;
use App\Models\FeeReviewerReport;
use App\Models\Katsinov;
use App\Models\MatchmakingSubmission;
use App\Models\PresentingReport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cardConfig = collect([
            [
                'key' => 'katsinov',
                'label' => 'Katsinov',
                'icon' => 'bxs-bulb',
                'route' => route('subdirektorat-inovasi.dosen.tablekatsinov'),
                'description' => 'Monitor evaluasi Katalis Inovasi.',
            ],
            [
                'key' => 'comdev',
                'label' => 'Community Development',
                'icon' => 'bxs-group',
                'route' => route('subdirektorat-inovasi.dosen.equity.manajement.index'),
                'description' => 'Kelola proposal dan status pendampingan.',
            ],
            [
                'key' => 'apc',
                'label' => 'Article Processing Cost',
                'icon' => 'bxs-file-doc',
                'route' => route('subdirektorat-inovasi.dosen.apc.manajemen'),
                'description' => 'Pantau pengajuan biaya publikasi.',
            ],
            [
                'key' => 'fee_reviewer',
                'label' => 'Insentif Reviewer',
                'icon' => 'bxs-award',
                'route' => route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen'),
                'description' => 'Lacak insentif reviewer jurnal.',
            ],
            [
                'key' => 'fee_editor',
                'label' => 'Insentif Editor',
                'icon' => 'bxs-edit',
                'route' => route('subdirektorat-inovasi.dosen.fee_editor.manajemen'),
                'description' => 'Lacak insentif editorial board.',
            ],
            [
                'key' => 'presenting',
                'label' => 'Bantuan Presentasi',
                'icon' => 'bxs-slideshow',
                'route' => route('subdirektorat-inovasi.dosen.presenting.manajemen'),
                'description' => 'Kelola dukungan konferensi.',
            ],
            [
                'key' => 'matchmaking',
                'label' => 'Matchmaking Research',
                'icon' => 'bx-git-merge',
                'route' => route('subdirektorat-inovasi.dosen.matchresearch.manajemen'),
                'description' => 'Awasi kolaborasi riset.',
            ],
        ]);

        $counts = [
            'katsinov' => Katsinov::where('user_id', $user->id)->count(),
            'comdev' => ComdevSubmission::where('user_id', $user->id)->count(),
            'apc' => ApcSubmission::where('user_id', $user->id)->count(),
            'fee_reviewer' => FeeReviewerReport::where('user_id', $user->id)->count(),
            'fee_editor' => FeeEditorReport::where('user_id', $user->id)->count(),
            'presenting' => PresentingReport::where('user_id', $user->id)->count(),
            'matchmaking' => MatchmakingSubmission::where('user_id', $user->id)->count(),
        ];

        $summaryCards = $cardConfig
            ->map(function (array $card) use ($counts) {
                $card['total'] = $counts[$card['key']] ?? 0;

                return $card;
            })
            ->values();

        $recentItems = $this->buildRecentSubmissions($user->id, $summaryCards->keyBy('key'));
        $recentTotal = $recentItems->count();
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage('recent_page');
        $recentSubmissions = new LengthAwarePaginator(
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
        $totalSubmissions = array_sum($counts);
        $activePrograms = $summaryCards->where('total', '>', 0)->count();

        return view('subdirektorat-inovasi.dosen.dashboard', [
            'user' => $user,
            'summaryCards' => $summaryCards,
            'recentSubmissions' => $recentSubmissions,
            'recentTotal' => $recentTotal,
            'totalSubmissions' => $totalSubmissions,
            'activePrograms' => $activePrograms,
        ]);
    }

    private function buildRecentSubmissions(int $userId, Collection $cardMap): Collection
    {
        $items = collect();

        if ($card = $cardMap->get('katsinov')) {
            $items = $items->merge(
                Katsinov::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (Katsinov $submission) => $this->makeTimelineItem(
                        $card,
                        $submission->project_name ?: ($submission->title ?: 'Pengajuan Katsinov'),
                        null,
                        null,
                        $submission->created_at
                    ))
            );
        }

        if ($card = $cardMap->get('comdev')) {
            $items = $items->merge(
                ComdevSubmission::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (ComdevSubmission $submission) => $this->makeTimelineItem(
                        $card,
                        $submission->judul ?: 'Proposal Community Development',
                        $submission->status?->label(),
                        null,
                        $submission->created_at
                    ))
            );
        }

        if ($card = $cardMap->get('apc')) {
            $items = $items->merge(
                ApcSubmission::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (ApcSubmission $submission) => $this->makeTimelineItem(
                        $card,
                        $submission->judul_artikel ?: 'Pengajuan APC',
                        $submission->status,
                        $submission->catatan_revisi,
                        $submission->created_at
                    ))
            );
        }

        if ($card = $cardMap->get('fee_reviewer')) {
            $items = $items->merge(
                FeeReviewerReport::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (FeeReviewerReport $report) => $this->makeTimelineItem(
                        $card,
                        $report->judul_artikel ?: 'Laporan Reviewer',
                        $report->status,
                        $report->catatan_admin,
                        $report->created_at
                    ))
            );
        }

        if ($card = $cardMap->get('fee_editor')) {
            $items = $items->merge(
                FeeEditorReport::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (FeeEditorReport $report) => $this->makeTimelineItem(
                        $card,
                        $report->nama_jurnal ?: 'Laporan Editor',
                        $report->status,
                        $report->catatan_admin,
                        $report->created_at
                    ))
            );
        }

        if ($card = $cardMap->get('presenting')) {
            $items = $items->merge(
                PresentingReport::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (PresentingReport $report) => $this->makeTimelineItem(
                        $card,
                        $report->nama_conference ?: ($report->judul_artikel ?: 'Pengajuan Presentasi'),
                        $report->status,
                        $report->status_note,
                        $report->created_at
                    ))
            );
        }

        if ($card = $cardMap->get('matchmaking')) {
            $items = $items->merge(
                MatchmakingSubmission::where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn (MatchmakingSubmission $submission) => $this->makeTimelineItem(
                        $card,
                        $submission->judul_proposal ?: 'Pengajuan Matchmaking',
                        $submission->status,
                        $submission->rejection_note,
                        $submission->created_at
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
        $statusLabel = $this->formatStatus($status);

        return [
            'feature' => $card['label'],
            'title' => $title,
            'status' => $statusLabel,
            'status_color' => $this->statusColor($statusLabel),
            'note' => $note ? trim($note) : null,
            'created_at' => $createdAt,
            'manage_url' => $card['route'],
        ];
    }

    private function formatStatus(?string $status): string
    {
        if (!$status) {
            return 'Pengajuan dibuat';
        }

        return Str::headline($status);
    }

    private function statusColor(string $status): string
    {
        $statusLower = Str::lower($status);

        return match (true) {
            str_contains($statusLower, 'selesai') ||
            str_contains($statusLower, 'disetujui') ||
            str_contains($statusLower, 'diterima') ||
            str_contains($statusLower, 'lolos') => 'bg-emerald-100 text-emerald-700',

            str_contains($statusLower, 'menunggu') ||
            str_contains($statusLower, 'proses') ||
            str_contains($statusLower, 'review') ||
            str_contains($statusLower, 'verifikasi') ||
            str_contains($statusLower, 'diajukan') ||
            str_contains($statusLower, 'pengajuan') => 'bg-blue-100 text-blue-700',

            str_contains($statusLower, 'revisi') ||
            str_contains($statusLower, 'perbaikan') => 'bg-amber-100 text-amber-700',

            str_contains($statusLower, 'tolak') ||
            str_contains($statusLower, 'batal') => 'bg-rose-100 text-rose-700',

            default => 'bg-gray-100 text-gray-700',
        };
    }
}
