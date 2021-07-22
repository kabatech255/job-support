<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\Abstracts\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
  public function __construct(User $model)
  {
    $this->setModel($model);
  }

  protected function mbTrim($pString)
  {
    return preg_replace('/( |　)+/', '', $pString);
  }

  /**
   * @param array $memberIds
   * @return string
   */
  public function names(array $memberIds): string
  {
    $members = $this->model()->whereIn('id', $memberIds)->get();
    return implode('、', $members->pluck('full_name')->toArray());
  }

  /**
   * @param array $params
   * @param $id
   * @return User
   */
  public function updateProfile(array $params, $id): User
  {
    if (isset($params['family_name_kana'])) {
      // mode = "KV"
      $params['family_name_kana'] = mb_convert_kana($this->mbTrim($params['family_name_kana']));
    }
    if (isset($params['given_name_kana'])) {
      // mode = "KV"
      $params['given_name_kana'] = mb_convert_kana($this->mbTrim($params['given_name_kana']), 'CKSV');
    }
    // $params['change_password']が'0'でもunsetしたいため、!isset(...)を使わない
    if (empty($params['change_password'] ?? '')) {
      unset($params['password']);
    } else {
      $params['password'] = \Hash::make($params['password']);
    }
    return parent::update($params, $id);
  }

  /**
   * @param $id
   * @return string | null
   */
  public function findPath($id): ?string
  {
    if ($id instanceof User) {
      return $id->file_path;
    }
    return parent::find($id)->file_path;
  }
}
