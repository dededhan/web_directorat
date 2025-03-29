<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Youtube extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'youtubes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'link'
    ];

    /**
     * Get the YouTube video ID from the link.
     *
     * @return string|null
     */
    public function getVideoIdAttribute()
    {
        $pattern = 
            '%^# Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            (?:&.*)?        # Allow query parameters
            $%x';
        
        $result = preg_match($pattern, $this->link, $matches);
        
        return $result ? $matches[1] : null;
    }

    /**
     * Get the YouTube embed URL.
     *
     * @return string
     */
    public function getEmbedUrlAttribute()
    {
        $videoId = $this->video_id;
        
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        
        return '';
    }
}