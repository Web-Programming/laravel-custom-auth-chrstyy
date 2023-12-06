<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use APP\Models\Prodi;

class ProdiController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mengambil data dri tabel prodis dn simpan divariabel $prodis
        $prodis = Prodi::all();
        $success['data'] = $prodis;
        return $this->sendResponse($success, 'Data prodi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //membuat validasi semua field wajib diiisi
        $validasi = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;
         $path = $request->foto->storeAs('public', $nama_file);

        $prodi = new Prodi(); //buat objek prodi
        $prodi->nama = $validasi['nama']; //simpna nilai input ke properti nama prodi
        $prodi->foto = $nama_file;

        //jika berhasil maka simpan data dgn metode $post->save()
        if($prodi->save()){
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data prodi berhasil disimpan');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs('public', $nama_file);

        $prodi = Prodi::find($id);
        $prodi->nama = $validasi['nama'];
        $prodi->foto = $nama_file;

        //jika berhasil maka simpan data dgn metode $post->save()
        if($prodi->save()){
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data prodi berhasil disimpan');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal diperbarui']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id)
    {
        $prodi = Prodi::findOrFail($id);
        if($prodi->delete()){
            $success['data'] = [];
            return $this->sendResponse($success, 'Data prodi dengan id $id berhasil dihapus');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal dihapus']);
        }
    }
}

