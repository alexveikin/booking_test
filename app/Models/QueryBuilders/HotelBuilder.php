<?php

namespace App\Models\QueryBuilders;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Hotel
 * @template TModelClass of Hotel
 * @extends Builder<Hotel>
 */
class HotelBuilder extends Builder
{
    public function onlyWithRejectedBookings(): HotelBuilder
    {
        return $this->withWhereHas(
            'bookings',
            static fn (BookingBuilder|HasMany $q) => $q->onlyRejected()
        );
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getAllWithRejectedBookings(): Collection
    {
        return $this->onlyWithRejectedBookings()->get();
    }
}
