<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\order\Order;
use App\Models\setting\Bank;
use App\Repositories\CrudRepositories;
use App\Services\Feature\OrderService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;

class TransacationController extends Controller
{   
    protected $orderService;
    protected $order;
    public function __construct(OrderService $orderService,Order $order)
    {
        $this->orderService = $orderService;
        $this->order = new CrudRepositories($order);
    }

    public function index()
    {
        $data['orders'] = $this->orderService->getUserOrder(auth()->user()->id);
        return view('frontend.transaction.index',compact('data'));
    }

    public function show($invoice_number)
    {
        $data['order'] = $this->order->Query()->where('invoice_number',$invoice_number)->first();
        $data['bank'] = Bank::get();
        $snapToken = $data['order']->snap_token;
        if (empty($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database
            $midtrans = new CreateSnapTokenService($data['order']);
            $snapToken = $midtrans->getSnapToken();
            $data['order']->snap_token = $snapToken;
            $data['order']->save();
        }
        return view('frontend.transaction.show',compact('data'));
    }

    public function metodePembayaran(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $invoice = $request->input('invoice');
            $method = $request->input('method');
    
            $order = Order::where('invoice_number', $invoice)->first();
            
            if(!$order) {
                throw new \Exception('Order not found.');
            }
    
            if($method == '0'){
                $order->metode_pembayaran = $method;
                $order->updated_at = Carbon::now();
            } else {
                $order->metode_pembayaran ='1';
            }
            $order->save();
            DB::commit();
    
            return response()->json(['message' => 'Metode pembayaran berhasil diupdate.']);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }    

    public function updatePembayaranManual(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $invoice = $request->input('invoice');
            $nRandom = $request->input('nRandom');
            $total = $request->input('total');
    
            $order = Order::where('invoice_number', $invoice)->first();
            $order->kode_unik = $nRandom;
            $order->total_pay = $total;
            $order->save();

            DB::commit();
    
            return response()->json(['message' => 'Metode pembayaran berhasil diupdate.']);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }    

    public function success($invoice_number)
    {
        $this->order->Query()->where('invoice_number',$invoice_number)->first()->update(['status' => 1,'paid_at' => Carbon::now()] );
        return back()->with('success',__('message.pembayaran berhasil'));
    }

    public function received($invoice_number)
    {
        $this->order->Query()->where('invoice_number',$invoice_number)->first()->update(['status' => 3]);
        return back()->with('success',__('message.order_received'));
    }

    public function expired($invoice_number)
    {
        $this->order->Query()->where('invoice_number',$invoice_number)->first()->update(['status' => 5]);
        return back()->with('success',__('message.pembayaran kadaluarsa'));
    }

    public function canceled($invoice_number)
    {
        $this->order->Query()->where('invoice_number',$invoice_number)->first()->update(['status' => 4]);
        return back()->with('success',__('message.order_canceled'));
    }


}
