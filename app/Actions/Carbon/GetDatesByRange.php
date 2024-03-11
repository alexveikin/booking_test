<?php

namespace App\Actions\Carbon;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use InvalidArgumentException;

final readonly class GetDatesByRange
{
    /**
     * @param CarbonImmutable $startDate
     * @param CarbonImmutable $endDate
     *
     * @return array<int, string>
     */
    public function execute(
        CarbonImmutable $startDate,
        CarbonImmutable $endDate,
    ): array {
        if ($startDate->greaterThan($endDate)) {
            throw new InvalidArgumentException('End date must be greater then or equal to start date.');
        }

        return array_map(
            static fn (Carbon $date) => $date->format('Y-m-d'),
            CarbonPeriod::dates($startDate, $endDate)->toArray(),
        );
    }
}
