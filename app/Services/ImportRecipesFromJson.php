<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Services\ImporterInterface;

class ImportRecipesFromJson implements ImporterInterface
{
    public function extract(string $filename): array
    {
        $json = Storage::disk('local')->get($filename);
        $data = json_decode($json, true);

        return $data['recipes'] ?? [];
    }
}