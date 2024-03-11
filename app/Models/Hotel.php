<?php

namespace App\Models;

use App\Models\QueryBuilders\HotelBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany<int, Booking>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return HasMany<int, Capacity>
     */
    public function capacities(): HasMany
    {
        return $this->hasMany(Capacity::class);
    }

    public function newEloquentBuilder($query): HotelBuilder
    {
        return new HotelBuilder($query);
    }
}
