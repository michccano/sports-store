<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list(){
        return view("admin.product.productsList");
    }

    public function create(){
        return view("admin.product.create");
    }
}
