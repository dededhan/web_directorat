<?php

namespace App\Exports;

use App\Models\ComdevSubmission;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Str;

class SubmissionsExportcomdev implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $comdevId;
    protected $search;
    protected $status;
    protected $fakultasId;
    protected $prodiId;
     
    private $rowNumber;

    // Terima semua parameter filter dari controller
    public function __construct($comdevId, $search, $status, $fakultasId, $prodiId)
    {
        $this->comdevId = $comdevId;
        $this->search = $search;
        $this->status = $status;
        $this->fakultasId = $fakultasId;
        $this->prodiId = $prodiId;
        $this->rowNumber = 1;
    }

    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        // Logika query ini diambil langsung dari method index() di controller Anda
        // untuk memastikan data yang diekspor konsisten dengan yang ditampilkan.
        $query = ComdevSubmission::where('comdev_proposal_id', $this->comdevId)
            ->with(['user.profile.prodi.fakultas', 'reviews']);

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->prodiId) {
            $query->whereHas('user.profile', function ($profileQuery) {
                $profileQuery->where('prodi_id', $this->prodiId);
            });
        }
        elseif ($this->fakultasId) {
            $query->whereHas('user.profile.prodi', function ($prodiQuery) {
                $prodiQuery->where('fakultas_id', $this->fakultasId);
            });
        }

        // Jangan gunakan paginate() untuk ekspor, tapi tetap urutkan
        return $query->latest();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        // Definisikan judul kolom di file Excel
        return [
            'No',
            'Judul Proposal',
            'Ketua Pengusul',
            'Email Pengusul',
            'Fakultas',
            'Program Studi',
            'Status',
            'Tanggal Diajukan',
            'Review 1 Score',
            'Review 2 Score',
        ];
    }

    /**
    * @param mixed $submission
    * @return array
    */
    public function map($submission): array
    {
        // Format setiap baris data
        $reviewerScores = $this->getReviewerScores($submission);

        return [
            $this->rowNumber++, 
            $submission->judul,
            $submission->user->name ?? 'N/A',
            $submission->user->email ?? 'N/A',
            $submission->user->profile?->prodi?->fakultas?->name ?? 'N/A',
            $submission->user->profile?->prodi?->name ?? 'N/A',
            str_replace('_', ' ', Str::title($submission->status->value ?? '-')),
            $submission->updated_at->isoFormat('D MMMM YYYY, HH:mm'),
            $reviewerScores[0] ?? null,
            $reviewerScores[1] ?? null,
        ];
    }

    private function getReviewerScores($submission)
    {
        if (!$submission->relationLoaded('reviews')) {
            $submission->load('reviews');
        }

        if (!$submission->reviews || $submission->reviews->isEmpty()) {
            return [];
        }

        $scores = [];
        foreach ($submission->reviews as $review) {
            if (!$review->penilaian) {
                continue;
            }

            $penilaianData = is_string($review->penilaian)
                ? json_decode($review->penilaian, true)
                : $review->penilaian;

            if (is_array($penilaianData)) {
                $totalScore = 0;
                $hasScore = false;

                foreach ($penilaianData as $nilai) {
                    if (is_numeric($nilai)) {
                        $totalScore += floatval($nilai);
                        $hasScore = true;
                    }
                }

                if ($hasScore) {
                    $scores[] = round($totalScore, 2);
                } else {
                    $scores[] = null;
                }
            }
        }

        return $scores;
    }
}