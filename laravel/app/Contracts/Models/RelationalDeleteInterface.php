<?php

namespace App\Contracts\Models;

interface RelationalDeleteInterface extends ModelInterface
{
  public function getDeleteRelations(): array;
}
