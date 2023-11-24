<?php

namespace App\Console\Commands;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Console\Command;
use App\Services\ImportRecipesFromJson;

class PersistRecipesInDB extends Command
{

    /**
     * @var ImportRecipesFromJson
     */
    private $importedFile;

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



    public function __construct(ImportRecipesFromJson $importedFile)
    {
        parent::__construct();

        $this->importedFile = $importedFile;
    }

    public function handle()
    {
        $filename = $this->argument('filename');
        $recipes = $this->importedFile->extract($filename);

        foreach ($recipes as $recipeData) {
            $ingredientIds = [];

            foreach ($recipeData['ingredients'] as $ingredientName) {
                $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
                $ingredientIds[] = $ingredient->id;
            }

            $recipe = Recipe::firstOrCreate([
                'name' => $recipeData['name'],
                'preparationTime' => $recipeData['preparationTime'],
                'cookingTime' => $recipeData['cookingTime'],
                'serves' => $recipeData['serves'],
            ]);

            $recipe->ingredients()->sync($ingredientIds);
        }
    }
}