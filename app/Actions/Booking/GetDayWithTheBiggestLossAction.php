<?php

namespace App\Actions\Booking;

use App\DTO\DayWithTheBiggestLoss;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

final readonly class GetDayWithTheBiggestLossAction
{
    /**
     * @return DayWithTheBiggestLoss|null
     */
    public function execute():? DayWithTheBiggestLoss
    {
        $data = Booking::query()
            ->join('capacities', 'capacities.hotel_id', '=', 'bookings.hotel_id')
            ->onlyRejected()
            ->where('capacities.capacity', 0)
            ->whereRaw('capacities.date between bookings.arrival_date and adddate(bookings.arrival_date, bookings.nights - 1)')
            ->select(['capacities.date', DB::raw('sum(bookings.purchase_price) as amount')])
            ->groupBy('date')
            ->orderByDesc('amount')
            ->first()
        ;

        if (!$data) {
            return null;
        }

        return DayWithTheBiggestLoss::fromArray($data->toArray());
    }
}
