<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable =['name','description','price','image','category'];
    use HasFactory;
    public function items(){
     return $this->HasMany(CartItem::class);
    }

}
