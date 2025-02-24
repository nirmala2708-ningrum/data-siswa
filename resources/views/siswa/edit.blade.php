@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Data Siswa</h3>
                        </div>
                        <div class="panel-body">
                            @if(session('sukses'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('sukses') }}
                                </div>
                            @endif
                            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- CSRF token -->
                                @method('PUT') <!-- Metode PUT -->

                                <div class="mb-3">
                                    <label for="nama-depan" class="form-label">Nama Depan</label>
                                    <input type="text" class="form-control" id="nama_depan" name="nama_depan" placeholder="Nama Depan" value="{{ $siswa->nama_depan }}">
                                </div>
                                <div class="mb-3">
                                    <label for="inputJenisKelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="inputJenisKelamin" name="jenis_kelamin" aria-label="Pilih Jenis Kelamin">
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="L" @if($siswa->jenis_kelamin == 'L') selected @endif>Laki Laki</option>
                                        <option value="P" @if($siswa->jenis_kelamin == 'P') selected @endif>Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="inputAgama" class="form-label">Agama</label>
                                    <input type="text" class="form-control" id="inputAgama" name="agama" placeholder="Agama" value="{{ $siswa->agama }}">
                                </div>
                                <div class="mb-3">
                                    <label for="inputAlamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="inputAlamat" name="alamat" placeholder="Alamat" style="height: 100px">{{ $siswa->alamat }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="inputAlamat" class="form-label">Avatar</label>
                                    <input type="file" name="avatar" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
