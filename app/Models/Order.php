<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['address','phone'];
    use HasFactory;
    public function items()
    {
        return $this->belongsTo(Cart::class);
    }
}
