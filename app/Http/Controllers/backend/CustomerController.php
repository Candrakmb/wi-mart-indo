<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{

    public $data = [
        'title' => 'Pelanggan',
        'modul' => 'customer',
        'sektor' => 'backend'
    ];

    function customer(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function create(){
        $this->data['type'] = "create";
        $this->data['data'] = null;
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function delete(){
        $this->data['type'] = "delete";
        $this->data['data'] = null;
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function lihat(){
        $this->data['type'] = "lihat";
    	return view($this->data['sektor'].'.'.$this->data['modul'].'.index', $this->data);
    }


    function table(){
        $query = User::where('name', '!=','admin')
                ->orderBy('users.id','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }
}