<?php
namespace App\Repositories;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Repositories\RepositoryInterface;

class RecipeRepository implements RepositoryInterface
{

  public function getAll()
  {
    return Recipe::with('ingredients')->get();
  }

  public function find($id)
  {
    return Recipe::find($id);
  }

  public function getById($id)
  {
    return Recipe::findOrFail($id); //findOrFail permet de retourner erreur 404 si l'id n'existe pas
  }

  public function create($data)
  {
    $data2 = $data['ingredients'];
    $data = (array) $data;
    unset($data['ingredients']);

    $recipe = Recipe::firstOrCreate($data);
    $recipe->ingredients()->attach($data2);

    return $recipe;
  }

  public function update($id, $data)
  {
    $recipe = Recipe::findOrFail($id);
    $recipe->update($data->except('ingredients'));
    $recipe->ingredients()->sync($data->input('ingredients'));

    return $recipe;
  }

  public function delete($object)
  {
    $object->delete();
  }
}
