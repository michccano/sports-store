<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function getOrderData(Request $request){
        if (Gate::allows("admin"))
        {
            if ($request->ajax()) {
                return DataTables::of(Order::all())
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
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }
    public function list(){
        if (Gate::allows("admin"))
            return view("admin.order.list");
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }

    public function orderDetails($id){
        if (Gate::allows("admin"))
        {
            $order = Order::with('products','user')->where("id",$id)->first();
            return view("admin.order.detail",compact("order"));
        }
        else
            return redirect()->route("home")
                ->with("errorMessage","You are not an Admin");
    }
}
