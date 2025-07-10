<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'category_id',
        'client_id',
        'uploaded_by',
        'access_permissions',
        'is_public',
        'is_confidential',
        'expires_at',
        'download_count',
        'last_accessed_at',
    ];

    protected $casts = [
        'access_permissions' => 'array',
        'is_public' => 'boolean',
        'is_confidential' => 'boolean',
        'expires_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessors
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes >= 1024 && $i < 3; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getDownloadUrlAttribute()
    {
        return route('documents.download', $this->id);
    }

    public function getPreviewUrlAttribute()
    {
        return route('documents.preview', $this->id);
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeConfidential($query)
    {
        return $query->where('is_confidential', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    // Methods
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
        $this->update(['last_accessed_at' => now()]);
    }

    public function hasAccess($userId)
    {
        if ($this->is_public) {
            return true;
        }

        if ($this->uploaded_by == $userId) {
            return true;
        }

        if ($this->access_permissions && in_array($userId, $this->access_permissions)) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        // Delete the file from storage
        if (Storage::exists($this->file_path)) {
            Storage::delete($this->file_path);
        }

        return parent::delete();
    }
}
