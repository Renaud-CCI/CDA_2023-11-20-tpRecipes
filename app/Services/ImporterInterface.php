<?php
namespace App\Services;


interface ImporterInterface {
  public function extract(string $filename): array;
}
