<?php

namespace App\Console\Commands;

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
    protected $description = 'persist recipes in database with a json file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipes = json_decode(Storage::disk('local')->get('recipes.json'), true)['recipes'];

        foreach ($recipes as $recipe) {
            DB::table('recipes')->insert([
                'name' => $recipe['name'],
                'ingredients' => json_encode($recipe['ingredients'], true),
                'preparationTime' => $recipe['preparationTime'],
                'cookingTime' => $recipe['cookingTime'],
                'serves' => $recipe['serves'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
