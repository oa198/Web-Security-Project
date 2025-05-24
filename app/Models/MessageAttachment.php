<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'is_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'is_image' => 'boolean',
    ];

    /**
     * Get the message that owns the attachment.
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get the file URL.
     *
     * @return string
     */
    public function getFileUrl(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the file size in a human-readable format.
     *
     * @return string
     */
    public function getHumanReadableSize(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Determine if the file is an image.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->is_image;
    }

    /**
     * Determine if the file is a document.
     *
     * @return bool
     */
    public function isDocument(): bool
    {
        $documentTypes = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt', 'xlsx', 'xls', 'csv', 'ppt', 'pptx'];
        $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        
        return in_array(strtolower($extension), $documentTypes);
    }
}
