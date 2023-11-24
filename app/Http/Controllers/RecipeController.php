<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  /**
  * @OA\Get(
  *     path="/api/recipes",
  *     tags={"Recipes"},
  *     operationId="getAllRecipes",
  *     summary="Get list of all recipes",
  *     description="Returns list of recipess",
  *     @OA\Response(response="200", description="List of recipes")
  * )
  */
  public function index()
  {
    return Recipe::with('ingredients')->get();
  }  

  /**
  * @OA\Post(
  *     path="/api/recipes",
  *     tags={"Recipes"},
  *     operationId="addRecipes",
  *     summary="Set a new recipe in DB",
  *     description="Create recipe",
  *     @OA\RequestBody(
  *         description="Recipe to add",
  *         required=true,
  *         @OA\JsonContent(
  *             required={"name","ingredients","preparationTime","cookingTime","serves"},
  *             @OA\Property(property="name", type="string", example="Spaghetti Bolognese"),
  *             @OA\Property(property="ingredients", type="array", @OA\Items(type="integer"), example={1, 2, 3}),
  *             @OA\Property(property="preparationTime", type="string", example="15 minutes"),
  *             @OA\Property(property="cookingTime", type="string", example="30 minutes"),
  *             @OA\Property(property="serves", type="integer", example=4),
  *         )
  *     ),
  *     @OA\Response(response="200", description="Create a new recipe"),
  *     @OA\Response(response="400", description="Invalid ingredient ID")
  * )
  */
  public function store(Request $request)
  {
      $ingredientIds = $request->input('ingredients');
      foreach ($ingredientIds as $ingredientId) {
          if (!Ingredient::find($ingredientId)) {
              return response()->json(['error' => 'Invalid ingredient ID: ' . $ingredientId], 400);
          }
      }

      $recipe = Recipe::create($request->except('ingredients'));
      $recipe->ingredients()->attach($ingredientIds);

      return response()->json($recipe->load('ingredients'), 201);
  }


  /**
  * @OA\Get(
  *     path="/api/recipes/{id}",
  *     tags={"Recipes"},
  *     operationId="getRecipe",
  *     summary="Get a recipe by its ID",
  *     description="Returns a single recipe",
  *     @OA\Parameter(
  *         name="id",
  *         in="path",
  *         description="ID of the recipe to return",
  *         required=true,
  *         @OA\Schema(
  *             type="integer"
  *         )
  *     ),
  *     @OA\Response(response="200", description="Recipe details"),
  *     @OA\Response(response="404", description="This recipe does not exist")
  * )
  */
  public function show($id)
  {
      return Recipe::findOrFail($id); //findOrFail permet de retourner erreur 404 si l'id n'existe pas
  }

  /**
  * @OA\Put(
  *     path="/api/recipes/{id}",
  *     tags={"Recipes"},
  *     operationId="updateRecipe",
  *     summary="Update a recipe",
  *     description="Update a recipe by its ID",
  *     @OA\Parameter(
  *         name="id",
  *         in="path",
  *         description="ID of the recipe to update",
  *         required=true,
  *         @OA\Schema(
  *             type="integer"
  *         )
  *     ),
  *     @OA\RequestBody(
  *         description="Recipe to update",
  *         required=true,
  *         @OA\JsonContent(
  *            type="object",
  *            @OA\Property(property="name", type="string", example="Spaghetti Bolognese"),
  *            @OA\Property(property="ingredients", type="array", @OA\Items(type="integer"), example={1, 2, 3}),
  *            @OA\Property(property="preparationTime", type="string", example="15 minutes"),
  *            @OA\Property(property="cookingTime", type="string", example="30 minutes"),
  *            @OA\Property(property="serves", type="integer", example=4)
  *        )
  *     ),
  *     @OA\Response(response="200", description="Update a recipe"),
  *     @OA\Response(response="400", description="Invalid ingredient ID")
  * )
  */
  public function update(Request $request, $id)
  {
      $ingredientIds = $request->input('ingredients');
      foreach ($ingredientIds as $ingredientId) {
          if (!Ingredient::find($ingredientId)) {
              return response()->json(['error' => 'Invalid ingredient ID: ' . $ingredientId], 400);
          }
      }

      $recipe = Recipe::findOrFail($id);
      $recipe->update($request->except('ingredients'));
      $recipe->ingredients()->sync($ingredientIds);

      return response()->json($recipe->load('ingredients'), 200);
  }

  /**
  * @OA\Delete(
  *     path="/api/recipes/{id}",
  *     tags={"Recipes"},
  *     operationId="deleteRecipe",
  *     summary="Delete a recipe",
  *     description="Delete a recipe by its ID",
  *     @OA\Parameter(
  *         name="id",
  *         in="path",
  *         description="ID of the recipe to delete",
  *         required=true,
  *         @OA\Schema(
  *             type="integer"
  *         )
  *     ),
  *     @OA\Response(response="200", description="Delete a recipe"),
  *     @OA\Response(response="204", description="Delete OK"),
  *     @OA\Response(response="500", description="No entry with this ID")
  * )
  */
  public function destroy($id)
  {
    $recipe = Recipe::find($id);
    if (!$recipe) {
      return response()->json(['message' => 'No entry with this ID'], 500);
    }
    $recipe->delete();
    return response()->json(null, 204);
  }
}