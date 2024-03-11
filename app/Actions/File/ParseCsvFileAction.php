<?php

namespace App\Actions\File;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

final readonly class ParseCsvFileAction
{
    /**
     * @param string $path
     *
     * @return Collection<int, array<string, string>>
     */
    public function execute(string $path): Collection
    {
        $csvContent = Storage::disk('local')->get($path);
        $lines = explode(PHP_EOL, trim($csvContent));
        $headers = str_getcsv(array_shift($lines));

        return collect($lines)
            ->map(static fn (string $row) => array_combine(
                $headers,
                str_getcsv($row)
            ))
        ;
    }
}
