<?php

namespace App\Models\order;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\order\OrderDetail;
use App\Models\order\OrderTrack;
class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'orders';
    
    protected $fillable = [
        'invoice_number',
        'total_pay',
        'status',
        'metode_pembayaran',
        'paid_at',
        'recipient_name',
        'snap_token',
        'destination',
        'address_detail',
        'courier',
        'subtotal',
        'shipping_cost',
        'shipping_method',
        'receipt_number',
        'total_weight',

    ];


    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }


    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
    public function OrderTrack()
    {
        return $this->hasMany(OrderTrack::class,'order_id','id');
    }

    public function getStatusNameAttribute()
    {
        $status = [
            '0' => '<div class="badge badge-warning">Menunggu Pembayaran</div>',
            '1' => '<div class="badge badge-primary">Dikemas</div>',
            '2' => '<div class="badge badge-info">Dikirim</div>',
            '3' => '<div class="badge badge-success">Selesai</div>',
            '4' => '<div class="badge badge-secondary">Dibatalkan</div>',
            '5' => '<div class="badge badge-secondary">Kadaluarsa</div>',
        ];
        return $status[$this->status];
    }
   
}
