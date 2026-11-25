<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\DosenInternasional;
use App\Models\InternationalLectureSendReset;
use App\Models\InternationalLecturerEmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternationalLectureEmailRecapController extends Controller
{
    public function index(Request $request)
    {
        $defaultFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultTo = now()->endOfMonth()->format('Y-m-d');
        $fromDate = preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', (string) $request->input('from_date')) ? $request->input('from_date') : $defaultFrom;
        $toDate = preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', (string) $request->input('to_date')) ? $request->input('to_date') : $defaultTo;
        if ($fromDate > $toDate) [$fromDate, $toDate] = [$toDate, $fromDate];

        $start = now()->setTime(0,0,0)->setDate((int)substr($fromDate,0,4),(int)substr($fromDate,5,2),(int)substr($fromDate,8,2));
        $end = now()->setTime(23,59,59)->setDate((int)substr($toDate,0,4),(int)substr($toDate,5,2),(int)substr($toDate,8,2));

        $base = InternationalLecturerEmailLog::query()->whereBetween('international_lecturer_email_logs.created_at', [$start, $end]);
        if ($request->filled('status')) $base->where('status', $request->input('status'));
        if ($request->filled('category') && in_array($request->input('category'), ['template','manual'], true)) $base->where('mode', $request->input('category'));
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $base->where(function ($q) use ($search) {
                $q->where('recipient_email','like',"%{$search}%")
                  ->orWhere('subject','like',"%{$search}%")
                  ->orWhereHas('lecturer', fn($l) => $l->where('nama','like',"%{$search}%"));
            });
        }

        $summary = (clone $base)->selectRaw('COUNT(*) as total')->selectRaw("SUM(status = 'sent') as sent")->selectRaw("SUM(status = 'failed') as failed")->selectRaw("SUM(status = 'queued') as queued")->selectRaw("SUM(status = 'sending') as sending")->first();
        $byMode = (clone $base)->selectRaw('mode, COUNT(*) as total')->groupBy('mode')->pluck('total','mode');
        $logs = $base->with('lecturer:id,nama,email')->latest('created_at')->paginate(50)->withQueryString();

        $selectedLecturers = DosenInternasional::query()->whereNotNull('email')->where('email','!=','')->orderBy('nama')->get(['id','nama','email']);
        $todayStart = now()->startOfDay(); $todayEnd = now()->endOfDay();
        $todayLogs = InternationalLecturerEmailLog::query()
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('status', 'sent')
            ->whereIn('dosen_internasional_id', $selectedLecturers->pluck('id'))
            ->orderBy('created_at')
            ->orderBy('id')
            ->get(['id', 'dosen_internasional_id', 'created_at']);

        // Log terawal hari ini untuk menentukan urutan pengiriman terawal -> terakhir
        $firstSentToday = $todayLogs->unique('dosen_internasional_id')->keyBy('dosen_internasional_id');
        // Log terakhir hari ini untuk kolom "Pengiriman Terakhir"
        $todaySent = $todayLogs->reverse()->unique('dosen_internasional_id')->keyBy('dosen_internasional_id');

        // Ambil data reset hari ini agar tombol reset hilang jika sudah di-reset
        $todayResets = InternationalLectureSendReset::query()
            ->where(function ($q) {
                $today = now()->toDateString();
                $ym = now()->format('Y-m');
                if (\Illuminate\Support\Facades\Schema::hasColumn('international_lecture_send_resets', 'reset_date')) {
                    $q->whereDate('reset_date', $today);
                } else {
                    $q->where('year_month', $ym);
                }
            })
            ->whereIn('dosen_internasional_id', $selectedLecturers->pluck('id'))
            ->get()
            ->keyBy('dosen_internasional_id');

        // Status reset per dosen: sudah di-reset jika ada reset_at setelah log pengiriman hari ini
        $resetStatus = [];
        foreach ($selectedLecturers as $l) {
            $log = $todaySent->get($l->id);
            $rst = $todayResets->get($l->id);
            $resetStatus[$l->id] = ($log && $rst && $rst->reset_at && $rst->reset_at->gt($log->created_at));
        }

        // Pisahkan dosen: terkirim hari ini di posisi paling atas (urut terawal -> terakhir), yang belum terkirim di bawah
        $sentLecturers = $selectedLecturers->filter(fn($l) => $todaySent->has($l->id))
            ->sortBy(function ($l) use ($firstSentToday) {
                $log = $firstSentToday->get($l->id);
                return [
                    $log?->created_at?->timestamp ?? 0,
                    $log?->id ?? 0,
                ];
            })->values();

        $unsentLecturers = $selectedLecturers->reject(fn($l) => $todaySent->has($l->id))
            ->sortBy('nama', SORT_NATURAL | SORT_FLAG_CASE)->values();

        $selectedLecturers = $sentLecturers->concat($unsentLecturers);

        return view('admin_pemeringkatan.international-lecture.email-recap', compact('fromDate','toDate','summary','byMode','logs','selectedLecturers','todaySent','resetStatus'));
    }

    public function reset(Request $request, int $id)
    {
        $lecturer = DosenInternasional::findOrFail($id);
        $today = now()->toDateString();
        $ym = now()->format('Y-m');
        $hasResetDate = \Illuminate\Support\Facades\Schema::hasColumn('international_lecture_send_resets', 'reset_date');

        $attributes = ['dosen_internasional_id' => $lecturer->id];
        $values = ['reset_at' => now(), 'reset_by' => Auth::id()];

        if ($hasResetDate) {
            $attributes['reset_date'] = $today;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('international_lecture_send_resets', 'year_month')) {
            $attributes['year_month'] = $ym;
            $values['year_month'] = $ym;
        }

        InternationalLectureSendReset::updateOrCreate($attributes, $values);

        return redirect()->back()->with('success','Status kirim email untuk '.($lecturer->nama ?: $lecturer->email).' sudah di-reset. Sekarang email dapat dikirim kembali.');
    }

    public function resetBulk(Request $request)
    {
        $validated = $request->validate([
            'lecturer_ids' => 'required|array|min:1',
            'lecturer_ids.*' => 'integer|exists:dosen_internasionals,id',
        ]);

        $ids = array_unique(array_map('intval', $validated['lecturer_ids']));
        $today = now()->toDateString();
        $ym = now()->format('Y-m');
        $now = now();
        $userId = Auth::id();
        $hasResetDate = \Illuminate\Support\Facades\Schema::hasColumn('international_lecture_send_resets', 'reset_date');
        $hasYearMonth = \Illuminate\Support\Facades\Schema::hasColumn('international_lecture_send_resets', 'year_month');

        foreach ($ids as $id) {
            $attributes = ['dosen_internasional_id' => $id];
            $values = ['reset_at' => $now, 'reset_by' => $userId];

            if ($hasResetDate) {
                $attributes['reset_date'] = $today;
            }
            if ($hasYearMonth) {
                $attributes['year_month'] = $ym;
                $values['year_month'] = $ym;
            }

            InternationalLectureSendReset::updateOrCreate($attributes, $values);
        }

        return redirect()->back()->with('success', count($ids) . ' dosen terpilih berhasil di-reset. Sekarang email dapat dikirim kembali.');
    }
}
