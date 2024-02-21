<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\BaseRepo;

class CategoryRepo extends BaseRepo
{
    public function getModel()
    {
        return new Category();
    }
}
