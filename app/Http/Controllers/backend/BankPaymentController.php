<?php

namespace App\Http\Controllers\backend;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Categori;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\setting\Bank;

class BankPaymentController extends Controller
{

    public $data = [
        'title' => 'Bank Payment',
        'modul' => 'bank_payment',
        'sektor' => 'backend',
        
    ];
    
    function bank_payment(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
        $this->data['data-bank']= Bank::get();
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function update($id){
        $this->data['type'] = "update";
        $this->data['data'] = null;
        $query = categori::query()
                ->where('id', '=', $id)
                ->orderBy('categories.id');
        $query = $query->first();
        $this->data['data'] = $query;

    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    

}
