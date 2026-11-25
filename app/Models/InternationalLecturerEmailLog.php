<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalLecturerEmailLog extends Model
{
    /**
     * Status yang dihitung sebagai pemakaian kuota harian.
     * Email yang gagal (failed) tidak dihitung agar bisa dikirim ulang.
     */
    public const COUNTED_STATUSES = ['queued', 'sending', 'sent'];

    protected $fillable = [
        'dosen_internasional_id',
        'batch_id',
        'recipient_email',
        'mode',
        'language_mode',
        'subject',
        'status',
        'error',
        'sent_by',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function lecturer()
    {
        return $this->belongsTo(DosenInternasional::class, 'dosen_internasional_id');
    }

    /**
     * Jumlah email yang sudah memakai kuota hari ini (zona waktu aplikasi).
     */
    public static function countedToday(): int
    {
        return static::query()
            ->whereIn('status', self::COUNTED_STATUSES)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();
    }

    public static function dailyLimit(): int
    {
        return (int) config('international_lecture.daily_email_limit', 300);
    }

    public static function remainingToday(): int
    {
        return max(0, static::dailyLimit() - static::countedToday());
    }
}
