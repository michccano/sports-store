<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list(){
        $products = Product::all();
        return view("admin.product.productsList",compact("products"));
    }

    public function create(){
        return view("admin.product.create");
    }

    public function store(ProductCreateRequest $request){
        $imageName = time() . '-' . $request->name . '.' . $request->img->extension();
        $request->img->move(public_path('images'), $imageName);

        Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "img" => $imageName,
        ]);

        return redirect()->route("productList");
    }

    public function delete(Request $request){
        $id = $request->product_id;
        Product::find($id)->delete();
        return redirect()->route("productList");
    }

    public function edit($id){
        $product = Product::find($id);
        return view("admin.product.edit",compact('product'));
    }

    public function update(ProductUpdateRequest $request, $id){
        $dataToUpdate = [];
        if($request->name!= null)
            $dataToUpdate["name"] = $request->name;

        if ($request->description != null)
            $dataToUpdate["description"] = $request->description;

        if ($request->price != null)
            $dataToUpdate["price"] = $request->price;

        if ($request->img != null) {
            $imageName = time() . '-' . $request->name . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);
            $dataToUpdate["img"] = $imageName;
        }
        if($request->status !=null) {
            $status = "";
            if ($request->status == "Active")
                $status = 1;
            else
                $status = 0;
            $dataToUpdate["status"] = $status;
        }
            Product::find($id)->update([$dataToUpdate]);

            return redirect()->route("productList");
        }
    }
