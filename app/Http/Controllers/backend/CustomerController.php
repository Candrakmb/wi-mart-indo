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
    
    function createform(Request $request){
        DB::beginTransaction();
        try{
            $cek = DB::table('sektor_rak')
            ->select('id_sektor')
            ->where('kode_sektor', '=', $request->kode_sektor)
            ->first();
            if($cek == null){
                $sektorRak = new SektorRak();
                $sektorRak->nama_sektor = $request->nama_sektor;
                $sektorRak->kode_sektor = $request->kode_sektor;
                $sektorRak->save();

                $data = $request->only(
                    [
                        'nama_rak',
                        'kode_rak', 
                        'tipe_rak', 
                        'id_dimensi',
                        'daya_tampung',
                    ]
                );

                if ($data['nama_rak']) {
                    foreach ($data['nama_rak'] as $key => $value) {
                        $rak = new Rak();
                        $rak->id_sektor=$sektorRak->id;
                        $rak->nama_rak=$data['nama_rak'][$key];
                        $rak->kode_rak = $data['kode_rak'][$key];
                        $rak->tipe_rak = $data['tipe_rak'][$key];
                        $rak->id_dimensi_rak = $data['id_dimensi'][$key];
                        $rak->daya_tampung = $data['daya_tampung'][$key];
                        $rak->save();
                    } 
                }

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Ditambah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else{
                DB::rollback();
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'kode sektor sama!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
            
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
            $cek = DB::table('sektor_rak')
            ->select('id_sektor')
            ->where('kode_sektor', '=', $request->kode_sektor)
            ->where('id_sektor', '!=', $request->id_sektor)
            ->first();
            if($cek == null){
                SektorRak::where('id_sektor', $request->id_sektor)
                ->update(
                    [
                        'nama_sektor' => $request->nama_sektor,
                        'kode_sektor' => $request->kode_sektor,            
                    ]
                );
                $data = $request->only(
                    [
                        'id_rak',
                        'nama_rak',
                        'kode_rak', 
                        'tipe_rak', 
                        'id_dimensi',
                        'daya_tampung',
                    ]
                );
                if ($data['nama_rak']) {
                    $existingRaks = Rak::where('id_sektor', $request->id_sektor)->get();
                
                    // Ambil id_rak dari data rak yang sudah ada
                    $existingRakIds = $existingRaks->pluck('id_rak')->toArray();
                
                    if (count($existingRaks) > 0) {
                        Rak::where('id_sektor', $request->id_sektor)->delete();
                    }
                
                    foreach ($data['nama_rak'] as $key => $value) {
                        $rak = new Rak();
                
                        // Jika id_rak ada dalam data rak yang sudah ada, gunakan id_rak tersebut
                        if (in_array($data['id_rak'][$key], $existingRakIds)) {
                            $rak->id_rak = $data['id_rak'][$key];
                        }
                
                        $rak->id_sektor = $request->id_sektor;
                        $rak->nama_rak = $data['nama_rak'][$key];
                        $rak->kode_rak = $data['kode_rak'][$key];
                        $rak->tipe_rak = $data['tipe_rak'][$key];
                        $rak->id_dimensi_rak = $data['id_dimensi'][$key];
                        $rak->daya_tampung = $data['daya_tampung'][$key];
                        $rak->save();
                    }
                }
                

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Diubah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else{
                DB::rollback();
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Username Sudah Digunakan!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
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
            $data = $request->only(
                [
                    'id_rak',
                ]
            );
            if ($data['id_rak']) {
                foreach ($data['id_rak'] as $key => $value) {
                    Rak::where('id_rak', $data['id_rak'][$key])->delete();
                } 
            }
            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

}
