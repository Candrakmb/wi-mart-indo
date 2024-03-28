<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Product;
use App\Models\User;
use App\Models\order\Order;
use App\Charts\OrderCart;
use App\Charts\OrderChartPie;


class DashboardController extends Controller
{
    protected $chartOrder,$chartOrderPie;
     
    public function __construct(OrderCart $chartOrder,OrderChartPie $chartOrderPie)
    {
        $this->chartOrder = $chartOrder;
        $this->chartOrderPie = $chartOrderPie;
    }

    public $data = [
        'title' => ' Dashboard',
    ];

    public function index()
    {
         $this->data['total_product'] = Product::count();
         $this->data['total_user'] = User::count();
         $this->data['total_pending'] = Order::where('status',0)->whereMonth('created_at', Date('m'))->whereYear('created_at',Date('Y'))->count();
         $this->data['total_shipping'] = Order::where('status',2)->whereMonth('created_at', Date('m'))->whereYear('created_at',Date('Y'))->count();
         $this->data['total_completed'] = Order::where('status',3)->whereMonth('created_at', Date('m'))->whereYear('created_at',Date('Y'))->count();
         $this->data['total_order'] =  $this->data['total_pending'] +  $this->data['total_shipping'] +  $this->data['total_completed'];

         $this->data['best_products'] = Product::with(['OrderDetails'])
        ->withSum('OrderDetails','qty')
        ->orderByDesc('order_details_sum_qty')
        ->limit(10)
        ->get();

        $this->data['last_order'] = Order::orderBy('id','DESC')->limit(5)->get();
        $this->data['chart'] = $this->chartOrder->build();
        $this->data['chartPie'] = $this->chartOrderPie->build();
        return view('backend.dashboard', $this->data);
    }
}