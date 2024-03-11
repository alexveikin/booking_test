<?php

namespace App\Models;

use App\Models\QueryBuilders\CapacityBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Capacity extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',
        'date',
        'capacity',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'immutable_date',
        'capacity' => 'integer',
    ];

    /**
     * @return BelongsTo<Hotel>
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function newEloquentBuilder($query): CapacityBuilder
    {
        return new CapacityBuilder($query);
    }
}
