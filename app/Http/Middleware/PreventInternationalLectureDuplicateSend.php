<?php

namespace App\Http\Middleware;

use App\Models\DosenInternasional;
use App\Models\InternationalLectureSendReset;
use App\Models\InternationalLecturerEmailLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventInternationalLectureDuplicateSend
{
    public function handle(Request $request, Closure $next): Response
    {
        $ids = $this->recipientIds($request);
        if (!$ids) {
            return $next($request);
        }

        $start = now()->startOfDay();
        $end = now()->endOfDay();
        $today = now()->toDateString();
        $blocked = [];

        $lecturers = DosenInternasional::whereIn('id', $ids)
            ->get(['id', 'nama', 'email'])
            ->keyBy('id');

        foreach ($ids as $id) {
            $lecturer = $lecturers->get($id);
            if (!$lecturer) continue;

            $lastLog = InternationalLecturerEmailLog::query()
                ->where('dosen_internasional_id', $id)
                ->whereBetween('created_at', [$start, $end])
                ->whereIn('status', ['queued', 'sending', 'sent'])
                ->latest('created_at')
                ->first(['id', 'created_at']);

            if (!$lastLog) continue;

            $reset = InternationalLectureSendReset::query()
                ->where('dosen_internasional_id', $id)
                ->where(function ($q) use ($today) {
                    $ym = now()->format('Y-m');
                    if (\Illuminate\Support\Facades\Schema::hasColumn('international_lecture_send_resets', 'reset_date')) {
                        $q->whereDate('reset_date', $today);
                    } else {
                        $q->where('year_month', $ym);
                    }
                })
                ->first();

            if (!$reset || !$reset->reset_at || $reset->reset_at->lte($lastLog->created_at)) {
                $blocked[] = $lecturer->nama ?: $lecturer->email;
            }
        }

        if ($blocked) {
            $names = implode(', ', array_slice($blocked, 0, 5));
            $extra = count($blocked) > 5 ? ' dan ' . (count($blocked) - 5) . ' lainnya' : '';
            return redirect()->back()->withInput()->with('error',
                'Email hari ini sudah pernah dikirim ke: ' . $names . $extra .
                '. Untuk kirim ulang pada tanggal yang sama, gunakan tombol Reset & Kirim Lagi pada Rekap Email terlebih dahulu.'
            );
        }

        return $next($request);
    }

    private function recipientIds(Request $request): array
    {
        $ids = [];
        if ($request->has('lecturer_ids')) {
            $ids = array_merge($ids, (array) $request->input('lecturer_ids'));
        }
        $routeId = $request->route('id');
        if ($routeId !== null && is_numeric($routeId)) $ids[] = $routeId;
        return array_values(array_unique(array_filter(array_map('intval', $ids))));
    }
}
