<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function getUserData(Request $request){
        if (Gate::allows("admin"))
        {
            if ($request->ajax()) {
                return DataTables::of(User::all())
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row['id'];
                        $actionBtn = '<a href="/admin/user/details/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>';
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
            return view("admin.user.list");
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function userDetails($id){
        if (Gate::allows("admin"))
        {
            $user = User::with('orders')->where("id",$id)->first();
            return view("admin.user.detail",compact("user"));
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function suspend($id){
        if (Gate::allows("admin"))
        {
            $user = User::where("id",$id)->first();
            $user->status = 0;
            $user->save();
            return response()->json($user->status);
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function unsuspend($id){
        if (Gate::allows("admin"))
        {
            $user = User::where("id",$id)->first();
            $user->status = 1;
            $user->save();
            return response()->json($user->status);
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }
}
