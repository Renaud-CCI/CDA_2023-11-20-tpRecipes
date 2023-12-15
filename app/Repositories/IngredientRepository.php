<?php
namespace App\Repositories;

use App\Models\Ingredient;
use App\Repositories\RepositoryInterface;

class IngredientRepository implements RepositoryInterface
{

  public function getAll()
  {
    return Ingredient::all();
  }

  public function find($id)
  {
    return Ingredient::find($id);
  }

  public function getById($id)
  {
    return Ingredient::findOrFail($id);
  }

  public function create($data)
  {
    return Ingredient::firstOrCreate($data);
  }

  public function update($id, $data)
  {
    $ingredient = Ingredient::findOrFail($id);
    $ingredient->update($data);

    return $ingredient;
  }

  public function delete($object)
  {
    $object->delete();
  }
}
