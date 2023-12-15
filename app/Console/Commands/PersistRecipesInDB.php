<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImportRecipesFromJson;
use App\Repositories\RecipeRepository;
use App\Repositories\IngredientRepository;
use App\Repositories\RepositoryInterface;

class PersistRecipesInDB extends Command
{
    private ImportRecipesFromJson $importedFile;

    private RepositoryInterface $recipeRepository;

    private RepositoryInterface $ingredientRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recipes:persist {filename=recipes.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'persist recipes and ingredients in database with a json file';

    /**
     * Execute the console command.
     */



    public function __construct(ImportRecipesFromJson $importedFile, RecipeRepository $recipeRepository, IngredientRepository $ingredientRepository)
    {
        parent::__construct();

        $this->importedFile = $importedFile;
        $this->recipeRepository = $recipeRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function handle()
    {
        $filename = $this->argument('filename');
        $recipes = $this->importedFile->extract($filename);

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