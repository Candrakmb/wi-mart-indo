<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\order\Cart;
use App\Models\Setting\Alamatpengirim;
use App\Models\master\Categori;
use App\Repositories\CrudRepositories;
use App\Services\Feature\CartService;
use App\Services\Feature\CheckoutService;
use App\Services\Rajaongkir\RajaongkirService;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    protected $rajaongkirService,$checkoutService,$cartService;
    public function __construct(RajaongkirService $rajaongkirService,CheckoutService $checkoutService,CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->rajaongkirService = $rajaongkirService;
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $data['carts'] = $this->cartService->getUserCart();
        $data['provinces'] = $this->rajaongkirService->getProvince();
        $data['shipping_address'] = Alamatpengirim::first();
        $data['kategori'] = Categori::where('name', 'Kebutuhan Rumah')->first();
        return view('frontend.checkout.index',compact('data'));
    }

    public function process(Request $request)
    {
            $request->validate([
                'recipient_name' => ['required', 'string', 'max:255'],
                'phone_number' => ['required', 'regex:/^(?:\+62|0)\d{9,12}$/'],
                'province_id' => ['required' ],
                'city_id' => ['required'],
                'address_detail' => ['required', 'string', 'max:255'],
                'courier' => ['required', 'string', 'max:255'],
                'shipping_method' => ['required', 'string', 'max:255'],
            ]);
            
            $this->checkoutService->process($request->all());
            return redirect()->route('transaction.index')->with('success',__('message.order_success'));
    }
}
