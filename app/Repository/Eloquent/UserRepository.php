<?php

namespace App\Repository\Eloquent;

use App\Repository\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function changePassword($newPassword)
    {
        $user = Auth::user();
        $this->model->where('id', $user->id)->update(['password' => bcrypt($newPassword)]);
    }
}
