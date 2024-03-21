<?php

namespace App\Models\setting;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Alamatpengirim extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'alamat_pengirim';
    
    protected $fillable = [
        'city_id',
        'province_id',
    ];
   
}
