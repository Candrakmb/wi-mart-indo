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
        $this->category = new CrudRepositories($category);
    }

    public function index()
    {
        $data['new_categories'] = $this->category->Query()->limit(4)->get();
        return view('frontend.home', compact('data'));
    }
}
