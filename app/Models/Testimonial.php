<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    protected $fillable = ['name', 'organization', 'photo', 'comment', 'rating', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function photoUrl(): ?string
    {
        return $this->photo && Storage::disk('public')->exists($this->photo)
            ? Storage::disk('public')->url($this->photo)
            : null;
    }

    public function initials(): string
    {
        return collect(explode(' ', $this->name))
            ->filter()
            ->take(2)
            ->map(fn (string $word) => mb_substr($word, 0, 1))
            ->implode('');
    }
}
