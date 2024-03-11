<div class="statistics-item">
    <h2 class="statistics-item-title">
        Day when we lost the most due to rejection
    </h2>

    <div class="statistics-item-body text-center">
        @if($biggest_loss)
            <span class="font-bold">
                {{ $biggest_loss->date->format('Y-m-d') }} - {{ $biggest_loss->amount }}
            </span>
        @else
            <i class="text-red-500">It was not possible to gather information...</i>
        @endif
    </div>
</div>
