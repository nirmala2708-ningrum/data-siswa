@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h1 class="panel-title">Data Siswa</h1>
                            <div class="right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-plus"></i> Tambah Data Siswa
                                </button>
                                <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    
                                        <th>NAMA</th>
                                        <th>JENIS KELAMIN</th>
                                        <th>AGAMA</th>
                                        <th>ALAMAT</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_siswa as $siswa)
                                    <tr>
                                        <td><a href='/siswa/{{$siswa->id}}/profile'>{{ $siswa->nama_depan }}</td>
                                        <td>{{ $siswa->jenis_kelamin }}</td>
                                        <td>{{ $siswa->agama }}</td>
                                        <td>{{ $siswa->alamat }}</td>
                                        <td>
                                            <a href="{{route ('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{route ('siswa.delete', $siswa->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('yakin mau dihapus?')">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Siswa -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('siswa.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nama-depan" class="form-label">Nama Depan</label>
                            <input type="text" class="form-control" id="nama_depan" name="nama_depan" placeholder="Nama Depan">
                        </div>
                        <div class="mb-3">
                            <label for="nama-depan" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="email">
                        </div>
                        <div class="mb-3">
                            <label for="inputJenisKelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="inputJenisKelamin" name="jenis_kelamin" aria-label="Pilih Jenis Kelamin">
                                <option selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputAgama" class="form-label">Agama</label>
                            <input type="text" class="form-control" id="inputAgama" name="agama" placeholder="Agama">
                        </div>
                        <div class="mb-3">
                            <label for="inputAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="inputAlamat" name="alamat" placeholder="Alamat" style="height: 100px"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
