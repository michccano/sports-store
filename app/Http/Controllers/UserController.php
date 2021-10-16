<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function getUserData(Request $request){
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
    public function list(){
        return view("admin.user.list");
    }

    public function userDetails($id){
        $user = User::where("id",$id)->first();
        return view("admin.user.detail",compact("user"));
    }

    public function suspend($id){
        $user = User::where("id",$id)->first();
        $user->status = 0;
        $user->save();
        return response()->json($user->status);
    }

    public function unsuspend($id){
        $user = User::where("id",$id)->first();
        $user->status = 1;
        $user->save();
        return response()->json($user->status);
    }
}
