<?php

namespace App\Repository;

use Illuminate\Database\QueryException;

abstract class BaseRepo implements BaseRepoInterface
{

    abstract public function getModel();

    public function find($id)
    {
        try {
            return $this->getModel()->find($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function all($column = 'id', $filter = 'ASC')
    {
        try {
            return $this->getModel()->orderBy($column, $filter)->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function create($data)
    {
        try {
            return $this->getModel()->create($data);
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update($request, $id)
    {
        try {
            if ($this->getModel()->find($id)->update($request)) {
                return $this->find($id);
            }
            return null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $dato = $this->getModel()->findOrFail($id);
            $dato->status = $dato->status ? 0 : 1;
            if ($dato->save()) {
                return $this->find($id);
            }
            return null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
