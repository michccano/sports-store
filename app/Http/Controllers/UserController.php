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
                    $actionBtn = '<a href="/admin/order/details/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>';
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
}
