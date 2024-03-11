<?php

namespace App\Actions\Booking;

use App\DTO\HotelWithRejectDates;
use App\Models\Hotel;
use Illuminate\Support\Collection;

final readonly class GetHotelsWithRejectDatesAction
{
    /**
     * @return Collection<int, HotelWithRejectDates>
     */
    public function execute(): Collection
    {
        return Hotel::query()
            ->getAllWithRejectedBookings()
            ->map(static fn (Hotel $hotel) => HotelWithRejectDates::fromModel($hotel))
            ->filter(static fn (HotelWithRejectDates $dto) => count($dto->rejectDates))
        ;
    }
}
