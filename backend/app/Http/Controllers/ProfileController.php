<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller {

  public function getUserProfile($id) {
       $find_user = User::with(['products'])->where('id' , $id)->first();

       if($find_user) {
           return response()->json($find_user , 200);
       }
  }

  public function updateProfile(Request $request,$id) {
     $find_user = User::find($id);

     if($find_user) {
        $find_user->name = $request->name;
        $find_user->email = $request->email;
        $find_user->bio = $request->bio;

        $save = $find_user->save();

        if($save) {
          return response()->json(['message'=>'success','data'=>$save]);
        }
     }
  }

}