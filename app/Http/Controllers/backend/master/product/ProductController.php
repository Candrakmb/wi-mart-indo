<?php

namespace App\Http\Controllers\Backend\master\product;


use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Models\master\Categori;
use App\Models\master\Product;
use App\Models\master\VariasiProduk;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public $data = [
        'title' => 'Product',
        'modul' => 'product',
        'sektor' => 'backend',
        'parent' => 'master',
        
    ];
    
    function product(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
        $this->data['data_categori'] =Product::get();
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
        $this->data['data_categori'] =Categori::get();
        $query = Product::with(['categori'])
                ->where('id', '=', $id)
                ->orderBy('products.id');
        $query = $query->first();
        $this->data['data'] = $query;
        $variasi = VariasiProduk::where('product_id', '=', $id)
                ->orderBy('variasi_produks.id');
        $variasi = $variasi->get();
        $count = $variasi->count();
        $this->data['count'] = $count;
        $this->data['data_variasi'] = $variasi;
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function lihat(){
        $this->data['type'] = "lihat";
    	return view($this->data['sektor'].'.'.$this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }


    function table(){
        $query = Product::with(['categori'])
                ->orderBy('products.id','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-3">';
                $btn .= '<a class="btn btn-warning ml-1" href="/product/update/'.$row->id.'"><i class="icon-edit"></i></a> &nbsp';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('satuan_berat', function($row){
                $berat_kg = $row->weight/1000; // Konversi dari gram ke kilogram
                $berat = '';
                $berat .= '<div class="text-center">';
                $berat .= '<p>'.$berat_kg.' kg</p>'; // Menampilkan hasil konversi berat dalam kilogram
                $berat .= '</div>';
                return $berat;
            })
            ->addColumn('harga', function($row){
                $price = $row->price;
                $formatted_price = number_format($price, 0, ',', '.'); // Format angka menjadi format mata uang rupiah
                $harga = '';
                $harga .= '<div class="text-center">';
                $harga .= '<p>Rp '.$formatted_price.'</p>'; // Menampilkan harga dalam format rupiah
                $harga .= '</div>';
                return $harga;
            })
            ->rawColumns(['satuan_berat','action','harga'])
            ->make(true);
    }
    
    public function createform(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'categories_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug',
                'weight'=> 'required|integer',
                'stok'=> 'required|integer',
                'description' => 'required',
                'gambar_product' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);
    
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
    
            // Mengecek apakah kategori sudah ada berdasarkan nama
            $cek = Product::where('name', $request->name)->first();
    
            // Jika kategori belum ada, simpan data baru
            if ($cek == null) {
                // Simpan gambar ke dalam folder storage/app/public/
                $gambar_productName = time() . '.' . $request->gambar_product->extension();
                $request->gambar_product->storeAs('public/image/product', $gambar_productName);
                $priceWithoutDot = str_replace('.', '', $request->price);
                $priceWithoutRp = str_replace('Rp ', '', $priceWithoutDot);
                // dd( $priceWithoutRp);
                // Buat objek kategori baru
                $product = new Product;
                $product->categories_id = $request->categories_id;
                $product->name = $request->name;
                $product->slug = $request->slug;
                $product->price = $priceWithoutRp;
                $product->berat_display = $request->berat_display;
                $product->label = $request->label;
                $product->weight = $request->weight;
                $product->stok = $request->stok;
                $product->description = $request->description;
                $product->thumbnails = $gambar_productName; // Simpan nama gambar ke dalam kolom thumbnails
                $product->save();

                $data = $request->only(
                    [
                        'jenis',
                        'spesifikasi', 
                        'stok_variasi', 
                        'status',
                    ]
                );

                if (isset($data['spesifikasi'])) {
                    foreach ($data['spesifikasi'] as $key => $value) {
                        $variasi = new VariasiProduk();
                        $variasi->product_id=$product->id;
                        $variasi->jenis=$data['jenis'][$key];
                        $variasi->spesifikasi = $data['spesifikasi'][$key];
                        $variasi->stok = $data['stok_variasi'][$key];
                        $variasi->status= $data['status'][$key];
                        $variasi->save();
                    } 
                }

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
                'categories_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug,' . $request->id . ',id',
                'weight' => 'required|numeric',
                'stok' => 'required|integer',
                'description' => 'required|string',
                'gambar_product' => 'nullabel|image|mimes:jpeg,png,jpg,gif|max:2048',

            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $validator->errors()->first(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }

            // Mengecek apakah nama sudah digunakan selain oleh id yang sedang diperbarui
            $cek = Product::where('name', $request->name)
                ->where('id', '!=', $request->id)
                ->first();

            // Jika nama belum digunakan selain oleh id yang sedang diperbarui, update data
            if ($cek == null) {
                // Update data category
                $priceWithoutDot = str_replace('.', '', $request->price);
                $priceWithoutRp = str_replace('Rp ', '', $priceWithoutDot);

                $product = Product::findOrFail($request->id);
                $product->categories_id = $request->categories_id;
                $product->name = $request->name;
                $product->slug = $request->slug;
                $product->price = $priceWithoutRp;
                $product->berat_display = $request->berat_display;
                $product->label = $request->label;
                $product->weight = $request->weight;
                $product->stok = $request->stok;
                $product->description = $request->description;

                // Update gambar jika ada
                if ($request->hasFile('gambar_product')) {
                    // Hapus gambar lama jika ada
                    if ($product->thumbnails) {
                        Storage::delete('public/image/product/' . $product->thumbnails);
                    }

                    // Simpan gambar baru
                    $gambar_productName = time() . '.' . $request->gambar_product->extension();
                    $request->gambar_product->storeAs('public/image/product', $gambar_productName);
                    $product->thumbnails = $gambar_productName;
                }

                // Simpan perubahan
                $product->save();

                $data = $request->only(
                    [
                        'id_variasi',
                        'jenis',
                        'spesifikasi', 
                        'stok_variasi', 
                        'status',
                    ]
                );

                if (isset($data['spesifikasi'])) {
                    $existingvariasis = VariasiProduk::where('product_id', $request->id)->get();
                
                    // Ambil id_variasi dari data variasi yang sudah ada
                    $existingvariasiIds = $existingvariasis->pluck('id')->toArray();
                
                    if ($existingvariasis->isNotEmpty()) {
                        VariasiProduk::where('product_id', $request->id)->delete();
                    }
                
                    foreach ($data['spesifikasi'] as $key => $value) {
                        $variasi = new VariasiProduk();
                
                        // Jika id_variasi ada dalam data variasi yang sudah ada, gunakan id_variasi tersebut
                        if (isset($data['id_variasi'][$key]) && in_array($data['id_variasi'][$key], $existingvariasiIds)) {
                            $variasi->id = $data['id_variasi'][$key];
                        }
                
                        $variasi->product_id = $request->id;
                        $variasi->jenis=$data['jenis'][$key];
                        $variasi->spesifikasi = $data['spesifikasi'][$key];
                        $variasi->stok = $data['stok_variasi'][$key];
                        $variasi->status= $data['status'][$key];
                        $variasi->save();
                    }
                }

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
            $product = Product::findOrFail($request->id);
    
            // Menghapus gambar jika ada
            if ($product->thumbnails) {
                Storage::delete('public/image/product/' . $product->thumbnails);
            }
    
            // Menghapus kategori dari database
            Product::where('id', $request->id)->delete();
    
            DB::commit();
            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil Dihapus!', 'ButtonColor' => '#66BB6A', 'type' => 'success']); 
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']); 
        }   
    }

}
