<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\BaseController;
use App\Repository\User\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function __construct(UserRepo $model)
    {
        parent::__construct($model);
    }
}
