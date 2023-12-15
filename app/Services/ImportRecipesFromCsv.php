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
        $row = array_pad($row, count($headers), null);
        $recipe = array_combine($headers, $row);

        // Traiter les ingrédients comme un tableau de chaînes
        $recipe['ingredients'] = explode(',', $recipe['ingredients']);

        $data[] = $recipe;
    }

    fclose($file);

    return $data;
}
}