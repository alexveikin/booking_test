<div class="statistics-item">
    <h2 class="statistics-item-title">List of 5 hotels with the smallest number of weekend stays</h2>

    <div class="statistics-item-body">
        <table>
            <thead>
            <tr>
                <th>Hotel ID</th>
                <th>Hotel name</th>
                <th>Stays</th>
            </tr>
            </thead>
            <tbody>
            @foreach($smallest_weekend_stays as $stays_info)
                <tr>
                    <td>{{ $stays_info->hotelId }}</td>
                    <td>{{ $stays_info->hotelName }}</td>
                    <td>{{ $stays_info->weekendStays }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
