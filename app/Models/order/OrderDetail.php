<?php

namespace App\Models\order;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\order\Order;
use App\Models\master\Product;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function getTotalPricePerProductAttribute()
    {
        $price = $this->qty * $this->Product->price;
        return $price;
    }
}
