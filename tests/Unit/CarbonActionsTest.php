<?php

use App\Actions\Carbon\GetDatesByRange;
use Carbon\CarbonImmutable;

it('successfully returns array of dates by range', function ($days) {
    $startDate = CarbonImmutable::parse('2021-01-01');
    $endDate = $startDate->addDays($days);
    $dates = resolve(GetDatesByRange::class)->execute($startDate, $endDate);

    expect($dates)
        ->toBeArray()
        ->toHaveCount($days + 1)
        ->each
        ->toBeString()
        ->toMatch('/\d{4}-\d{2}-\d{2}/i')
    ;
})->with([0, 1, 2, 10]);

it('throws error while getting array of dates by range', function () {
    $startDate = CarbonImmutable::parse('2021-01-01');
    $endDate = $startDate->subDay();
    resolve(GetDatesByRange::class)->execute($startDate, $endDate);
})->throws(
    InvalidArgumentException::class,
    'End date must be greater then or equal to start date.'
);
