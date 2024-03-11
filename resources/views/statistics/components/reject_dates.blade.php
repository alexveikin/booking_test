<div class="statistics-item">
    <h2 class="statistics-item-title">
        List hotels and dates where we had to reject customers
    </h2>

    <div class="statistics-item-body">
        <table>
            <thead>
            <tr>
                <th>Hotel ID</th>
                <th>Hotel name</th>
                <th>Dates</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hotel_reject_dates as $rejects_info)
                <tr>
                    <td>{{ $rejects_info->hotelId }}</td>
                    <td>{{ $rejects_info->hotelName }}</td>
                    <td>
                        @foreach($rejects_info->rejectDates as $date)
                            {{ $date }} <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
