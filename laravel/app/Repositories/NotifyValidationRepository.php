<?php

namespace App\Repositories;

use App\Contracts\Repositories\NotifyValidationRepositoryInterface;
use App\Models\NotifyValidation;
use App\Repositories\Abstracts\EloquentRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NotifyValidationRepository extends EloquentRepository implements NotifyValidationRepositoryInterface
{
  public function __construct(NotifyValidation $model)
  {
    $this->setModel($model);
  }

  /**
   * @param array $param
   * @param User $user
   * @param int $target
   * @return NotifyValidation
   */
  public function attachByUser(array $param, User $user, $target): NotifyValidation
  {
    if ($target instanceof NotifyValidation) {
      $target = $target->action_type_id;
    }
    return $user->notifyValidations()->updateOrCreate(
      ['action_type_id' => $target],
      $this->qualifiedUpdateParams($param)
    );
  }
}
