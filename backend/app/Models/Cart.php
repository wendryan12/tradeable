<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    public function user() {
       return $this->hasOne(User::class,'id' , 'user_id');
    }

    public function product() {
       return $this->hasOne(Product::class,'id' , 'product_id');
    }
}
