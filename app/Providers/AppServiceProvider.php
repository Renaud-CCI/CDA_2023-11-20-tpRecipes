<?php

namespace App\Providers;

use App\Repositories\RecipeRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * @OA\Info(
 *   title="RecipesAPI",
 *   version="1.0",
 *   @OA\Contact(
 *     email="support@example.com",
 *     name="Support Team"
 *   )
 * )
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}