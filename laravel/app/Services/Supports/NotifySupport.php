<?php

namespace App\Services\Supports;

use App\Models\User;

class NotifySupport
{
  public static function shouldSend(User $member, int $actionUserId, string $type)
  {
    return $actionUserId !== $member->id && $member->notifyValidations->contains(function ($notifyValidation) use ($type) {
      return $notifyValidation->actionType->key === $type && $notifyValidation->is_valid;
    });
  }
}
