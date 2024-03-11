<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Booking Statistics</title>

        @vite(['resources/css/app.css'])
    </head>
    <body>
        <div class="relative flex flex-col justify-center items-center min-h-screen bg-gray-100">
            <h3 class="text-gray-800 text-2xl text-center py-4">Booking Statistics</h3>

            <div class="statistics-items">
                <div>
                    @include('statistics.components.weekend_stays')
                </div>
                <div>
                    @include('statistics.components.reject_dates')
                </div>
                <div>
                    @include('statistics.components.the_biggest_loss')
                </div>
            </div>
        </div>
    </body>
</html>
