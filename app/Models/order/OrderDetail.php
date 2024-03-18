<?php

namespace App\Models\order;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\master\Product;

class OrderDetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'order_detail';
    
    protected $fillable = [
        'qty',
    ];

    public function custemer()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
