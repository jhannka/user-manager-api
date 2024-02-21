<?php

namespace App\Repository;


use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BaseController extends Controller
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
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

            $request->request->add(['user_id' => Auth::user()->id]);
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


            $resource->update($request->all());

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

            $deletedResource = $this->model->destroy($id);

            return response()->json(['state' => 201, 'data' => $deletedResource]);
        } catch (\Exception|\InvalidArgumentException|QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

}
