<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    protected $fillable = ['category', 'name', 'slug', 'description', 'photo', 'features', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['features' => 'array', 'is_active' => 'boolean'];
    }

    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class)->orderBy('sort_order');
    }

    public function photoUrl(): ?string
    {
        return $this->photo && Storage::disk('public')->exists($this->photo)
            ? Storage::disk('public')->url($this->photo)
            : null;
    }
}
