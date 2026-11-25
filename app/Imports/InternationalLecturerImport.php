<?php

namespace App\Imports;

use App\Models\AktivitasDosenAsing;
use App\Models\DosenInternasional;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Import data Dosen Internasional tanpa membuat record dosen ganda.
 *
 * Prinsip:
 * - Satu dosen = satu record pada dosen_internasionals.
 * - Jika nama/email dosen muncul beberapa kali di Excel karena memiliki
 *   kegiatan atau tahun yang berbeda, record dosen hanya dibuat/diperbarui
 *   satu kali dan setiap kegiatan disimpan ke tabel aktivitas dosen asing.
 * - Baris kegiatan yang benar-benar sama tidak dimasukkan dua kali.
 * - Header Excel boleh memiliki variasi penamaan; kolom dipetakan melalui alias.
 */
class InternationalLecturerImport
{
    private bool $duplicatesMerged = false;

    /**
     * Import workbook dosen UNJ yang terdiri dari banyak sheet dan posisi
     * header yang berbeda-beda. Jangan mengandalkan WithHeadingRow untuk
     * workbook ini; header dideteksi per sheet lalu dikirim ke collection().
     */
    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);

        try {
            if (!$this->duplicatesMerged) {
                $this->mergeExistingDuplicateLecturers();
                $this->duplicatesMerged = true;
            }

            foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                $sheetName = trim((string) $worksheet->getTitle());

                if (in_array(mb_strtolower($sheetName), ['rekap', 'rekapitulasi'], true)) {
                    continue;
                }

                $rows = $worksheet->toArray(null, true, true, false);
                if (!$rows) {
                    continue;
                }

                $headerIndex = $this->detectHeaderRow($rows);
                if ($headerIndex === null) {
                    continue;
                }

                $headers = $this->buildHeaders($rows[$headerIndex]);
                if (!$this->hasLecturerHeader($headers)) {
                    continue;
                }

                $faculty = $this->detectFaculty($rows, $sheetName);
                $data = [];

                for ($i = $headerIndex + 1, $count = count($rows); $i < $count; $i++) {
                    $raw = $rows[$i];
                    $assoc = [];

                    foreach ($headers as $columnIndex => $header) {
                        if ($header === null || $header === '') {
                            continue;
                        }
                        $assoc[$header] = $raw[$columnIndex] ?? null;
                    }

                    if (($assoc['fakultas'] ?? null) === null || trim((string) $assoc['fakultas']) === '') {
                        $assoc['fakultas'] = $faculty;
                    }

                    $data[] = $assoc;
                }

                $this->processRows(collect($data));
            }
        } finally {
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }
    }

    private function detectHeaderRow(array $rows): ?int
    {
        $limit = min(15, count($rows));
        $bestIndex = null;
        $bestScore = 0;

        for ($i = 0; $i < $limit; $i++) {
            $score = 0;
            $hasName = false;

            foreach ($rows[$i] as $value) {
                $header = $this->normalizeHeader((string) $value);
                if ($header === '') {
                    continue;
                }

                if (in_array($header, ['nama_dosen_asing', 'nama_dosen', 'lecturer_name', 'name', 'full_name'], true)) {
                    $hasName = true;
                    $score += 5;
                }

                if (in_array($header, [
                    'jenis_kelamin', 'jabatan', 'institusi_asal', 'universitas_asal',
                    'negara', 'subject', 'jenis_kegiatan', 'nama_kegiatan',
                    'prodi_unit_penyelenggara', 'email_institusi_dosen_asing',
                    'tanggal_kegiatan', 'tahun', 'tahun_kegiatan', 'link_bukti_kegiatan'
                ], true)) {
                    $score++;
                }
            }

            if ($hasName && $score > $bestScore) {
                $bestScore = $score;
                $bestIndex = $i;
            }
        }

        return $bestIndex;
    }

    private function buildHeaders(array $headerRow): array
    {
        $headers = [];
        $used = [];

        foreach ($headerRow as $index => $value) {
            $header = $this->normalizeHeader((string) $value);
            if ($header === '') {
                $headers[$index] = null;
                continue;
            }

            $candidate = $header;
            $suffix = 2;
            while (isset($used[$candidate])) {
                $candidate = $header . '_' . $suffix++;
            }

            $used[$candidate] = true;
            $headers[$index] = $candidate;
        }

        return $headers;
    }

    private function hasLecturerHeader(array $headers): bool
    {
        foreach ($headers as $header) {
            if (in_array($header, ['nama_dosen_asing', 'nama_dosen', 'lecturer_name', 'name', 'full_name'], true)) {
                return true;
            }
        }
        return false;
    }

    private function detectFaculty(array $rows, string $sheetName): string
    {
        foreach (array_slice($rows, 0, 3) as $row) {
            foreach ($row as $value) {
                $text = trim((string) $value);
                if ($text === '') {
                    continue;
                }
                if (preg_match('/^Fakultas\s*:\s*(.+)$/iu', $text, $m)) {
                    return trim($m[1]);
                }
            }
        }

        $map = [
            'fip' => 'Fakultas Ilmu Pendidikan',
            'fmipa' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
            'ft' => 'Fakultas Teknik',
            'fbs' => 'Fakultas Bahasa dan Seni',
            'feb' => 'Fakultas Ekonomi dan Bisnis',
            'fish' => 'Fakultas Ilmu Sosial dan Hukum',
            'fikk' => 'Fakultas Ilmu Keolahragaan dan Kesehatan',
            'fpsi' => 'Fakultas Psikologi',
            'sps' => 'Sekolah Pascasarjana',
            'kui' => 'Kantor Urusan Internasional',
        ];

        return $map[mb_strtolower($sheetName)] ?? $sheetName;
    }
    public array $summary = [
        'created' => 0,
        'updated' => 0,
        'skipped' => 0,
        'activities_created' => 0,
        'activities_skipped' => 0,
        'merged_rows' => 0,
        'unchanged' => 0,
        'rows_read' => 0,
        'rows_with_name' => 0,
        'incomplete_rows' => [],
        'errors' => [],
    ];

    private function processRows(Collection $rows): void
    {
        if (!$this->duplicatesMerged) {
            // Rapikan data lama sekali saja untuk satu workbook.
            $this->mergeExistingDuplicateLecturers();
            $this->duplicatesMerged = true;
        }

        foreach ($rows as $index => $rawRow) {
            $this->summary['rows_read']++;
            // collection() pada importer ini menerima array associative yang
            // dibentuk sendiri oleh import(). Jadi jangan selalu memanggil
            // toArray() karena array PHP tidak memiliki method tersebut.
            $rawArray = is_array($rawRow)
                ? $rawRow
                : (method_exists($rawRow, 'toArray') ? $rawRow->toArray() : (array) $rawRow);

            $row = $this->normalizeRow($rawArray);
            $excelRow = $index + 2;

            if ($this->rowIsEmpty($row)) {
                // Baris kosong murni diabaikan tanpa dianggap sebagai error.
                continue;
            }

            $this->summary['rows_with_name']++;

            $missing = $this->missingRequiredFields($row);
            if ($missing) {
                $this->summary['skipped']++;
                $this->summary['incomplete_rows'][] = [
                    'row' => $excelRow,
                    'missing' => $missing,
                    'name' => $row['nama'] ?? ($row['first_name'] ?? ''),
                ];
                continue;
            }

            try {
                // Simpan/update DOSEN terlebih dahulu. Proses kegiatan sengaja
                // dipisahkan agar kegagalan satu kegiatan tidak me-rollback
                // dosen yang baru saja dibuat. Dengan begitu, jika dosen pernah
                // dihapus dari website tetapi masih ada di Excel, import berikutnya
                // akan membuatnya kembali.
                $lecturer = DB::transaction(function () use ($row): DosenInternasional {
                    $lecturer = $this->findLecturer($row);

                    if ($lecturer) {
                        $wasChanged = $this->updateLecturerIfNeeded($lecturer, $row);
                        if ($wasChanged) {
                            $this->summary['updated']++;
                        } else {
                            $this->summary['unchanged']++;
                        }
                        $this->summary['merged_rows']++;
                        return $lecturer->fresh();
                    }

                    $lecturer = new DosenInternasional();
                    // forceFill dipakai agar field penting seperti negara tidak
                    // hilang hanya karena $fillable pada model teman belum lengkap.
                    $lecturer->forceFill($this->lecturerAttributes($row));
                    $lecturer->save();
                    $this->summary['created']++;

                    return $lecturer->fresh();
                });

                // Kegiatan tidak boleh menentukan berhasil/gagalnya penyimpanan
                // data dosen. Jika kegiatan bermasalah, dosennya tetap tersimpan.
                try {
                    $this->importActivity($lecturer, $row);
                } catch (\Throwable $activityError) {
                    $this->summary['errors'][] = sprintf(
                        'Kegiatan pada baris %d dilewati: %s',
                        $excelRow,
                        $activityError->getMessage()
                    );
                }
            } catch (\Throwable $e) {
                $this->summary['errors'][] = sprintf(
                    'Baris %d: %s',
                    $excelRow,
                    $e->getMessage()
                );
                $this->summary['skipped']++;
            }
        }
    }

    private function findLecturer(array $row): ?DosenInternasional
    {
        $email = $this->normalizeEmail($row['email'] ?? null);
        $name = $this->normalizeName($row['nama'] ?? null);
        $university = $this->normalizeText($row['universitas_asal'] ?? null);
        $country = $this->normalizeText($row['negara'] ?? null);

        // Email adalah identitas terkuat jika tersedia.
        if ($email !== '') {
            $lecturer = DosenInternasional::whereRaw('LOWER(TRIM(email)) = ?', [$email])->first();
            if ($lecturer) {
                return $lecturer;
            }
        }

        if ($name === '') {
            return null;
        }

        // Cari nama yang sama. Normalisasi dilakukan di PHP supaya variasi
        // titik/koma/honorific seperti "Prof. Dr." dan "Prof Dr" tetap cocok.
        $candidates = DosenInternasional::query()
            ->select('*')
            ->where('nama', 'like', '%' . $this->firstNameToken($name) . '%')
            ->get()
            ->filter(fn ($candidate) => $this->normalizeName($candidate->nama) === $name);

        if ($candidates->isEmpty()) {
            return null;
        }

        // Jika ada beberapa record dengan nama sama, pilih yang paling lengkap.
        // Ini membuat record kosong/incomplete tidak menjadi record baru.
        $sameContext = $candidates->filter(function ($candidate) use ($university, $country) {
            $sameUniversity = $university === '' || $this->normalizeText($candidate->universitas_asal) === $university;
            $sameCountry = $country === '' || $this->normalizeText($candidate->negara) === $country;
            return $sameUniversity && $sameCountry;
        });

        $pool = $sameContext->isNotEmpty() ? $sameContext : $candidates;

        return $pool->sortByDesc(fn ($candidate) => $this->lecturerCompletenessScore($candidate))->first();
    }

    private function mergeExistingDuplicateLecturers(): void
    {
        $lecturers = DosenInternasional::query()->orderBy('id')->get();
        $groups = [];

        foreach ($lecturers as $lecturer) {
            $key = $this->normalizeName($lecturer->nama);
            if ($key === '') {
                continue;
            }
            $groups[$key][] = $lecturer;
        }

        foreach ($groups as $name => $duplicates) {
            if (count($duplicates) < 2) {
                continue;
            }

            usort($duplicates, function ($a, $b) {
                $scoreCompare = $this->lecturerCompletenessScore($b) <=> $this->lecturerCompletenessScore($a);
                return $scoreCompare !== 0 ? $scoreCompare : ($a->id <=> $b->id);
            });

            $primary = $duplicates[0];

            foreach (array_slice($duplicates, 1) as $duplicate) {
                // Jika nama sama, gabungkan. Record yang lebih lengkap menjadi
                // primary sehingga email/kegiatan tidak hilang.
                $this->mergeLecturerIntoPrimary($primary, $duplicate);
                $this->summary['merged_rows']++;
            }
        }
    }

    private function mergeLecturerIntoPrimary(DosenInternasional $primary, DosenInternasional $duplicate): void
    {
        DB::transaction(function () use ($primary, $duplicate): void {
            $columns = [
                'email', 'jenis_kelamin', 'jabatan', 'universitas_asal', 'negara',
                'subject_1', 'fakultas', 'prodi', 'bidang_keahlian',
                'status', 'email_status', 'email_sent_at',
                'email_error', 'consent_token', 'consent_status', 'consented_at',
                'tahun', 'sesi', 'link_bukti_kegiatan',
            ];

            $changes = [];
            foreach ($columns as $column) {
                $current = $primary->{$column} ?? null;
                $incoming = $duplicate->{$column} ?? null;

                if (($current === null || trim((string) $current) === '' || trim((string) $current) === 'Belum Diisi')
                    && $incoming !== null && trim((string) $incoming) !== '' && trim((string) $incoming) !== 'Belum Diisi') {
                    $changes[$column] = $incoming;
                }
            }

            if ($changes) {
                $primary->update($changes);
            }

            // Pindahkan seluruh kegiatan ke primary, tanpa menggandakan kegiatan
            // yang sudah ada di primary.
            $duplicateActivities = $duplicate->activities()->get();
            foreach ($duplicateActivities as $activity) {
                $activityDate = null;
                if ($activity->tanggal) {
                    try {
                        $activityDate = Carbon::parse($activity->tanggal)->toDateString();
                    } catch (\Throwable) {
                        $activityDate = (string) $activity->tanggal;
                    }
                }

                $exists = $primary->activities()
                    ->whereDate('tanggal', $activityDate)
                    ->whereRaw("LOWER(TRIM(COALESCE(jenis_kegiatan, ''))) = ?", [mb_strtolower(trim((string) $activity->jenis_kegiatan))])
                    ->whereRaw("LOWER(TRIM(COALESCE(judul, ''))) = ?", [mb_strtolower(trim((string) $activity->judul))])
                    ->exists();

                if (!$exists) {
                    $activity->dosen_internasional_id = $primary->id;
                    $activity->save();
                } else {
                    $activity->delete();
                }
            }

            $duplicate->delete();
        });
    }

    private function lecturerCompletenessScore(DosenInternasional $lecturer): int
    {
        $columns = [
            'nama', 'email', 'jenis_kelamin', 'jabatan', 'universitas_asal', 'negara',
            'subject_1', 'subject_2', 'fakultas', 'prodi', 'bidang_keahlian',
            'status',
        ];

        $score = 0;
        foreach ($columns as $column) {
            if ($lecturer->{$column} !== null && trim((string) $lecturer->{$column}) !== '') {
                $score++;
            }
        }

        try {
            $score += min(3, (int) $lecturer->activities()->count());
        } catch (\Throwable) {
            // Jika relasi belum tersedia, skor tetap berdasarkan kolom dosen.
        }

        return $score;
    }

    private function firstNameToken(string $normalizedName): string
    {
        $parts = preg_split('/\s+/', trim($normalizedName));
        return $parts[0] ?? $normalizedName;
    }

    private function updateLecturerIfNeeded(DosenInternasional $lecturer, array $row): bool
    {
        $attributes = $this->lecturerAttributes($row, true);
        $changes = [];

        foreach ($attributes as $column => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $current = $lecturer->{$column};
            if ($current === null || trim((string) $current) === '' || trim((string) $current) === 'Belum Diisi') {
                $changes[$column] = $value;
            }
        }

        if ($changes) {
            $lecturer->forceFill($changes);
            $lecturer->save();
            return true;
        }

        return false;
    }

    private function normalizeGender(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $val = mb_strtolower(trim($value));
        if (in_array($val, ['l', 'laki-laki', 'laki - laki', 'laki', 'pria', 'male', 'm'], true)) {
            return 'Male';
        }
        if (in_array($val, ['p', 'perempuan', 'wanita', 'female', 'f'], true)) {
            return 'Female';
        }
        return trim($value) !== '' ? trim($value) : null;
    }

    private function lecturerAttributes(array $row, bool $forUpdate = false): array
    {
        // Deteksi tahun dari kolom tahun atau tanggal kegiatan
        $detectedYear = $row['tahun'] ?? $row['tahun_kegiatan'] ?? null;
        if (!$detectedYear) {
            $parsedDate = $this->parseActivityDate($row);
            if ($parsedDate) {
                $detectedYear = (string) $parsedDate->year;
            }
        }

        $fakultasClean = \App\Services\LecturerDataSanitizer::cleanValue($row['fakultas'] ?? null);
        $prodiClean = \App\Services\LecturerDataSanitizer::cleanValue($row['prodi'] ?? null);
        $rawSubject = $row['subject_1'] ?? $row['subject_2'] ?? null;

        $map = [
            'nama' => \App\Services\LecturerDataSanitizer::cleanValue($row['nama'] ?? null),
            'jenis_kelamin' => $this->normalizeGender($row['jenis_kelamin'] ?? null),
            'jabatan' => \App\Services\LecturerDataSanitizer::cleanValue($row['jabatan'] ?? null),
            'universitas_asal' => \App\Services\LecturerDataSanitizer::cleanValue($row['universitas_asal'] ?? null),
            'negara' => \App\Services\LecturerDataSanitizer::normalizeCountry($row['negara'] ?? null),
            'email' => \App\Services\LecturerDataSanitizer::cleanEmail($row['email'] ?? null),
            'subject_1' => \App\Services\LecturerDataSanitizer::normalizeSubject($rawSubject, $fakultasClean, $prodiClean),
            'subject_2' => null,
            'fakultas' => $fakultasClean,
            'prodi' => $prodiClean,
            'bidang_keahlian' => \App\Services\LecturerDataSanitizer::cleanValue($row['bidang_keahlian'] ?? null),
            'status' => \App\Services\LecturerDataSanitizer::cleanValue($row['status'] ?? null),
            'tahun' => \App\Services\LecturerDataSanitizer::cleanValue($detectedYear ? (string) $detectedYear : null),
            'sesi' => \App\Services\LecturerDataSanitizer::cleanValue($row['sesi'] ?? null),
            'link_bukti_kegiatan' => \App\Services\LecturerDataSanitizer::cleanValue($row['link_bukti_kegiatan'] ?? null),
        ];

        if (!$forUpdate) {
            $fallback = 'Belum Diisi';
            foreach (['fakultas', 'prodi', 'negara', 'universitas_asal', 'status', 'bidang_keahlian'] as $requiredColumn) {
                if (!isset($map[$requiredColumn]) || trim((string) $map[$requiredColumn]) === '') {
                    $map[$requiredColumn] = $fallback;
                }
            }
            $map['email_status'] = 'not_sent';
        }

        return array_filter($map, static fn ($value) => $value !== null && $value !== '');
    }

    private function importActivity(DosenInternasional $lecturer, array $row): void
    {
        $activityType = $row['jenis_kegiatan'] ?? $row['kegiatan'] ?? null;
        $title = $row['judul_kegiatan'] ?? $row['judul'] ?? null;
        $description = $row['keterangan'] ?? $row['deskripsi_kegiatan'] ?? $row['isi'] ?? null;
        $date = $this->parseActivityDate($row);

        // Hanya buat riwayat kegiatan jika memang ada informasi kegiatan.
        if (!$activityType && !$title && !$description && !$date) {
            return;
        }

        // Tabel aktivitas pada project teman memakai tanggal, jenis_kegiatan,
        // judul, keterangan/isi. Jika Excel hanya menyediakan tahun, tanggal
        // 1 Januari tahun tersebut digunakan sebagai representasi teknis tahun.
        if (!$date) {
            $date = Carbon::create(now()->year, 1, 1);
        }

        $activityType = $this->cleanString($activityType);
        $title = $this->cleanString($title) ?: ($activityType ?: 'Kegiatan Dosen Asing');
        $description = $this->cleanString($description);
        // Kolom isi pada database teman bersifat wajib. Jangan pernah mengirim
        // NULL; gunakan judul sebagai fallback jika Excel tidak menyediakan isi.
        $activityContent = $description ?: $title;

        $exists = AktivitasDosenAsing::query()
            ->where('dosen_internasional_id', $lecturer->id)
            ->whereDate('tanggal', $date->toDateString())
            ->whereRaw("LOWER(TRIM(COALESCE(jenis_kegiatan, ''))) = ?", [mb_strtolower($activityType ?? '')])
            ->whereRaw("LOWER(TRIM(COALESCE(judul, ''))) = ?", [mb_strtolower($title)])
            ->exists();

        if ($exists) {
            $this->summary['activities_skipped']++;
            return;
        }

        $payload = [
            'tanggal' => $date->toDateString(),
            'jenis_kegiatan' => $activityType ?: 'Kegiatan',
            'judul' => $title,
            'keterangan' => $description ?: $title,
            'isi' => $activityContent,
        ];

        $lecturer->activities()->create($payload);
        $this->summary['activities_created']++;
    }

    private function parseActivityDate(array $row): ?Carbon
    {
        $candidates = [
            $row['tanggal_kegiatan'] ?? null,
            $row['tanggal'] ?? null,
            $row['date'] ?? null,
            $row['activity_date'] ?? null,
            $row['tahun_kegiatan'] ?? null,
            $row['tahun'] ?? null,
            $row['year'] ?? null,
            $row['activity_year'] ?? null,
        ];

        foreach ($candidates as $value) {
            if ($value === null || trim((string) $value) === '') {
                continue;
            }

            if ($value instanceof \DateTimeInterface) {
                return Carbon::instance($value);
            }

            $text = trim((string) $value);

            // Excel serial date.
            if (is_numeric($value) && (float) $value > 30000 && (float) $value < 70000) {
                try {
                    return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value));
                } catch (\Throwable) {
                    // lanjutkan ke pola tahun di bawah
                }
            }

            // Format tanggal yang umum.
            foreach (['Y-m-d', 'd-m-Y', 'd/m/Y', 'm/d/Y', 'd M Y', 'M d Y'] as $format) {
                try {
                    $parsed = Carbon::createFromFormat($format, $text);
                    if ($parsed !== false) {
                        return $parsed;
                    }
                } catch (\Throwable) {
                    // coba format berikutnya
                }
            }

            // Jika hanya tahun atau teks seperti "maret - juni 2026", ambil tahunnya.
            if (preg_match('/\b(19|20)\d{2}\b/', $text, $m)) {
                return Carbon::create((int) $m[0], 1, 1);
            }

            try {
                return Carbon::parse($text);
            } catch (\Throwable) {
                // lanjutkan kandidat berikutnya
            }
        }

        return null;
    }

    private function normalizeRow(array $row): array
    {
        $normalized = [];
        foreach ($row as $key => $value) {
            $normalized[$this->normalizeHeader((string) $key)] = is_string($value)
                ? trim($value)
                : $value;
        }

        $aliases = [
            'nama' => ['nama', 'nama dosen asing', 'nama dosen', 'lecturer name', 'name', 'full name'],
            'first_name' => ['first name', 'firstname', 'nama depan'],
            'last_name' => ['last name', 'lastname', 'nama belakang'],
            'email' => ['email', 'email dosen', 'lecturer email', 'e-mail', 'email address', 'email institusi dosen asing', 'email_institusi_dosen_asing'],
            'jenis_kelamin' => ['jenis kelamin', 'gender', 'sex'],
            'jabatan' => ['jabatan', 'job title', 'job_title', 'position', 'academic position', 'designation'],
            'universitas_asal' => ['institusi asal', 'universitas asal', 'asal institusi', 'university', 'university name', 'institution', 'institution name', 'home institution', 'home university'],
            'negara' => ['negara', 'country', 'country name', 'nationality'],
            'subject_1' => ['subject 1', 'subject', 'subject_1', 'academic subject', 'bidang ilmu', 'bidang study'],
            'subject_2' => ['subject 2', 'subject_2'],
            'fakultas' => ['fakultas', 'faculty', 'faculty name'],
            'prodi' => ['program studi', 'prodi', 'program study', 'study program', 'program', 'department', 'departement', 'prodi/unit penyelenggara', 'prodi_unit_penyelenggara'],
            'bidang_keahlian' => ['bidang keahlian', 'keahlian', 'expertise', 'field of expertise', 'expertise field'],
            'status' => ['status', 'status dosen'],
            'sesi' => ['sesi', 'sesi semester', 'semester', 'session'],
            'link_bukti_kegiatan' => ['link bukti kegiatan', 'bukti kegiatan', 'activity evidence link', 'link', 'link bukti', 'link bukti kegiatan/surat tugas', 'surat tugas'],
            'jenis_kegiatan' => ['jenis kegiatan', 'activity type', 'activity category', 'kategori kegiatan'],
            'kegiatan' => ['kegiatan', 'kegiatan dosen', 'activity', 'activity name'],
            'judul_kegiatan' => ['judul kegiatan', 'judul', 'nama kegiatan', 'nama_kegiatan', 'activity title', 'title'],
            'keterangan' => ['keterangan', 'deskripsi', 'deskripsi kegiatan', 'description', 'activity description'],
            'isi' => ['isi', 'content', 'activity content'],
            'tanggal_kegiatan' => ['tanggal kegiatan', 'tanggal', 'date', 'activity date', 'waktu kegiatan', 'waktu pelaksanaan'],
            'tahun_kegiatan' => ['tahun kegiatan', 'tahun', 'year', 'activity year'],
            'tahun' => ['tahun', 'tahun kegiatan', 'year', 'activity year'],
        ];

        foreach ($aliases as $canonical => $keys) {
            if (array_key_exists($canonical, $normalized) && $normalized[$canonical] !== '') {
                continue;
            }
            foreach ($keys as $alias) {
                $aliasKey = $this->normalizeHeader($alias);
                if (array_key_exists($aliasKey, $normalized) && $normalized[$aliasKey] !== '') {
                    $normalized[$canonical] = $normalized[$aliasKey];
                    break;
                }
            }
        }

        // Banyak file Excel lama memisahkan nama menjadi First Name + Last Name.
        // Gabungkan keduanya agar tidak ada baris valid yang gagal hanya karena
        // kolom "Nama Dosen Asing" kosong.
        if (($normalized['nama'] ?? '') === '') {
            $fullName = trim(implode(' ', array_filter([
                $normalized['first_name'] ?? null,
                $normalized['last_name'] ?? null,
            ], static fn ($value) => $value !== null && trim((string) $value) !== '')));

            if ($fullName !== '') {
                $normalized['nama'] = $fullName;
            }
        }

        return $normalized;
    }

    private function normalizeHeader(string $value): string
    {
        $value = Str::ascii($value);
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/[\r\n\t]+/', ' ', $value);
        $value = preg_replace('/[^a-z0-9]+/', '_', $value);
        return trim((string) $value, '_');
    }

    private function normalizeName(?string $value): string
    {
        $value = Str::ascii((string) $value);
        $value = mb_strtolower(trim($value));
        // Hilangkan tanda baca dan gelar yang sering berbeda penulisannya
        // agar "Prof. Dr. Azlan Abas" dan "Prof Dr Azlan Abas" dianggap sama.
        $value = preg_replace('/[.,\/\-]+/', ' ', $value);
        $value = preg_replace('/\b(prof|profesor|dr|doctor|madya|ts|ir|h|hj)\b/', ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value) ?: '';
        return trim($value);
    }

    private function normalizeEmail(?string $value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        // Beberapa sheet menulis lebih dari satu email dengan pemisah / atau ;.
        // Untuk identitas dosen, gunakan email pertama yang valid agar pencarian
        // dan deduplikasi tetap stabil. Email asli lainnya tetap tidak menghalangi
        // data dosen masuk.
        $parts = preg_split('/[;,\/]+/', $value);
        foreach ($parts as $part) {
            $email = mb_strtolower(trim($part));
            $email = trim($email, " \t\r\n.");
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }
        }

        return '';
    }

    private function normalizeText(?string $value): string
    {
        $value = Str::ascii((string) $value);
        $value = mb_strtolower(trim($value));
        return preg_replace('/\s+/', ' ', $value) ?: '';
    }

    private function cleanString($value): ?string
    {
        if ($value === null) {
            return null;
        }
        $value = trim((string) $value);
        return $value === '' ? null : $value;
    }

    private function missingRequiredFields(array $row): array
    {
        $required = [
            'nama' => 'Nama Dosen Asing',
        ];

        $missing = [];
        foreach ($required as $key => $label) {
            if (!isset($row[$key]) || trim((string) $row[$key]) === '') {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }
        return true;
    }
}
