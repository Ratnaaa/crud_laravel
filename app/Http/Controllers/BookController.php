<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bukus=\App\Buku::all();
        return view('index',compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bukus = new \App\Buku;
        $bukus->judul = $request->get('judul');
        $bukus->penerbit = $request->get('penerbit');
        $bukus->tahun_terbit = $request->get('tahun_terbit');
        $bukus->pengarang = $request->get('pengarang');
        $bukus->save();
        
        return redirect('bukus')->with('success', 'Data buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // mengambil semua users untuk di jadikan dropdwon list pemilik di form create
 
        $users = \App\User::all();
 
        // melempar ke view di file create.blade.php yang berada di folder crud/kendaraan, sekaligus mengirim data user yang disimpan di variable $users dan data yg akan di edit yaitu $showById
        $showById = \App\buku::find($id);
 
        return view('index',compact('bukus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // memvalidasi inputan users, form tidak boleh kosong (required)
        // nama_kendaraan,jenis_kendaraan,made_in,pemilik adalah name yang ada di form, contoh name="nama_kendaran" (lihat form)
        // \Validator adalah class yg ada pada Laravel untuk validasi
        // $request->all() adalah semua inputan dari form kita validasi
        $validate = \Validator::make($request->all(), [
                'judul' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required', 
                'pengarang' => 'required'
            ],
            // $after_update adalah isi session ketika form kosong dan di kembalikan lagi ke form dengan membawa session di bawah ini (lihat form bagian part alert), dengan keterangan error dan alert warna merah di ambil dari 'alert' => 'danger', dst.
 
            $after_update = [
                'alert' => 'danger',
                'title' => 'Oh wait!',
                'text-1' => 'Ada kesalahan',
                'text-2' => 'Silakan coba lagi.'
            ]);
         // jika form kosong maka artinya fails() atau gagal di proses, maka di return redirect()->back()->with('after_update', $after_update) artinya page di kembalikan ke form dengan membawa session after_update yang sudah kita deklarasi di atas.
 
        if($validate->fails()){
            return redirect()->back()->with('after_update', $after_update);
        }
        // $after_update adalah isi session ketika data berhasil disimpan dan di kembalikan lagi ke form dengan membawa session di bawah ini (lihat form bagian part alert), dengan keterangan success dan alert warna merah di ganti menjadi warna hijau di ambil dari 'alert' => 'success', dst.
 
        $after_update = [
            'alert' => 'success',
            'title' => 'God Job!',
            'text-1' => 'Update berhasil',
            'text-2' => '.'
        ];
         // jika form tidak kosong artinya validasi berhasil di lalui maka proses di bawah ini di jalankan, yaitu mengambil semua kiriman dari form
        // nama_kendaraan,jenis_kendaraan,buatan,user_id adalah nama kolom yang ada di table kendaraan
        // sedangkan $request->nama_kendaraan adalah isi dari kiriman form
 
        $data = [
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'pengarang' => $request->pengarang
        ];
         // di bawah ini proses update tabel kendaraan, jika kolom id sama dengan $id yang dikirim dari form
 
        $update = \App\Buku::where('id', $id)->update($data);
 
        // jika berhasil kembalikan ke page data kendaraan dengan membawa session after_update success.
        
        return redirect()->to('buku')->with('after_update', $after_update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
