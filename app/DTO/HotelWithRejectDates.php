<?php

namespace App\DTO;

use App\Actions\Booking\GetHotelRejectDatesAction;
use App\Models\Hotel;

final readonly class HotelWithRejectDates
{
    public function __construct(
        public int $hotelId,
        public string $hotelName,
        /** @var string[] */
        public array $rejectDates,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return new self(
            hotelId: $hotel->id,
            hotelName: $hotel->name,
            rejectDates: resolve(GetHotelRejectDatesAction::class)->execute($hotel)
        );
    }
}
