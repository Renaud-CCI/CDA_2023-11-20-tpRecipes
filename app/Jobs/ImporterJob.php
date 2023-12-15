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

    private RecipeRepository $recipeRepository;

    private IngredientRepository $ingredientRepository;

    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function handle(ImporterFactory $importerFactory, RecipeRepository $recipeRepository, IngredientRepository $ingredientRepository): void
    {
        // $this->importerFactory = $importerFactory;
        // $this->recipeRepository = $recipeRepository;
        // $this->ingredientRepository = $ingredientRepository;
        
        $importer = $importerFactory->chooseImporter(pathinfo($this->filename, PATHINFO_EXTENSION));
        $recipes = $importer->extract($this->filename);

        foreach ($recipes as $recipeData) {
            $ingredientIds = [];

            foreach ($recipeData['ingredients'] as $ingredientName) {
                $ingredient = $ingredientRepository->create(['name' => $ingredientName]);
                $ingredientIds[] = $ingredient->id;
            }

            $recipeData['ingredients'] = $ingredientIds;

            $recipeRepository->create($recipeData);

        }
    }
}
