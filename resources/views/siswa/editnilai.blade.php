@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Nilai Siswa</h3>
                        </div>
                        <div class="panel-body">
                            @if(session('sukses'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('sukses') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('update_nilai', $siswa->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                                    <select class="form-select" id="mapel_id" name="mapel_id" required>
                                        <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                        @foreach($mapel as $m)
                                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nilai" class="form-label">Nilai</label>
                                    <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" placeholder="Masukkan nilai" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Nilai</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
