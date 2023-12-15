<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ImporterFactory;
use App\Repositories\RecipeRepository;
use App\Repositories\IngredientRepository;
use App\Repositories\RepositoryInterface;

class ImporterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private ImporterFactory $importerFactory;

    private RepositoryInterface $recipeRepository;

    private RepositoryInterface $ingredientRepository;

    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function handle(): void
    {
        $importer = $this->importerFactory->chooseImporter(pathinfo($this->filename, PATHINFO_EXTENSION));
        $recipes = $importer->extract($this->filename);

        foreach ($recipes as $recipeData) {
            $ingredientIds = [];

            foreach ($recipeData['ingredients'] as $ingredientName) {
                $ingredient = $this->ingredientRepository->create(['name' => $ingredientName]);
                $ingredientIds[] = $ingredient->id;
            }

            $recipeData['ingredients'] = $ingredientIds;

            $this->recipeRepository->create($recipeData);

        }
    }
}
