<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\master\Categori;
use App\Models\master\Product;
use App\Models\order\Order;
use App\Models\order\OrderDetail;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $category;
    protected $product;
    public function __construct(Categori $category, Product $product)
    {
        $this->category = new CrudRepositories(new Categori());
        $this->product = new CrudRepositories(new Product());
    }

    public function index()
    {
        $data['category'] = $this->category->Query()->get();
        // Langkah 1: Ambil semua ID order yang memiliki status 3
        $orderIds = Order::where('status', 3)->pluck('id');

        // Langkah 2: Ambil semua ID produk dari tabel detail_order berdasarkan ID order
        $productIds = OrderDetail::whereIn('order_id', $orderIds)->pluck('product_id');

        // Langkah 3: Hitung jumlah kemunculan setiap ID produk
        $productCounts = $productIds->countBy();

        // Langkah 4: Sort produk berdasarkan jumlah kemunculan dan ambil 6 teratas
        $mostBoughtProductIds = $productCounts->sortDesc()->keys()->take(6);

        $data['product'] = Product::whereIn('id', $mostBoughtProductIds)->orderBy('id', 'desc')->get();
        return view('frontend.home', compact('data'));
    }
}
