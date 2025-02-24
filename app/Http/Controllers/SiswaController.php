<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('cari')) {
            $data_siswa = Siswa::where('nama_depan', 'LIKE', '%' . $request->cari . '%')->get();
        } else {
            $data_siswa = Siswa::all();
        }
        return view('siswa.index', compact('data_siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $user = User::create([
            'role' => 'siswa',
            'name' => $request->nama_depan,
            'email' => $request->email,
            'password' => bcrypt('rahasia'),
            'remember_token' => Str::random(60),
        ]);

        $request->merge(['user_id' => $user->id]);
        Siswa::create($request->all());

        return redirect('/siswa')->with('sukses', 'Data berhasil diinput');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $siswa->update($request->all());

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $siswa->avatar = $filename;
            $siswa->save();
        }

        return redirect('/siswa')->with('sukses', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect('/siswa')->with('sukses', 'Data berhasil dihapus');
    }

    public function profile($id)
    {
        $siswa = Siswa::with('mapel')->findOrFail($id);
        $allMapel = Mapel::all(); // Ambil semua mata pelajaran

        // Menyiapkan data untuk chart
        $categories = [];
        $nilai = [];

        foreach ($allMapel as $mapel) {
            $nilaiSiswa = $siswa->mapel->where('id', $mapel->id)->first();
            $categories[] = $mapel->nama;
            $nilai[] = $nilaiSiswa ? $nilaiSiswa->pivot->nilai : 0;
        }

        return view('siswa.profile', compact('siswa', 'allMapel', 'categories', 'nilai'));
    }

    public function addnilai(Request $request, $idSiswa)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $siswa = Siswa::findOrFail($idSiswa);
        $mapel_id = $request->mapel_id;
        $nilai = $request->nilai;

        // Cek apakah nilai sudah ada untuk mata pelajaran ini
        if ($siswa->mapel()->where('mapel_id', $mapel_id)->exists()) {
            return redirect()->route('siswa.profile', $idSiswa)->with('error', 'Nilai sudah ada untuk mata pelajaran ini.');
        }

        // Menambahkan nilai ke tabel pivot
        $siswa->mapel()->attach($mapel_id, ['nilai' => $nilai]);

        return redirect()->route('siswa.profile', $idSiswa)->with('sukses', 'Data Nilai Berhasil Dimasukkan');
    }

    public function edit_nilai($id)
{
    $siswa = Siswa::findOrFail($id);
    $mapel = Mapel::all();
    return view('siswa.edit_nilai', compact('siswa', 'mapel'));
}

public function update_nilai(Request $request, $id)
{
    $request->validate([
        'mapel_id' => 'required|exists:mapel,id',
        'nilai' => 'required|numeric|min:0|max:100',
    ]);

    $siswa = Siswa::findOrFail($id);
    $mapel_id = $request->mapel_id;
    $nilai = $request->nilai;

    if ($siswa->mapel()->where('mapel_id', $mapel_id)->exists()) {
        $siswa->mapel()->updateExistingPivot($mapel_id, ['nilai' => $nilai]);
    } else {
        return redirect()->back()->with('error', 'Mata pelajaran tidak ditemukan.');
    }

    return redirect()->route('siswa.index', $id)->with('sukses', 'Nilai berhasil diperbarui');
}

}
