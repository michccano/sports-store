<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class ProductController extends Controller
{
    public function getProductData(Request $request){
        if (Gate::allows("admin")){
            if ($request->ajax()) {
                return DataTables::of(Product::with('category')->get())
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row['id'];
                        $actionBtn = '<a href="/admin/product/edit/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-warning edit"><i class="far fa-edit"></i></a>
                                  <button type="submit" class="btn btn-xs btn-danger" data-productid="' . $id . '" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i></button>
                                  <a href="#" data-id="' . $id . '" class="btn btn-xs btn-info"><i class="fas fa-file-pdf"></i></a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return back(); // if http request
            }
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function list(){
        if (Gate::allows("admin"))
            return view("admin.product.productsList2");
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function create(){
        if (Gate::allows("admin"))
        {
            $categories = Category::all();
            $month = date('m');
            $day = date('d');
            $year = date('Y');

            $today = $year . '-' . $month . '-' . $day;
            return view("admin.product.create",compact("categories","today"));
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function store(ProductCreateRequest $request){
        if (Gate::allows("admin"))
        {
            $title = preg_replace('/\s+/', '', $request->name);
            $titleWithOutRegExpression = str_replace( array( '\'', '!','”','#','$','%','&','’','(', '*','+',',',
                '-','.','/',':',';','<','=','>','?','@','[',']','^','_','`','{','|','}','~'), '', $title);
            $imageName = time() . '-' . $titleWithOutRegExpression . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);

            Product::create([
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "weekly_price" => $request->weekly_price,
                "img" => $imageName,
                "display_date" => $request->display_date,
                "expire_date" => $request->expire_date,
                "weekly_price_expire_date" => $request->weekly_price_expire_date,
                "delivery_method" => $request->delivery_method,
                "category_id" => $request->category,
            ]);

            return redirect()->route("productList");
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function delete(Request $request){
        if (Gate::allows("admin"))
        {
            $id = $request->product_id;
            Product::find($id)->delete();
            return redirect()->route("productList");
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function edit($id){
        if (Gate::allows("admin"))
        {
            $product = Product::find($id);
            $categories = Category::all();
            return view("admin.product.edit",compact('product','categories'));
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function update(ProductUpdateRequest $request, $id){
        if (Gate::allows("admin"))
        {
            $dataToUpdate = [];
            if($request->name!= null)
                $dataToUpdate["name"] = $request->name;

            if ($request->description != null)
                $dataToUpdate["description"] = $request->description;

            if ($request->price != null)
                $dataToUpdate["price"] = $request->price;

            $dataToUpdate["weekly_price"] = $request->weekly_price;

            if ($request->img != null) {
                $title = preg_replace('/\s+/', '', $request->name);
                $titleWithOutRegExpression= str_replace( array( '\'', '!','”','#','$','%','&','’','(', '*','+',',',
                    '-','.','/',':',';','<','=','>','?','@','[',']','^','_','`','{','|','}','~'), '', $title);
                $imageName = time() . '-' . $titleWithOutRegExpression . '.' . $request->img->extension();
                $request->img->move(public_path('images'), $imageName);
                $dataToUpdate["img"] = $imageName;
            }

            if ($request->category != null)
                $dataToUpdate["category_id"] = $request->category;

            if ($request->display_date != null)
                $dataToUpdate["display_date"] = $request->display_date;

            if ($request->expire_date != null)
                $dataToUpdate["expire_date"] = $request->expire_date;

            if ($request->weekly_price_expire_date !=null)
                $dataToUpdate["weekly_price_expire_date"] = $request->weekly_price_expire_date;

            if ($request->delivery_method != null)
                $dataToUpdate["delivery_method"] = $request->delivery_method;

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
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

}
