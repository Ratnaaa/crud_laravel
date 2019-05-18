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
        $buku = buku::find($id);
        return view('index',compact('bukus'));
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
         $bukus = new \App\Buku;
         $bukus->judul = $request->get('judul');
         $bukus->penerbit = $request->get('penerbit');
         $bukus->tahun_terbit = $request->get('tahun_terbit');
         $bukus->pengarang = $request->get('pengarang');
         $bukus->save();
        
        return redirect('bukus')->with('success', 'Data buku berhasil diupdate');

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bukus = new \App\Buku;
        $bukus->delete();

        return redirect('bukus')->with('success', 'Data buku telah dihapus')
    }
}
