<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\order\Cart;
use App\Models\Master\Product;
use App\Models\master\VariasiProduk;
use App\Repositories\CrudRepositories;
use App\Services\Feature\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    protected $cartService;
    public function __construct(Cart $cart,CartService $cartService)
    {
        $this->cart = new CrudRepositories($cart);
        $this->cartService = $cartService;
    }

    public function index()
    {
        $data['carts'] = $this->cart->Query()->where('user_id',auth()->user()->id)->get();
        // dd($data['carts']);
        return view('frontend.cart.index', compact('data'));
    }    

    public function store(Request $request)
    {
        try {
            $cek = VariasiProduk::where('product_id', $request->cart_product_id)->get();
            $ukuranDitemukan = false;
            $warnaDitemukan = false;
            foreach ($cek as $item) {
                if ($item->jenis == 'ukuran') {
                    $ukuranDitemukan = true;
                }
                if ($item->jenis == 'warna') {
                    $warnaDitemukan = true;
                }
            }
            if($ukuranDitemukan && $warnaDitemukan){
                if($request->warna == '' || $request->size == '' ){
                    if ($request->warna == '') {
                        return response()->json([
                            'title' => 'Peringatan!',
                            'icon' => 'warning',
                            'text' => 'belum memilih warna!',
                            'ButtonColor' => '#FFA500',
                            'type' => 'warning'
                        ]);
                    } else if($request->size == '') {
                        return response()->json([
                            'title' => 'Peringatan!',
                            'icon' => 'warning',
                            'text' => 'belum memilih Size!',
                            'ButtonColor' => '#FFA500',
                            'type' => 'warning'
                        ]);
                    }
                }else {
                    $this->cartService->store($request);
                    return response()->json([
                        'type' => 'success'
                    ]);
                }  
            } else if ($ukuranDitemukan){
                if ($request->size == '') {
                    return response()->json([
                        'title' => 'Peringatan!',
                        'icon' => 'warning',
                        'text' => 'belum memilih Size!',
                        'ButtonColor' => '#FFA500',
                        'type' => 'warning'
                    ]);
                }else {
                    $this->cartService->store($request);
                    return response()->json([
                        'type' => 'success'
                    ]);
                }  
            }
            else if ($warnaDitemukan){
                if ($request->warna == '') {
                    return response()->json([
                        'title' => 'Peringatan!',
                        'icon' => 'warning',
                        'text' => 'belum memilih warna!',
                        'ButtonColor' => '#FFA500',
                        'type' => 'warning'
                    ]);
                }else {
                    $this->cartService->store($request);
                    return response()->json([
                        'type' => 'success'
                    ]);
                }  
            }else if( !$ukuranDitemukan && !$warnaDitemukan ){
                $this->cartService->store($request);
                return response()->json([
                    'type' => 'success'
                ]);
            }
        } catch (\Throwable $th) {
            dd($th);
        }
         //    $this->cartService->store($request);
        //     return redirect()->route('cart.index')->with('success',__('message.cart_success'));
    }

    public function delete($id)
    {
        $cart = $this->cart->hardDelete($id);
        return back()->with('success',__('message.cart_delete'));
    }

    public function update(Request $request)
    {
        try {
            $i = 0;
            foreach($request['cart_id'] as $cart_id)
            {
                $cart = $this->cart->find($cart_id);
                $cart->qty = $request['cart_qty'][$i];
                $cart->save();                    
                $i++;
            }
            return redirect()->route('cart.index')->with('success',__('message.cart_update'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
