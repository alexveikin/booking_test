<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Actions\File\ParseCsvFileAction;
use App\Models\Booking;
use App\Models\Capacity;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $parseCsvFileAction = resolve(ParseCsvFileAction::class);

        $bookings = $parseCsvFileAction->execute('seed_samples/bookings.csv');
        $capacities = $parseCsvFileAction->execute('seed_samples/capacity.csv');

        if (!DB::table('users')->exists()) {
            User::factory($bookings->max('customer_id'))->create();
        }

        if (!DB::table('hotels')->exists()) {
            Hotel::factory($bookings->max('hotel_id'))->create();
        }

        if (!DB::table('capacities')->exists()) {
            $capacities
                ->groupBy(static fn (array $capacity) => "{$capacity['hotel_id']}_{$capacity['date']}")
                ->map(static fn(Collection $group) => [
                    'hotel_id' => $group[0]['hotel_id'],
                    'date' => $group[0]['date'],
                    'capacity' => $group->sum('capacity'),
                ])
                ->each(static fn (array $capacity) => Capacity::factory()
                    ->create([
                        'hotel_id' => (int) $capacity['hotel_id'],
                        'date' => $capacity['date'],
                        'capacity' => (int) $capacity['capacity'],
                    ])
                );
        }

        if (!DB::table('bookings')->exists()) {
            $bookings->sortBy('purchase_date')
                ->each(static fn (array $booking) => Booking::factory()
                    ->create([
                        'hotel_id' => (int) $booking['hotel_id'],
                        'user_id' => (int) $booking['customer_id'],
                        'sales_price' => (float) $booking['sales_price'],
                        'purchase_price' => (float) $booking['purchase_price'],
                        'arrival_date' => $booking['arrival_date'],
                        'purchase_day' => $booking['purchase_day'],
                        'nights' => (int) $booking['nights'],
                    ])
                );
        }
    }
}
