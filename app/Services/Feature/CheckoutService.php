<?php
namespace App\Services\Feature;

use App\Models\order\Order;
use App\Models\order\OrderDetail;
use App\Repositories\CrudRepositories;
use Illuminate\Support\Str;

class CheckoutService{

    protected $order,$ordeDetail;
    protected $cartService;
    public function __construct(Order $order,OrderDetail $orderDetail,CartService $cartService)
    {
        $this->order = new CrudRepositories($order);
        $this->ordeDetail = new CrudRepositories($orderDetail);
        $this->cartService = $cartService;
    }

    public function process($request)
    {
        $userCart = $this->cartService->getUserCart();
        $subtotal =  $userCart->sum('total_price_per_product');
        $total_pay = $subtotal + $request['shipping_cost']; 
        $dataOrder = [
            'invoice_number' => strtoupper(Str::random('6')),
            'user_id' => auth()->user()->id,
            'total_pay' => $total_pay,
            'recipient_name' => $request['recipient_name'],
            'destination' =>  $request['city_id'] . ', ' . $request['province_id'] ,
            'address_detail' => $request['address_detail'],
            'courier' => $request['courier'],
            'phone_number' => $request['phone_number'],
            'subtotal' => $subtotal,
            'shipping_cost' => $request['shipping_cost'],
            'shipping_method' => $request['shipping_method'],
            'total_weight' => $request['total_weight'],
            'status' => 0,
        ];
        // dd($dataOrder);
        $orderStore = $this->order->store($dataOrder);
        foreach($userCart as $cart){
            $this->ordeDetail->store([
                'order_id' => $orderStore->id,
                'product_id' => $cart->product_id,
                'qty' => $cart->qty
            ]);
        }
        $this->cartService->deleteUserCart();
    }

}