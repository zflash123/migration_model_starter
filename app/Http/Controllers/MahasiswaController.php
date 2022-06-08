<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_Matakuliah;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;
class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Yang semula mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswas = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('nim', 'asc');
        return view('mahasiswas.index', ['Mahasiswa' => $mahasiswas, 'paginate'=>$paginate]);

        // //Menampilkan data menggunakan pagination
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        // return view('mahasiswas.index', compact('mahasiswas'))
        // ->with('i', (request()->input('page', 1)-1)* 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create', ['kelas'=>$kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Melakukan validasi data
        $request->validate([
            'nim'=>'required',
            'email'=>'required',
            'images' => 'required',
            'nama'=>'required',
            'tgl_lahir'=>'required',
            'jurusan'=>'required',
            'no_hp'=>'required',
            'kelas'=>'required',
        ]);

        $mahasiswa = new Mahasiswa;

        if($request->hasFile('images')){
            $file = $request->file('images');
            $ext = $file->getClientOriginalExtension();
            $image_name = time().'.'.$ext;
            $file->move('student/', $image_name);
            $mahasiswa->images = $image_name;
        }

        // Mahasiswa::create($request->all());
        $mahasiswa->nim =$request->get('nim');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
        $mahasiswa->kelas_id = $request->get('kelas');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->no_hp = $request->get('no_hp');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');

        //Fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        // Jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $nim
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        // Menampilkan detail data dengan menemukan/berdasarkan NIM mahasiswa
        // $Mahasiswa = Mahasiswa::find($nim);
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswas.detail', ['Mahasiswa' => $Mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $nim
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        // Menampilkan detail data dengan menemukan berdasarkan NIM Mahasiswa untuk diedit
        // $Mahasiswa = Mahasiswa::find($nim);
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    public function cetakPDF($id){
        // $convertPDF = Mahasiswa_Matakuliah::where('mahasiswa_id', $id);

        $MhsMatkul = Mahasiswa_Matakuliah::join('matakuliah', 'mahasiswa_matakuliah.matakuliah_id', '=', 'matakuliah.id')->where('mahasiswa_id', $id)->orderBy('matakuliah_id', 'asc')->get();
        $matkul = Matakuliah::all();
        $mhsMatkul = Mahasiswa::with('kelas')->where('id', $id)->first();

        $pdf = PDF::loadview('mahasiswas.cetak', compact('MhsMatkul', 'mhsMatkul', 'matkul'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $nim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        // Melakukan validasi data
        $request->validate([
            'nim'=>'required',
            'email'=>'required',
            'images' => 'required',
            'nama'=>'required',
            'tgl_lahir'=>'required',
            'kelas'=>'required',
            'jurusan'=>'required',
            'no_hp'=>'required'
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();

        if($request->hasFile('images')){
            $path = 'student/'.$mahasiswa->images;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('images');
            $ext = $file->getClientOriginalExtension();
            $image_name = time().'.'.$ext;
            $file->move('student/', $image_name);
            $mahasiswa->images = $image_name;
        }

        $mahasiswa->nim =$request->get('nim');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
        $mahasiswa->kelas_id = $request->get('kelas');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->no_hp = $request->get('no_hp');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id=$request->get('kelas');
        //fungsi eloquent untuk mengupdate data inputan kita
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        // Mahasiswa::find($nim)->update($request->all());

        // Jika Data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

     /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mhsMatkul($id){
        $MhsMatkul = Mahasiswa_Matakuliah::join('matakuliah', 'mahasiswa_matakuliah.matakuliah_id', '=', 'matakuliah.id')->where('mahasiswa_id', $id)->orderBy('matakuliah_id', 'asc')->get();
        $matkul = Matakuliah::all();
        $mhsMatkul = Mahasiswa::with('kelas')->where('id', $id)->first();
        // return view('mahasiswas.nilai', ['mhsMatkul' => $mhsMatkul, 'MhsMatkul' => $MhsMatkul, 'matkul' => $matkul]);
        return view('mahasiswas.nilai', compact('MhsMatkul', 'mhsMatkul', 'matkul'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $nim
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //  Fungsi eloquent untuk menghapus data
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
