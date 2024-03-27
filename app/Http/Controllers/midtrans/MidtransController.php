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
        $hashed = hash("sha512",$request->order_id.$request->status_code.$request->gross_amont.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
                $order =Order::where('invoice_number', $request->order_id);
                $order->update(['status' => '1']);
            }
        }
        
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
