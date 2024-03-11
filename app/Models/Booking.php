<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Events\Booking\BookingCreated;
use App\Models\QueryBuilders\BookingBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',
        'user_id',
        'sales_price',
        'purchase_price',
        'arrival_date',
        'purchase_day',
        'nights',
        'status',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'sales_price' => 'decimal',
        'purchase_price' => 'decimal',
        'arrival_date' => 'immutable_date',
        'purchase_day' => 'immutable_date',
        'nights' => 'integer',
        'status' => BookingStatus::class
    ];

    protected $attributes = [
        'status' => BookingStatus::PENDING,
    ];

    protected $dispatchesEvents = [
        'created' => BookingCreated::class,
    ];

    /**
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Hotel>
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function newEloquentBuilder($query): BookingBuilder
    {
        return new BookingBuilder($query);
    }
}
