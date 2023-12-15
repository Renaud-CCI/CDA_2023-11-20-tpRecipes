<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Config;

class ImporterFactory {
  public function chooseImporter(String $fileType) {
    $className = Config::get("importer.$fileType");
    if (!$className) {
        throw new Exception("Invalid file type: " . $fileType);
    }
    return app($className);
  }
}