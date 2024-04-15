<?php
namespace App\Services\Feature;

use App\Models\order\Order;
use App\Models\order\OrderDetail;
use App\Repositories\CrudRepositories;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            foreach ($userCart as $cart) {
                $orderDetailData = new OrderDetail;
                $orderDetailData->order_id =$orderStore->id;
                $orderDetailData->product_id = $cart->product_id;
                $orderDetailData->qty =$cart->qty;
        
                if ($cart->variasi_warna_id != null) {
                    $orderDetailData->variasi_warna_id = $cart->variasi_warna_id;
                } 
                if ($cart->variasi_ukuran_id != null) {
                    $orderDetailData->variasi_ukuran_id = $cart->variasi_ukuran_id;
                }
        
                $orderDetailData->save();
            }
            // dd($orderDetailData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle exception
        }
        $this->cartService->deleteUserCart();
    }

}