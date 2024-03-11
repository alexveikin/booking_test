<?php

namespace App\Http\Controllers;

use App\Actions\Booking\GetHotelsWithRejectDatesAction;
use App\Actions\Booking\GetHotelsWithSmallestWeekendStaysAction;
use App\Actions\Booking\GetDayWithTheBiggestLossAction;

class StatisticsController extends Controller
{
    public function index(
        GetHotelsWithSmallestWeekendStaysAction $getSmallestWeekendStays,
        GetHotelsWithRejectDatesAction $getHotelsWithRejectDates,
        GetDayWithTheBiggestLossAction $getTheBiggestLoss
    ) {
        return view(
            'statistics.index',
            [
                'smallest_weekend_stays' => $getSmallestWeekendStays->execute(),
                'hotel_reject_dates' => $getHotelsWithRejectDates->execute(),
                'biggest_loss' => $getTheBiggestLoss->execute(),
            ]
        );
    }
}
