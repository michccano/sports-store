<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function getOrderData(Request $request){
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
    public function list(){
        return view("admin.order.list");
    }

    public function orderDetails($id){
        $order = Order::with('products','user')->where("id",$id)->first();
        return view("admin.order.detail",compact("order"));
    }
}
