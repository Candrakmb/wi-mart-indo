<?php

namespace App\Models\master;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\master\Product;

class Categori extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'categories';
    
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
    ];

    public function Products()
    {
        return $this->hasMany(Product::class,'categories_id','id');
    }
   
}
