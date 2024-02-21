<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repository\BaseController;
use App\Repository\Category\CategoryRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function __construct(CategoryRepo $model)
    {
        parent::__construct($model);
    }
}
