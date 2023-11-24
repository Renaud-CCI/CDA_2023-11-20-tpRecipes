<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImportRecipesFromJson
{
    public function extract(string $filename): array
    {
        $json = Storage::disk('local')->get($filename);
        $data = json_decode($json, true);

        return $data['recipes'] ?? [];
    }
}