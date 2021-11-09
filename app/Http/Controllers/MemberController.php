<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\User\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    private $userService;
    public function __construct(IUserService $userService){
        $this->userService = $userService;
    }
    public function profile(){
        $member = $this->userService->getUserWithTokenProductRelationships();
        return view('member.profile',compact("member"));
    }

    public function getDocument($id){
        $member = $this->userService->getUserWithTokenProductRelationships();
        $product = null;
        foreach ($member->products as $mproduct){
            if($mproduct->id == $id)
                $product = $mproduct;
        }
        if($product !=null) {
            $path = "app\private\product_documents\'$product->file";
            $path = str_replace(["'"],"",$path);
            $document = storage_path($path);
            return response()->file($document);
        }
        return "document not found";
    }
}
