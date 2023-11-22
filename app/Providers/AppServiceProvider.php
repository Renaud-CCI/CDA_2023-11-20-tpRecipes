<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @OA\Info(
 *   title="My API",
 *   version="1.0",
 *   @OA\Contact(
 *     email="support@example.com",
 *     name="Support Team"
 *   )
 * )
 */
class AppServiceProvider extends ServiceProvider
{
    // ...
}