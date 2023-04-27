<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function user() {
      return $this->hasOne(User::class, 'id' , 'user_id');
    }
}
