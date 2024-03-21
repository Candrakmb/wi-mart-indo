<?php

namespace App\Http\Controllers\Backend\setting;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Categori;
use App\Models\setting\Bank;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AddBankController extends Controller
{

    public $data = [
        'title' => 'Bank',
        'modul' => 'bank',
        'sektor' => 'backend',
        'parent' => 'setting',
        
    ];
    
    function bank(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function create(){
        $this->data['type'] = "create";
        $this->data['data'] = null;
        $this->data['data_categori'] =Categori::get();
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function update($id){
        $this->data['type'] = "update";
        $this->data['data'] = null;
        $query = Bank::where('id', '=', $id)
                ->orderBy('bank_pembayaran_manual.id');
        $query = $query->first();
        $this->data['data'] = $query;
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }


    function table(){
        $query = Bank::orderBy('bank_pembayaran_manual.id','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a class="btn btn-warning ml-1" href="/add_bank/update/'.$row->id.'"><i class="icon-edit"></i></a> &nbsp';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->make(true);
    }
    
    public function createform(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'atas_nama' => 'required|string|max:255',
                'no_rekening' => 'required|integer',
                'nama_bank' => 'required|string|max:255',
            ]);
    
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
                // Buat objek kategori baru
                $bank = new Bank;
                $bank->atas_nama = $request->atas_nama;
                $bank->no_rekening = $request->no_rekening;
                $bank->nama_bank = $request->nama_bank;
                $bank->save();
    
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
                'atas_nama' => 'required|string|max:255',
                'no_rekening' => 'required|string|max:255',
                'nama_bank' => 'required|string|max:255',
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }

            // Mengecek apakah nama sudah digunakan selain oleh id yang sedang diperbarui
            $cek = Bank::where('no_rekening', $request->no_rekening)
                ->where('id', '!=', $request->id)
                ->first();

            // Jika nama belum digunakan selain oleh id yang sedang diperbarui, update data
            if ($cek == null) {
                // Update data category
                $bank = Bank::findOrFail($request->id);
                $bank->atas_nama = $request->atas_nama;
                $bank->no_rekening = $request->no_rekening;
                $bank->nama_bank = $request->nama_bank;
                $bank->save();

                DB::commit();
                return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Diubah!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
            } else {
                DB::rollback();
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'Nama sudah digunakan!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'Validasi gagal. ' . $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }

    public function deleteform(Request $request)
    {
        DB::beginTransaction();
    
        try {
    
            Bank::where('id', $request->id)->delete();
    
            DB::commit();
            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Dihapus!', 'ButtonColor' => '#66BB6A', 'type' => 'success']); 
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']); 
        }   
    }

}
