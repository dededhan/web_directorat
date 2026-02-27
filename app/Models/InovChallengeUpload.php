<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InovChallengeUpload extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_uploads';

    protected $fillable = [
        'submission_id',
        'phase',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_by',
        'description',
    ];

    public $timestamps = true;

    // Relationships
    public function submission()
    {
        return $this->belongsTo(InovChallengeSubmission::class, 'submission_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Helper methods
    public function getFileUrl()
    {
        return Storage::url($this->file_path);
    }

    public function getFullPath()
    {
        return Storage::path($this->file_path);
    }

    public function fileExists()
    {
        return Storage::exists($this->file_path);
    }

    public function deleteFile()
    {
        if ($this->fileExists()) {
            Storage::delete($this->file_path);
        }
        return $this->delete();
    }

    public function getFileSizeFormatted()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileExtension()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    public function isImage()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        return in_array(strtolower($this->getFileExtension()), $imageExtensions);
    }

    public function isDocument()
    {
        $docExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
        return in_array(strtolower($this->getFileExtension()), $docExtensions);
    }

    public function isVideo()
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv'];
        return in_array(strtolower($this->getFileExtension()), $videoExtensions);
    }

    // Scopes
    public function scopeByPhase($query, $phase)
    {
        return $query->where('phase', $phase);
    }

    public function scopeBySubmission($query, $submissionId)
    {
        return $query->where('submission_id', $submissionId);
    }
}
