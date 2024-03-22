<?php

namespace App\Models\master;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\master\Categori;
use App\Models\order\OrderDetail;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'products';
    protected $appends = ['thumbnails_path','price_rupiah','total_sold'];
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'price',
        'weight',
        'description',
    ];

    public function categori()
    {
        return $this->belongsTo(Categori::class,'categories_id');
    }
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getThumbnailsPathAttribute()
    {
        return asset('storage/image/product/' . $this->thumbnails);
    }

    public function getPriceRupiahAttribute()
    {
        return "Rp " . number_format($this->price,0,',','.');
    }

    public function getTotalSoldAttribute()
    {
        return $this->OrderDetails()->whereHas('Order',function($q){
            $q->whereIn('status',[2,3]);
        })->sum('qty');
    }

   
}
