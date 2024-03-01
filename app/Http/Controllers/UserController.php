<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Repository\BaseController;
use App\Repository\User\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
    public function __construct(UserRepo $model)
    {
        $validation = new CreateUserRequest();
        parent::__construct($model, $validation->rules());
    }

    public function resetPassword(Request $request, $id)
    {
        try {

            $user = $this->model->find($id);

            $user->password = Hash::make($request->input('password'));
            $user->must_change_password = false;

            $user->save();

            return response()->json(['message' => 'Contraseña restablecida con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al restablecer la contraseña'], 500);
        }
    }
}
