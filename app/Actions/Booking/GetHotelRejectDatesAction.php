<?php

namespace App\Actions\Booking;

use App\Actions\Carbon\GetDatesByRange;
use App\Models\Booking;
use App\Models\Hotel;

final readonly class GetHotelRejectDatesAction
{
    /**
     * @return array<int, string>
     */
    public function execute(Hotel $hotel): array
    {
        $getDatesAction = resolve(GetDatesByRange::class);

        $dates = $hotel->bookings
            ->map(static fn (Booking $booking) => $getDatesAction->execute(
                startDate: $booking->arrival_date,
                endDate: $booking->arrival_date->addDays($booking->nights - 1)
            ))
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray()
        ;

        return $hotel->capacities()
            ->getDatesCollectionWhereEmptyCapacity($dates)
            ->intersect($dates)
            ->toArray()
        ;
    }
}
