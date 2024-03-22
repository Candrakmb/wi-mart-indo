<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Product;
use App\Models\User;
use App\Models\order\Order;


class DashboardController extends Controller
{

    public function index()
    {
        $data['total_product'] = Product::count();
        $data['total_user'] = User::count();
        $data['total_pending'] = Order::where('status',0)->whereMonth('created_at', Date('m'))->whereYear('created_at',Date('Y'))->count();
        $data['total_shipping'] = Order::where('status',2)->whereMonth('created_at', Date('m'))->whereYear('created_at',Date('Y'))->count();
        $data['total_completed'] = Order::where('status',3)->whereMonth('created_at', Date('m'))->whereYear('created_at',Date('Y'))->count();
        $data['total_order'] = $data['total_pending'] + $data['total_shipping'] + $data['total_completed'];

        $data['best_products'] = Product::select('products.*')
        ->join('order_details', 'products.id', '=', 'order_details.product_id')
        ->selectRaw('products.*, SUM(order_details.qty) as total_qty')
        ->groupBy('products.id')
        ->orderByDesc('total_qty')
        ->limit(10)
        ->get();

        $data['last_order'] = Order::orderBy('id','DESC')->limit(5)->get();
        $data['chart'] = $this->chartOrder->build();
        $data['chartPie'] = $this->chartOrderPie->build();
        return view('backend.dashboard');
    }
}