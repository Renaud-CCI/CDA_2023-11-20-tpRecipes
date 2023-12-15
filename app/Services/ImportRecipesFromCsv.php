<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Services\ImporterInterface;

class ImportRecipesFromCsv implements ImporterInterface
{
    public function extract(string $filename): array
    {
        $path = Storage::disk('local')->path($filename);
        $file = fopen($path, 'r');

        $data = [];
        $headers = fgetcsv($file);

        while ($row = fgetcsv($file)) {
            $data[] = array_combine($headers, $row);
        }

        fclose($file);

        return $data;
    }
}