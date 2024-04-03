<?php

namespace App\Models\master;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\master\Product;
 
class VariasiProduk extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
