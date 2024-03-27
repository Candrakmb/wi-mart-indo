<?php

namespace App\Http\Controllers\Backend\order;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\order\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

    public $data = [
        'title' => 'Pesanan',
        'modul' => 'order',
        'sektor' => 'backend'
    ];

    function order($status){
        $this->data['type'] = "index";
        $this->data['data'] = null;
        $this->data['status'] = $status;
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function lihat($id){
        $this->data['type'] = "lihat";
        $this->data['data'] = null;
        $this->data['orders'] = Order::where('id',$id)->first();
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function table($status){
        if ($status == 'all') {
            $query = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->orderBy('orders.id', 'desc')
                ->selectRaw('orders.*, users.name as user_name, DATE_FORMAT(orders.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
                ->get();
        } else {
            $query = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where('orders.status', '=', $status)
                ->orderBy('orders.id', 'desc')
                ->selectRaw('orders.*, users.name as user_name, DATE_FORMAT(orders.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
                ->get();
        }  
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = ''; 
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-3">';
                $btn .= '<a class="btn btn-warning ml-1" href="/order/lihat/'.$row->id.'"><i class="fa fa-info"></i></a> &nbsp';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('status_name', function($row){
                $status = ''; 
                $status .= '<div class="text-center">';
                $status .= '<div class="btn-group btn-group-solid mx-3">';
                if ($row->status == 0) {
                    $status .= '<div class="badge rounded-pill bg-warning">Menunggu Pembayaran</div>';
                }
                if ($row->status == 1) {
                    $status .= '<div class="badge rounded-pill bg-primary">Dikemas</div>';
                }
                if ($row->status == 2) {
                    $status .= '<div class="badge rounded-pill bg-info">Dikirim</div>';
                }
                if ($row->status == 3) {
                    $status .= '<div class="badge rounded-pill bg-success">Selesai</div>';
                }
                if ($row->status == 4) {
                    $status .= '<div class="badge rounded-pill bg-secondary">Dibatalkan</div>';
                }
                if ($row->status == 5) {
                    $status .= '<div class="badge rounded-pill bg-secondary">Kadaluarsa</div>';
                }
                $status .= '</div>';    
                $status .= '</div>';
                return $status;
            })
            ->addColumn('metode_pembayaran_name', function($row){
                $metode = ''; 
                $metode .= '<div class="text-center">';
                $metode .= '<div class="btn-group btn-group-solid mx-3">';
                if ($row->metode_pembayaran == 0) {
                    $metode .= '<div class="badge rounded-pill bg-primary">Transfer Bank Manual</div>';
                }
                if ($row->metode_pembayaran == 1) {
                    $metode .= '<div class="badge rounded-pill bg-primary">Midtrans</div>';
                }
                $metode .= '</div>';    
                $metode .= '</div>';
                return $metode;
            })

            ->rawColumns(['metode_pembayaran_name','status_name','action'])
            ->make(true);
    }

    function konfirmasiform(Request $request){
        DB::beginTransaction();
        try{
                $id = $request->input('id');
                Order::where('id', $id)
                ->update(
                    [
                        'status' => '1',
                        'paid_at' => Carbon::now(),            
                    ]
                );

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Diubah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 

    }

    function resiform(Request $request){
        DB::beginTransaction();
        try{
                Order::where('id', $request->id)
                ->update(
                    [
                        'status' => '2',
                        'receipt_number' => $request->resi,            
                    ]
                );

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Diubah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 

    }
    
    function updateform(Request $request){
        DB::beginTransaction();
        try{
           
            
                Order::where('id', $request->id)
                ->update(
                    [
                        'receipt_number' => $request->receipt_number, 
                    ]
                    );


                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil ditambahkan!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

    function deleteform(Request $request){

        DB::beginTransaction();
        try{
            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

}