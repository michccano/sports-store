<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function create(){
        if (Gate::allows("admin"))
            return view('admin.category.create');
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function store(Request $request){
        if (Gate::allows("admin"))
        {
            Category::create([
                'name' =>  $request->name,
            ]);

            return redirect()->route('categoryList');
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function getCategoriesData(Request $request){
        if (Gate::allows("admin"))
        {
            if ($request->ajax()) {
                return DataTables::of(Category::all())
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row['id'];
                        $actionBtn = '<a href="/admin/category/edit/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-warning edit"><i class="far fa-edit"></i></a>
                                  <button type="submit" class="btn btn-xs btn-danger" data-categoryid="' . $id . '" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i></button>';
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
            return view('admin.category.list');
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function edit($id){
        if (Gate::allows("admin"))
        {
            $category = Category::where('id',$id)->first();
            return view('admin.category.edit',compact('category'));
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function update(Request $request,$id){
        if (Gate::allows("admin"))
        {
            $category = Category::findOrFail($id);
            $dataToUpdate = [];

            if($request->name!= null)
                $dataToUpdate["name"] = $request->name;

            if($request->status !=null) {
                if ($request->status == "Active")
                    $status = 1;
                else
                    $status = 0;
                $dataToUpdate["status"] = $status;
            }
            $category->update($dataToUpdate);
            return redirect()->route('categoryList');
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function delete(Request $request){
        if (Gate::allows("admin")){
            $id = $request->category_id;
            Category::find($id)->delete();
            return redirect()->route("productList");
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }
}
