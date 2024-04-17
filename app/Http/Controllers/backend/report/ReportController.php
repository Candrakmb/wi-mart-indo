<?php

namespace App\Http\Controllers;

use App\Models\master\Categori;
use App\Models\master\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public $data = [
        'title' => 'Report',
        'modul' => 'report',
        'sektor' => 'backend',
        
    ];
    
    function report(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
        $this->data['categori']= Categori::get();
        $this->data['categori']= Categori::get();
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function filter(Request $request){
        $sql = Product::get();
    }

    function table(Request $request){
        $query = $request->sql;
        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }
}
