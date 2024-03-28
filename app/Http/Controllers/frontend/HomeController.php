<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\master\Categori;
use App\Models\master\Product;
use App\Repositories\CrudRepositories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $category;
    public function __construct(Categori $category)
    {
        $this->category = new CrudRepositories(new Categori());
    }

    public function index()
    {
        $data['category'] = $this->category->Query()->orderBy('id', 'desc')->limit(6)->get();
        return view('frontend.home', compact('data'));
    }
}
