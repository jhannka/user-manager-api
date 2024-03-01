<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\BaseRepo;

class UserRepo extends BaseRepo
{
    public function getModel()
    {
        return new User();
    }

    public function resetPassword($request, $id)
    {
dd($id);
    }
}
