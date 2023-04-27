<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\User;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';

    public function products() {
        return $this->hasMany(Product::class, 'toko_id' , 'id');
    }

    public function user() {
        return $this->belongsTo(User::class,'id' , 'user_id');
    }
}
