<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    /**
    * @OA\Post(
    *     path="/api/ingredients",
    *     tags={"Ingredients"},
    *     operationId="createIngredient",
    *     summary="Create a new ingredient",
    *     description="Create a new ingredient and return the ingredient data",
    *     @OA\RequestBody(
    *         description="Ingredient to be created",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="name", type="string", description="The name of the ingredient"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Ingredient created successfully"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Bad request"
    *     ),
    * )
    */
    public function store(Request $request)
    {
        $ingredient = Ingredient::create($request->all());
        return response()->json($ingredient, 201);
    }

    /**
    * @OA\Get(
    *     path="/api/ingredients",
    *     tags={"Ingredients"},
    *     operationId="getIngredientsList",
    *     summary="Get list of all ingredients",
    *     description="Returns list of all ingredients",
    *     @OA\Response(response="200", description="List of ingredients")
    * )
    */
    public function index()
    {
        return Ingredient::all();
    }

    /**
    * @OA\Get(
    *     path="/api/ingredients/{id}",
    *     tags={"Ingredients"},
    *     operationId="getIngredient",
    *     summary="Get ingredient by ID",
    *     description="Returns a single ingredient",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID of the ingredient to return",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Ingredient returned successfully"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Ingredient not found"
    *     ),
    * )
    */
    public function show(string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return $ingredient;
    }

    /**
    * @OA\Put(
    *     path="/api/ingredients/{id}",
    *     tags={"Ingredients"},
    *     operationId="updateIngredient",
    *     summary="Update an existing ingredient",
    *     description="Update an ingredient and return the ingredient data",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID of the ingredient to update",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         description="Ingredient data to update",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="name", type="string", description="The name of the ingredient"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Ingredient updated successfully"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Bad request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Ingredient not found"
    *     ),
    * )
    */
    public function update(Request $request, string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update($request->all());
        return $ingredient;
    }

    /**
    * @OA\Delete(
    *     path="/api/ingredients/{id}",
    *     tags={"Ingredients"},
    *     operationId="deleteIngredient",
    *     summary="Delete an ingredient",
    *     description="Delete an ingredient and return a success message",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID of the ingredient to delete",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Ingredient deleted successfully"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Ingredient not found"
    *     ),
    * )
    */
    public function destroy(string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();
        return response()->json(['message' => 'Ingredient deleted successfully']);
    }
}