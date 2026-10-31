<?php

namespace App\Models;

use Database\Factories\CollaborationPhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CollaborationPhoto extends Model
{
    /** @use HasFactory<CollaborationPhotoFactory> */
    use HasFactory;

    protected $fillable = ['collaboration_id', 'photo_path', 'caption', 'sort_order'];

    public function collaboration(): BelongsTo
    {
        return $this->belongsTo(Collaboration::class);
    }

    public function photoUrl(): ?string
    {
        return $this->photo_path && Storage::disk('public')->exists($this->photo_path)
            ? Storage::disk('public')->url($this->photo_path)
            : null;
    }
}
