<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\User\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    private $userService;
    public function __construct(IUserService $userService){
        $this->userService = $userService;
    }
    public function profile(){
        $member = $this->userService->getUserWithTokenProductRelationships();
        foreach ($member->products as $product){
            if ($product->status == 0)
                $member->products()->detach($product->id);
            if ($product->price != null){
                if($product->pivot->type == "single") {
                    if($product->weekly_price_expire_date != null) {
                        if ($product->weekly_price_expire_date <= Carbon::now()) {
                            $member->products()->detach($product->id);
                        }
                    }
                }
                if($product->season_price_expire_date != null) {
                    if ($product->season_price_expire_date <= Carbon::now()) {
                        $member->products()->detach($product->id);
                    }
                }
            }
        }
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
            if ($product->file != null) {
                $path = "app\private\product_documents\'$product->file";
                $path = str_replace(["'"], "", $path);
                $document = storage_path($path);
                return response()->file($document);
            }
            return back()->with("errorMessage","document not found");
        }
        return back()->with("errorMessage","document not found");
    }

    public function detailInfo(){
        $member = Auth::user();
        if ($member != null)
            return view('member.detail',compact("member"));
        return back();
    }

    public function edit(){
        $member = Auth::user();
        if ($member != null)
            return view('member.editInfo',compact("member"));
        return back();
    }

    public function update(Request $request){
        $dataToUpdate = [];
        if ($request->firstname !=null)
            $dataToUpdate['firstname'] = $request->firstname;
        if ($request->lastname !=null)
            $dataToUpdate['lastname'] = $request->lastname;
        if ($request->email !=null)
            $dataToUpdate['email'] = $request->email;
        if ($request->address1 !=null)
            $dataToUpdate['address1'] = $request->address1;
        if ($request->address2 !=null)
            $dataToUpdate['address2'] = $request->address2;
        if ($request->city !=null)
            $dataToUpdate['city'] = $request->city;
        if ($request->state !=null)
            $dataToUpdate['state'] = $request->state;
        if ($request->postal !=null)
            $dataToUpdate['postal'] = $request->postal;
        if ($request->country !=null)
            $dataToUpdate['country'] = $request->country;
        if ($request->dayphone !=null)
            $dataToUpdate['dayphone'] = $request->dayphone;
        if ($request->evephone !=null)
            $dataToUpdate['evephone'] = $request->evephone;

        $member = Auth::user();
        $member->update($dataToUpdate);
        return redirect()->route("detailInfo")
            ->with("successMessage","Information Updated Succesfully");
    }

    public function orderList(){
        $orders = Order::with('products')->where("user_id",Auth::id())->get();
        return view('member.orderList',compact("orders"));
    }
}
