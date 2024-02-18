<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'name' => 'required|string|max:100',
            'phone_number' => 'nullable|digits:10',
            'identification_card' => 'required|string|max:11',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'city_code' => 'required|integer|max:999999',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'identification_card' => $request->identification_card,
            'birth_date' => $request->birth_date,
            'city_code' => $request->city_code,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->attach($request->role_id);


        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }


        return response()->json($user, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'name' => 'required|string|max:100',
            'phone_number' => 'nullable|digits:10',
            'identification_card' => 'required|string|max:11',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'city_code' => 'required|integer|max:999999',
            'role_id' => 'required|exists:roles,id',
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user->update([
            'email' => $request->email,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'identification_card' => $request->identification_card,
            'birth_date' => $request->birth_date,
            'city_code' => $request->city_code,
            'password' => isset($request->password) ? bcrypt($request->password) : $user->password,
        ]);

        $user->roles()->sync([$request->role_id]);

        return response()->json($user, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        $user->delete();

        return response()->json(null, 204);
    }
}
