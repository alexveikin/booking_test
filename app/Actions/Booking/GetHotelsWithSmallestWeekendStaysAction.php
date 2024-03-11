<?php

namespace App\Actions\Booking;

use App\DTO\HotelWithWeekendStays;
use App\Enums\BookingStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final readonly class GetHotelsWithSmallestWeekendStaysAction
{
    /**
     * @param int $limit
     *
     * @return Collection<int, HotelWithWeekendStays>
     */
    public function execute(int $limit = 5): Collection
    {
        $sql = <<<SQL
            WITH RECURSIVE cte AS (
                SELECT hotel_id, arrival_date, nights, arrival_date as date, status from bookings
                UNION ALL
                SELECT hotel_id, arrival_date, nights, date + INTERVAL 1 DAY, status FROM cte
                WHERE date < adddate(arrival_date, nights - 1)
            )
            SELECT hotel_id as hotelId, h.name as hotelName, count(date) as weekendStays
            FROM cte
            join hotels h on h.id = cte.hotel_id
            where (weekday(date) = 4 or weekday(date) = 5) and status = ?
            group by hotel_id, h.name
            order by weekendStays
            limit ?
        SQL;
        $data = DB::select($sql, [BookingStatus::APPROVED->value, $limit]);

        return collect($data)->map(
            static fn (object $item) => HotelWithWeekendStays::fromArray((array) $item)
        );
    }
}
