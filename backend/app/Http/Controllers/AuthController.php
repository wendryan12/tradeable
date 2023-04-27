<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AuthController extends Controller {

     public function login(Request $request) {
         $validate = Validator::make($request->all(),[
            'email'=>['required'],
            'password'
         ]);

         if($validate->fails()) {
             return response()->json($validate->errors(), 400);
         }

         if (! $token = auth()->attempt(['email'=>$request->email,'password'=>$request->password])) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
         
        return $this->respondWithToken($token);

     }

     public function register(Request $request) {
        $validate = Validator::make($request->all(),[
            'email'=>['required','unique:users'],
            'password'=>['required', 'min:6'],
            'name'=>['required'],
            'confirm'=>['required','same:password']
         ]);

         if($validate->fails()) {
            return response()->json(["message"=>$validate->errors()->first()], 400);
         }

         $create_user = User::create([
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "name"=>$request->name 
         ]);

         if($create_user) {
            return response()->json(["message"=>"success create account"]);
         } 

         return response()->json(['message'=>'failed while create account'], 400);
     }

     protected function respondWithToken($token)
     {
         return response()->json([
             'access_token' => $token,
             'token_type' => 'bearer',
             'expires_in' => auth()->factory()->getTTL() * 60
         ]);
     }

}