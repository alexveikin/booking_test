<?php

namespace App\DTO;

final readonly class HotelWithWeekendStays
{
    public function __construct(
        public int $hotelId,
        public string $hotelName,
        public int $weekendStays,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            hotelId: $data['hotelId'],
            hotelName: $data['hotelName'],
            weekendStays: $data['weekendStays'],
        );
    }
}
