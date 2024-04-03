<?php

namespace App\Models\order;

use App\Models\master\Product;
use App\Models\master\VariasiProduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','user_id','qty'];

    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function variasiWarna()
    {
        return $this->belongsTo(VariasiProduk::class,'variasi_warna_id');
    }
    public function variasiUkuran()
    {
        return $this->belongsTo(VariasiProduk::class,'variasi_ukuran_id');
    }

    public function getTotalPricePerProductAttribute()
    {
        $price = $this->qty * $this->Product->price;
        return $price;
    }

    public function getTotalWeightPerProductAttribute()
    {
        $weight = $this->qty * $this->Product->weight;
        return $weight;
    }

}
