<?php

namespace App\Http\Controllers\midtrans;

use App\Http\Controllers\Controller;
use App\Services\Midtrans\CallbackService;
use App\Models\order\Order;
use App\Services\Midtrans\Midtrans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function receive( Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512",$request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            $order = Order::where('invoice_number', $request->order_id)->first();
            // if($request->transaction_status == 'capture'){
                if($request->transaction_status == 'settlement'){
                    $order->update(['status' => '1', 'paid_at' => Carbon::now()]);
                }
                else if($request->transaction_status == 'pending'){
                    $order->update(['status' => '0']);
                }
                else if($request->transaction_status == 'deny'){
                    $order->update(['status' => '4']);
                }
                else if($request->transaction_status == 'expire'){
                    $order->update(['status' => '5']);
                }
                else if($request->transaction_status == 'cancel'){
                    $order->update(['status' => '4']);
                }
                return response()
                ->json([
                    'success' => true,
                    'message' => $order->invoice_number,
                ]);
            }
            
        // }
        
            // $callback = new CallbackService;
            
            // if ($callback->isSignatureKeyVerified()) {
            //     $notification = $callback->getNotification();
            //     $order = $callback->getOrder();

            //     // $orderNumber = $order->order_id;
            //     // $id_order = explode("_",$orderNumber)[1];
    
            //     if ($callback->isSuccess()) {
            //         Order::where('invoice_number', $order->order_id)->update([
            //             'status' => 1,
            //             'paid_at'=> Carbon::now(),  
            //         ]);
            //     }
    
            //     if ($callback->isExpire()) {
            //         Order::where('invoice_number', $order->order_id)->update([
            //             'status' => 5,
            //         ]);
            //     }
    
            //     if ($callback->isCancelled()) {
            //         Order::where('invoice_number', $order->order_id)->update([
            //             'status' => 4,
            //         ]);
            //     }
    
            //     return response()
            //         ->json([
            //             'success' => true,
            //             'message' => $order->order_id,
            //         ]);
            // } else {
            //     return response()
            //         ->json([
            //             'error' => true,
            //             'message' => 'Signature key torder_idak terverifikasi',
            //         ], 403);
            // }
    }
}
