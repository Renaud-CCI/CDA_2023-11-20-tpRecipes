<?php

namespace App\Console\Commands;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PersistRecipesInDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:persist-recipes-in-d-b';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'persist recipes and ingredients in database with a json file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipes = json_decode(Storage::disk('local')->get('recipes.json'), true)['recipes'];

        foreach ($recipes as $recipeData) {
            $ingredientIds = [];

            foreach ($recipeData['ingredients'] as $ingredientName) {
                $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
                $ingredientIds[] = $ingredient->id;
            }

            $recipe = Recipe::create([
                'name' => $recipeData['name'],
                'preparationTime' => $recipeData['preparationTime'],
                'cookingTime' => $recipeData['cookingTime'],
                'serves' => $recipeData['serves'],
            ]);

            $recipe->ingredients()->attach($ingredientIds);
        }
    }
}
