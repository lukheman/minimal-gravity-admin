<?php

namespace App\Models;

use Database\Factories\RentalItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class RentalItem extends Model
{
    /** @use HasFactory<RentalItemFactory> */
    use HasFactory;

    protected $fillable = ['service_id', 'category', 'name', 'description', 'photo', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function photoUrl(): ?string
    {
        return $this->photo && Storage::disk('public')->exists($this->photo)
            ? Storage::disk('public')->url($this->photo)
            : null;
    }

    public function categoryLabel(): string
    {
        return config('rental.categories.'.$this->category, 'Lainnya');
    }

    public function categoryIcon(): string
    {
        return config('rental.icons.'.$this->category, 'fa-solid fa-box-open');
    }
}
