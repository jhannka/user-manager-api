<?php

namespace App\Repository;


use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{

    protected $model;
    protected $validation;

    public function __construct($model, $validation = null)
    {
        $this->model = $model;
        $this->validation = $validation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($cache = false, $name = "default", $minutes = 10)
    {
        try {
            if ($cache) {
                $result = Cache::remember(get_class($this->model->getModel()), $minutes, function () {
                    return $this->model->all();
                });
            } else {
                $result = $this->model->all();
            }
            return response()->json(['state' => 200, 'data' => $result]);
        } catch (\Exception|\InvalidArgumentException|QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json(['error' => 'El ID debe ser numérico.'], 404);
            }

            $resource = $this->model->find($id);

            if ($resource) {
                return response()->json(['state' => 200, 'data' => $resource]);
            } else {
                return response()->json(['error' => 'El recurso no fue encontrado.'], 404);
            }

        } catch (\Exception|\InvalidArgumentException|QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $request->request->add(['user_id' => Auth::id()]);
            $createdResource = $this->model->create($request->all());

            return response()->json(['state' => 201, 'data' => $createdResource]);
        } catch (\Exception|\InvalidArgumentException|QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {

            if (!is_numeric($id)) {
                return response()->json(['error' => 'El ID debe ser numérico.'], 422);
            }

            $resource = $this->model->find($id);

            if (!$resource) {
                return response()->json(['error' => 'El recurso no fue encontrado.'], 404);
            }

            $validatedData = $this->validateRequest($request);

            $resource->update($validatedData);

            return response()->json(['state' => 201, 'data' => $resource]);
        } catch (\Exception|\InvalidArgumentException|QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json(['error' => 'El ID debe ser numérico.'], 422);
            }
            $resource = $this->model->find($id)->delete();

            return response()->json(
                [
                    'state' => 201,
                    'data' => $resource
                ]
            );
        } catch (\Exception|\InvalidArgumentException|QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    private function validateRequest($request)
    {
        if ($this->validation !== null) {
            $uniqueOnCreation = ['email'];

            $rules = $request->all();

            foreach ($uniqueOnCreation as $field) {
                if ($request->isMethod('post')) {
                    $rules[$field] .= '|unique:users';
                }
            }

            $validator = Validator::make($rules, $this->validation);

            if ($validator->fails()) {
                throw new \InvalidArgumentException('Error de validación: ' . $validator->errors()->first());
            }

            return $request->all();
        }

        return $request->all();
    }


}
