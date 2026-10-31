<?php

namespace App\Models;

use Database\Factories\CollaborationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Collaboration extends Model
{
    /** @use HasFactory<CollaborationFactory> */
    use HasFactory;

    protected $fillable = ['partner_name', 'logo', 'event_name', 'slug', 'event_date', 'service_category', 'description', 'is_active'];

    protected function casts(): array
    {
        return ['event_date' => 'date', 'is_active' => 'boolean'];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(CollaborationPhoto::class)->orderBy('sort_order');
    }

    public function logoUrl(): ?string
    {
        return $this->logo && Storage::disk('public')->exists($this->logo)
            ? Storage::disk('public')->url($this->logo)
            : null;
    }

    public function coverUrl(): ?string
    {
        return $this->photos->first()?->photoUrl();
    }
}
