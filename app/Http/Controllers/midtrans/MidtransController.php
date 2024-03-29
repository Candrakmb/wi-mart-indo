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
                if($request->transaction_status == 'settlement'){
                    $order->update(['status' => '1', 'paid_at' => Carbon::now()]);
                    return back()->with('success',__('message.paid_success'));
                }
                else if($request->transaction_status == 'pending'){
                    $order->update(['status' => '0']);
                }
                else if($request->transaction_status == 'deny'){
                    $order->update(['status' => '4']);
                }
                else if($request->transaction_status == 'expire'){
                    $order->update(['status' => '5']);
                    return back()->with('success',__('message.paid_expired'));
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
    }
}
