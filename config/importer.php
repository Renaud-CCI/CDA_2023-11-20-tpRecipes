<?php

use App\Services\ImportRecipesFromJson;
use App\Services\ImportRecipesFromCsv;

return [
  'json' => ImportRecipesFromJson::class,
  'csv' => ImportRecipesFromCsv::class,
];