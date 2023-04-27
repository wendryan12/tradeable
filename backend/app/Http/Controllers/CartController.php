<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Cart;

class CartController extends Controller
{
    public function getUserCarts(Request $request) {
        $user_cart = Cart::with(['user' , 'product'])->where('user_id' , $request->query('user_id'));

        return response()->json($user_cart->get(),200);
    }

    public function createCart(Request $request) {
        $validate = Validator::make($request->all() , [
            'user_id'=>['required'],
            'product_id'=>['required'],
            'qty'=>['required'],
        ]);

        if($validate->fails()){
            return response()->json(['message'=>$validate->errors()->first()]);
        }

        $find_cart = Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id);

        if($find_cart->first()) {
            $find_cart->update([
                'qty'=>$find_cart->first()->qty + $request->qty
            ]);

            return response()->json(['message'=>'updated cart'], 200);
        }
   
        $create_cart = new Cart;

        $create_cart->user_id = $request->user_id;
        $create_cart->product_id = $request->product_id;
        $create_cart->qty = $request->qty;

        $saved = $create_cart->save();

        if($saved) {
            return response()->json([
                "message"=>'success added cart',
                "data"=>$saved
            ], 200);
        } else {
            return response()->json(["message"=>"error while creating cart"], 400);
        }

    }

    public function deleteCart($id) {
        $find_cart = Cart::where('id' , $id);

        if($find_cart->first()) {
            $delete = $find_cart->delete();

            if($delete) {
                return response()->json(['message'=>'deleted cart'], 200);
            }

            return response()->json(['message'=>'delete failed'],400);
        }
        
    }

    public function updateQtyCart(Request $request,$id) {
        $find_cart = Cart::where('id' , $id);

        if($request->type === "increase") {

        }
    }
}
