<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katsinov extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'focus_area',
        'project_name',
        'institution',
        'address',
        'contact',
        'assessment_date'
    ];

    protected $casts = [
        'assessment_date' => 'date'
    ];

    /**
     * Get the user who created this Katsinov assessment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the individual responses for this Katsinov assessment
     */
    public function responses()
    {
        return $this->hasMany(KatsinovResponse::class);
    }

    /**
     * Get the aggregated scores for this Katsinov assessment
     */
    public function scores()
    {
        return $this->hasMany(KatsinovScore::class);
    }

    /**
     * Get the responses for a specific indicator
     */
    public function getIndicatorResponses($indicatorNumber)
    {
        return $this->responses()
            ->where('indicator_number', $indicatorNumber)
            ->get();
    }

    /**
     * Get the score for a specific indicator
     */
    public function getIndicatorScore($indicatorNumber)
    {
        return $this->scores()
            ->where('indicator_number', $indicatorNumber)
            ->first();
    }

    /**
     * Calculate the average score across all aspects
     */
    public function getAverageScore()
    {
        $scores = $this->scores;
        if ($scores->isEmpty()) {
            return 0;
        }

        $fields = ['technology', 'organization', 'risk', 'market', 'partnership', 'manufacturing', 'investment'];
        $sum = 0;
        $count = 0;

        foreach ($scores as $score) {
            foreach ($fields as $field) {
                $sum += $score->$field;
                $count++;
            }
        }

        return $count > 0 ? $sum / $count : 0;
    }

    /**
     * Determine the highest KATSINOV level achieved across all aspects
     */
    public function getMaxKatsinovLevel()
    {
        $scores = $this->scores()->orderBy('indicator_number')->get();
        if ($scores->isEmpty()) {
            return 0;
        }

        $fields = ['technology', 'organization', 'risk', 'market', 'partnership', 'manufacturing', 'investment'];
        $maxLevel = 0;

        for ($level = 1; $level <= 6; $level++) {
            $levelScore = $scores->where('indicator_number', $level)->first();
            if (!$levelScore) {
                break;
            }

            $allAspectsPass = true;
            foreach ($fields as $field) {
                if ($levelScore->$field < 80) {
                    $allAspectsPass = false;
                    break;
                }
            }

            if ($allAspectsPass) {
                $maxLevel = $level;
            } else {
                break;
            }
        }

        return $maxLevel;
    }

    /**
     * Get the overall status based on average score
     */
    public function getStatus()
    {
        $avg = $this->getAverageScore();
        
        if ($avg >= 80) return 'SANGAT BAIK';
        if ($avg >= 60) return 'BAIK';
        if ($avg >= 40) return 'CUKUP';
        if ($avg >= 20) return 'KURANG';
        return 'SANGAT KURANG';
    }
}