<?php

namespace App\Http\Controllers;

use App\Models\Pick;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PickController extends Controller
{
    public function list()
    {
        return view('admin.pick.list');
    }

    public function getPicksData(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pick::all())
                ->addIndexColumn()
                // ->addColumn('action', function ($row) {
                //     $id = $row['id'];
                //     $actionBtn = '<a href="/admin/sport/edit/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-warning edit"><i class="far fa-edit"></i></a>
                //                   <button type="submit" class="btn btn-xs btn-danger" data-categoryid="' . $id . '" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i></button>';
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->make(true);
        } else {
            return back(); // if http request
        }
    }
}
