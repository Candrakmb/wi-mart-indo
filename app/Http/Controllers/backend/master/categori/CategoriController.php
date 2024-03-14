<?php

namespace App\Http\Controllers\backend\master\categori;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Categori;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CategoriController extends Controller
{

    public $data = [
        'title' => 'Category',
        'modul' => 'categori',
        'sektor' => 'backend',
        'parent' => 'master',
        
    ];
    
    function categori(){
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
        $query = categori::query()
                ->where('id', '=', $id)
                ->orderBy('categories.id');
        $query = $query->first();
        $this->data['data'] = $query;

    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function lihat(){
        $this->data['type'] = "lihat";
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }


    function table(){
        $query = Categori::orderBy('categories.id','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';      
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a class="btn btn-warning ml-1" href="/categori/update/'.$row->id.'"><i class="icon-edit"></i></a> &nbsp';
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
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug', // Pastikan slug unik
                'gambar_kategori' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            ]);
    
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
    
            // Mengecek apakah kategori sudah ada berdasarkan nama
            $cek = Categori::where('name', $request->name)->first();
    
            // Jika kategori belum ada, simpan data baru
            if ($cek == null) {
                // Simpan gambar ke dalam folder storage/app/public/gambar_kategoris
                $gambar_kategoriName = time() . '.' . $request->gambar_kategori->extension();
                $request->gambar_kategori->storeAs('public/image/kategori', $gambar_kategoriName);
    
                // Buat objek kategori baru
                $categori = new Categori();
                $categori->name = $request->name;
                $categori->slug = $request->slug;
                $categori->thumbnails = $gambar_kategoriName; // Simpan nama gambar ke dalam kolom thumbnails
                $categori->save();
    
                DB::commit();
                return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Ditambah!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
            } else {
                DB::rollback();
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'Kategori sudah ada!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
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
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug,' . $request->id . ',id',
                'thumbnails' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }

            // Mengecek apakah nama sudah digunakan selain oleh id yang sedang diperbarui
            $cek = Categori::where('name', $request->name)
                ->where('id', '!=', $request->id)
                ->first();

            // Jika nama belum digunakan selain oleh id yang sedang diperbarui, update data
            if ($cek == null) {
                // Update data category
                $category = Categori::findOrFail($request->id);
                $category->name = $request->name;
                $category->slug = $request->slug;

                // Update gambar jika ada
                if ($request->hasFile('gambar_kategori')) {
                    // Hapus gambar lama jika ada
                    if ($category->thumbnails) {
                        Storage::delete('public/image/kategori/' . $category->thumbnails);
                    }

                    // Simpan gambar baru
                    $gambar_kategoriName = time() . '.' . $request->gambar_kategori->extension();
                    $request->gambar_kategori->storeAs('public/image/kategori', $gambar_kategoriName);
                    $category->thumbnails = $gambar_kategoriName;
                }

                // Simpan perubahan
                $category->save();

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
            // Mengambil data kategori yang akan dihapus
            $category = Categori::where('id', $request->id)->first();
            // Menghapus gambar jika ada
            // dd('public/image/kategori' . $category->thumbnails);
            if( $category->thumbnails){
                Storage::delete('public/image/kategori/' . $category->thumbnails);
            }
    
            // Menghapus kategori dari database
            Categori::where('id', $request->id)->delete();
    
            DB::commit();
            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Dihapus!', 'ButtonColor' => '#66BB6A', 'type' => 'success']); 
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']); 
        }   
    }

}
