<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'preparationTime', 'cookingTime', 'serves'];
    protected $casts = [
        'ingredients' => 'array',
    ];

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="L5 Swagger OpenApi Test",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="your-email@example.com"
     *      ),
     * )
     */

     public function ingredients(): BelongsToMany
     {
         return $this->belongsToMany(Ingredient::class);
     }
}
