<?php

namespace App\Models\master;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\master\Categori;

class Products extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'price',
        'weight',
        'description',
    ];

    public function Categori()
    {
        return $this->belongsTo(Categori::class,'categories_id');
    }

   
}
