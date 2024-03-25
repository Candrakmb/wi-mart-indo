<?php

namespace App\Http\Controllers\Backend\setting;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Categori;
use App\Models\Setting\Alamatpengirim;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Services\Rajaongkir\RajaongkirService;

class AlamatPengirimController extends Controller
{
    protected $rajaongkirService;
    public function __construct(RajaongkirService $rajaongkirService)
    {
        $this->rajaongkirService = $rajaongkirService;
    }

    public $data = [
        'title' => 'Alamat Pengirim',
        'modul' => 'alamat_pengirim',
        'sektor' => 'backend',
        'parent' => 'setting',
        
    ];

    function alamat_pengirim(){
        
        $this->data['data'] = null;
        $this->data['provinces'] = $this->rajaongkirService->getProvince();
        $query = Alamatpengirim::orderBy('alamat_pengirim.id','desc');
        $hasil = $query->first();
        $count =$query->count();
        if($count == 0){
            $this->data['type'] = 'create';
        }else{
            $this->data['type'] = 'update';
        }
        $this->data['alamat_count'] = $count;
        $this->data['alamat_pengirim'] = $hasil;
        // dd($this->data['alamat_pengirim']);
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }
    
    public function createform(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'city_id' => 'required|integer',
                'province_id' => 'required|integer',
                'detail_alamat' => 'required|string|max:255',
                
            ]);
    
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
                // Buat objek kategori baru
                $alamat = new Alamatpengirim();
                $alamat->city_id = $request->city_id;
                $alamat->province_id = $request->province_id;
                $alamat->detail_alamat = $request->detail_alamat;
                $alamat->save();
    
                DB::commit();
                return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Ditambah!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'Validasi gagal. ' . $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }    

    public function updateform(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'city_id' => 'required|integer',
                'province_id' => 'required|integer',
                'detail_alamat' => 'required|string|max:255',
                
            ]);
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }

            // Mengecek apakah nama sudah digunakan selain oleh id yang sedang diperbarui

            // Jika nama belum digunakan selain oleh id yang sedang diperbarui, update data
                // Update data category
                $alamat = Alamatpengirim::findOrFail($request->id);
                $alamat->city_id = $request->city_id;
                $alamat->province_id = $request->province_id;
                $alamat->detail_alamat = $request->detail_alamat;
                $alamat->save();

                DB::commit();
                return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Diubah!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'Validasi gagal. ' . $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }

}
