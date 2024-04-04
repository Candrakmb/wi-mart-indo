<?php

namespace App\Models\setting;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'bank_pembayaran_manual';
    
    protected $fillable = [
        'atas_nama',
        'no_rekening',
        'nama_bank',
    ];
   
}
