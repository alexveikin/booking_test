<?php

namespace App\Models\QueryBuilders;

use App\Models\Capacity;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Capacity
 * @template TModelClass of Capacity
 * @extends Builder<Capacity>
 */
class CapacityBuilder extends Builder
{
    public function whereNotEmptyCapacity(): CapacityBuilder
    {
        return $this->where('capacity', '>', 0);
    }

    public function whereEmptyCapacity(): CapacityBuilder
    {
        return $this->where('capacity', 0);
    }

    public function whereDateBetween(
        CarbonImmutable $startDate,
        CarbonImmutable $endDate,
    ): CapacityBuilder {
        return $this->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * @param string[]|null $whereDateIn
     *
     * @return Collection<int, string>
     */
    public function getDatesCollectionWhereEmptyCapacity(array $whereDateIn = null): Collection
    {
        return $this
            ->whereEmptyCapacity()
            ->when(
                $whereDateIn && is_array($whereDateIn),
                static fn (Builder $q) => $q->whereIn('date', $whereDateIn)
            )
            ->pluck('date')
            ->map(static fn (CarbonImmutable $date) => $date->format('Y-m-d'))
            ->values()
        ;
    }

    /**
     * @param int[] $ids
     *
     * @return int
     */
    public function decrementCapacityByIds(array $ids): int
    {
        return $this->whereIn('id', $ids)
            ->update([
                'capacity' => DB::raw('capacity - 1'),
            ])
        ;
    }
}
