<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class ProductController extends Controller {
 
    public function getAllProduct() {
        $all_product = Product::with(['user'])->get();

        return response()->json($all_product,200);
    }

    public function detailProduct($id) {
        if(!$id) {
           return response()->json(['message'=>'No product found'] ,404);
        }

        $find_product = Product::with(['user'])->where('id' , $id)->first();

        return response()->json($find_product,200);
    }

    public function createProduct(Request $request) {

        $verify_user = User::find($request->user_id);

        if(!$verify_user) {
            return response()->json(['message'=>'Unauthorized'], 401);
        }

        $validate = Validator::make($request->all() , [
            'title'=>'required',
            'image'=>'required',
            'price'=>'required',
            'description'=>'required',
            'category'=>'required'
        ]);

        $today = Carbon::now();
        $format_image = null;

        if($validate->fails()) {
            return response()->json(['message'=>$validate->errors()->first()]);
        }

        $create_product = new Product;

        $create_product->title = $request->title;
        $create_product->price = $request->price;
        $create_product->description = $request->description;
        $create_product->category = $request->category;
        $create_product->user_id = $request->user_id;


        if($request->hasFile('image')) {
             $storage = Storage::disk('product_image');
             $format_image = $today->format("Ymd_Hms") . '_' . $request->title . '.' . $request->file('image')->getClientOriginalExtension();

              $storage->putFileAs(null,$request->file('image'),$format_image);
             $create_product->image = $format_image;
        }


        $save = $create_product->save();

        if($save) {
            return response()->json(['message'=>'success create product' , 'data'=>$save]);
        }
    } 

    public function deleteProduct($id) {
        $find_product = Product::find($id);

        if($find_product) {
             $storage = Storage::disk('product_image');

             if($storage->exists($find_product->image)) {
                $storage->delete($find_product->image);
             }

             $delete = Product::where('id',$id)->delete();

             if($delete) {
               return response()->json(['message'=>'success delete product' , 'data'=>$delete]);
             }
        }
    }

    public function updateProduct(Request $request,$id) {
        $verify_user = User::find($request->user_id);

        if(!$verify_user) {
            return response()->json(['message'=>'Unauthorized'], 401);
        }

        $validate = Validator::make($request->all() , [
            'title'=>'required',
            'image'=>'required',
            'price'=>'required',
            'description'=>'required',
            'category'=>'required'
        ]);

        if($validate->fails()) {
             return response()->json(['message'=>$validate->errors()->first()]);
        }
        
        $today = Carbon::now();
        $format_image = null;
        $find_product = Product::find($id);

        if($request->hasFile('image')) {
             $storage = Storage::disk('product_image');

             if($storage->exists($find_product->image)) {
                 $storage->delete($find_product->image);
             }

             $format_image = $today->format("Ymd_Hms") . '_' . $request->title . '.' . $request->file('image')->getClientOriginalExtension();
             $storage->putFileAs(null, $request->file('image'),$format_image,[]);
             
             $find_product->image = $format_image;
        }

        $find_product->title = $request->title;
        $find_product->price= $request->price;
        $find_product->description = $request->description;
        $find_product->category = $request->category;

        $save = $find_product->save();

        if($save) {
            return response()->json(['message'=>'success create product','data'=>$save]);
        }
    }

}