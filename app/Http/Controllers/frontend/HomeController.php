<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\master\Categori;
use App\Models\master\Product;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = new CrudRepositories(new Product());
    }

    public function index()
    {
        $data['product'] = $this->product->Query()->orderBy('id', 'desc')->limit(6)->get();
        return view('frontend.home', compact('data'));
    }
}
