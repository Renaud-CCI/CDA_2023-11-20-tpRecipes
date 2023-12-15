<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImporterFactory;
use App\Repositories\RecipeRepository;
use App\Repositories\IngredientRepository;
use App\Repositories\RepositoryInterface;

class PersistRecipesInDB extends Command
{
    private ImporterFactory $importerFactory;

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



    public function __construct(ImporterFactory $importerFactory, RecipeRepository $recipeRepository, IngredientRepository $ingredientRepository)
    {
        parent::__construct();

        $this->importerFactory = $importerFactory;
        $this->recipeRepository = $recipeRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function handle()
    {
        $filename = $this->argument('filename');
        $importer = $this->importerFactory->chooseImporter(pathinfo($filename, PATHINFO_EXTENSION));
        $recipes = $importer->extract($filename);

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