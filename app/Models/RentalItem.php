<?php

namespace App\Models;

use Database\Factories\RentalItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalItem extends Model
{
    /** @use HasFactory<RentalItemFactory> */
    use HasFactory;

    protected $fillable = ['service_id', 'name', 'description', 'photo', 'sort_order'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
