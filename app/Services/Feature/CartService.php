<?php
namespace App\Services\Feature;

use App\Models\order\Cart;
use App\Repositories\CrudRepositories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class CartService{

    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = new CrudRepositories($cart);
    }

    public function store($data)
    {
        $cek = $this->cart->Query()->where(['user_id' => auth()->user()->id,'product_id' => $data['cart_product_id']])->first();
        // dd($data['cart_qty']);
        if($cek){
            $cek->qty = $cek->qty + $data['cart_qty'];
            $cek->update();
        }else{
            DB::beginTransaction();
            try {
                if ($data['warna'] != null || $data['size'] != null) {
                    $cartData = new Cart;
                    $cartData->product_id = $data['cart_product_id'];
                    $cartData->qty = $data['cart_qty'];
                    $cartData->user_id = auth()->user()->id;
                    
                    if ($data['warna'] != null) {
                        $cartData->variasi_warna_id = $data['warna'];
                    }
                    
                    if ($data['size'] != null) {
                        $cartData->variasi_ukuran_id = $data['size'];
                    }
                    
                    $cartData->save();
                } else {
                    $cartData = new Cart;
                    $cartData->product_id = $data['cart_product_id'];
                    $cartData->qty = $data['cart_qty'];
                    $cartData->user_id = auth()->user()->id;
                    $cartData->save();
                }
            
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                // Handle exception
            }
            
        }
        
    }

    public function update($data)
    {
        $cek = $this->cart->Query()->where(['user_id' => auth()->user()->id,'product_id' => $data['cart_product_id']])->first();
        if($cek){
            $cek->qty = $cek->qty + $data['cart_qty'];
            $cek->update();
        }else{
            DB::beginTransaction();
            try {
                if ($data['warna'] != null || $data['size'] != null) {
                    $cartData = new Cart;
                    $cartData->product_id = $data['cart_product_id'];
                    $cartData->qty = $data['cart_qty'];
                    $cartData->user_id = auth()->user()->id;
                    
                    if ($data['warna'] != null) {
                        $cartData->variasi_warna_id = $data['warna'];
                    }
                    
                    if ($data['size'] != null) {
                        $cartData->variasi_ukuran_id = $data['size'];
                    }
                    
                    $cartData->save();
                } else {
                    $cartData = new Cart;
                    $cartData->product_id = $data['cart_product_id'];
                    $cartData->qty = $data['cart_qty'];
                    $cartData->user_id = auth()->user()->id;
                    $cartData->save();
                }
            
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                // Handle exception
            }
        }
        
    }

    public function getUserCart()
    {
        return $this->cart->Query()->where('user_id',auth()->user()->id)->get();
    }
    
    public function deleteUserCart()
    {
        return $this->cart->Query()->where('user_id',auth()->user()->id)->delete();
    }

}