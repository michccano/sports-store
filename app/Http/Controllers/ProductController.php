<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class ProductController extends Controller
{
    public function getProductData(Request $request){
        if ($request->ajax()) {
            return DataTables::of(Product::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row['id'];
                    $actionBtn = '<a href="/admin/product/edit/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-warning edit"><i class="far fa-edit"></i></a>
                                  <button type="submit" class="btn btn-xs btn-danger" data-productid="' . $id . '" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return back(); // if http request
        }
    }

    public function list(){
        return view("admin.product.productsList2");
    }

    public function create(){
        return view("admin.product.create");
    }

    public function store(ProductCreateRequest $request){
        $title = preg_replace('/\s+/', '', $request->name);
        $imageName = time() . '-' . $title . '.' . $request->img->extension();
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
            $title = preg_replace('/\s+/', '', $request->name);
            $imageName = time() . '-' . $title . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);
            $dataToUpdate["img"] = $imageName;
        }

        if($request->status !=null) {
            if ($request->status == "Active")
                $status = 1;
            else
                $status = 0;
            $dataToUpdate["status"] = $status;
        }
            Product::find($id)->update($dataToUpdate);

            return redirect()->route("productList");
        }
    }
