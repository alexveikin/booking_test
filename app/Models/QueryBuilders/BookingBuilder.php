<?php

namespace App\Models\QueryBuilders;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Booking
 * @template TModelClass of Booking
 * @extends Builder<Booking>
 */
class BookingBuilder extends Builder
{
    public function reject(): int
    {
        return $this->model->update([
            'status' => BookingStatus::REJECTED
        ]);
    }

    public function approve(): int
    {
        return $this->model->update([
            'status' => BookingStatus::APPROVED
        ]);
    }

    public function onlyRejected(): BookingBuilder
    {
        return $this->where('status', BookingStatus::REJECTED);
    }

    public function onlyApproved(): BookingBuilder
    {
        return $this->where('status', BookingStatus::APPROVED);
    }
}
