<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SportsPressController extends Controller
{
    public function index(){
        if(!Gate::allows('sportsPress'))
            return redirect()->route('service.error');
        else {
            return view("services.sportsPress");
        }
    }
}
