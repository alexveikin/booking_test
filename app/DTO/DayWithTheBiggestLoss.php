<?php

namespace App\DTO;

use Carbon\CarbonImmutable;

final readonly class DayWithTheBiggestLoss
{
    public function __construct(
        public CarbonImmutable $date,
        public float $amount,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            date: CarbonImmutable::parse($data['date']),
            amount: (float) $data['amount'],
        );
    }
}
