<?php

namespace App\Models\order;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\order\Order;

class OrderTrack extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'order_track';
    
    protected $fillable = [
        'description',
        'icon',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
   
}
