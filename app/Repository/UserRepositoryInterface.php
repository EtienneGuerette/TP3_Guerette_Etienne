<?php

namespace App\Repository;


interface UserRepositoryInterface extends RepositoryInterface
{
    public function changePassword($newPassword);
}
