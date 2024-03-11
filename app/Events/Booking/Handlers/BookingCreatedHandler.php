<?php

namespace App\Events\Booking\Handlers;

use App\Events\Booking\BookingCreated;
use App\Models\Capacity;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookingCreatedHandler
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @throws Throwable
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;

        try {
            DB::beginTransaction();

            $capacities = Capacity::query()
                ->where('hotel_id', $booking->hotel_id)
                ->whereNotEmptyCapacity()
                ->whereDateBetween(
                    startDate: $booking->arrival_date,
                    endDate: $booking->arrival_date->addDays($booking->nights - 1),
                )
                ->get()
            ;

            if ($capacities->count() < $booking->nights) {
                $booking->reject();

                DB::commit();

                return;
            }

            $booking->approve();

            Capacity::decrementCapacityByIds(
                ids: $capacities->pluck('id')->toArray()
            );

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
