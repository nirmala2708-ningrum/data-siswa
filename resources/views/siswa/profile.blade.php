@extends('layouts.master')

@section('header')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@stop
@section('content')
<div id="wrapper">
    <div class="main">
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

        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-profile">
                    <div class="clearfix">
                        @if(isset($siswa))
                        <div class="profile-left">
                            <div class="profile-header">
                                <div class="overlay"></div>
                                <div class="profile-main">
                                    <img src="{{$siswa->getavatar()}}" class="img-circle" alt="Avatar">
                                    <h3 class="name">{{$siswa->nama_depan}}</h3>
                                    <span class="online-status status-available">Available</span>
                                </div>
                                <div class="profile-stat">
                                    <div class="row">
                                        <div class="col-md-4 stat-item">
                                            {{$siswa->mapel->count()}} <span>Mata Pelajaran</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            15 <span>Awards</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            2174 <span>Points</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-detail">
                                <div class="profile-info">
                                    <h4 class="heading">Data Diri</h4>
                                    <ul class="list-unstyled list-justify">
                                        <li>Jenis Kelamin <span>{{$siswa->jenis_kelamin}}</span></li>
                                        <li>Agama <span>{{$siswa->agama}}</span></li>
                                        <li>Alamat <span>{{$siswa->alamat}}</span></li>
                                    </ul>
                                </div>
                                <div class="text-center">
                                    <a href="/siswa/{{$siswa->id}}/edit" class="btn btn-warning">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="profile-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Tambah Nilai
                            </button>

                            <!-- Modal Tambah Nilai -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Nilai</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('siswa.addnilai', $siswa->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="mapel_id">Pilih Mata Pelajaran</label>
                                                    <select name="mapel_id" id="mapel_id" class="form-control">
                                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                                        @foreach($allMapel as $mapel)
                                                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nilai">Nilai</label>
                                                    <input type="number" name="nilai" class="form-control" min="0" max="100" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Mata Pelajaran</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>KODE</th>
                                                <th>NAMA</th>
                                                <th>SEMESTER</th>
                                                <th>NILAI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($siswa->mapel as $mapel)
                                            <tr>
                                                <td>{{$mapel->kode}}</td>
                                                <td>{{$mapel->nama}}</td>
                                                <td>{{$mapel->semester}}</td>
                                                <td><a href="#" id="username" data-type="text" data-pk="{{$mapel->id}}" data-url="/post" data-title="Masukkan Nilai">{{$mapel->pivot->nilai ?? 'Belum ada nilai'}}</a></td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel">
                                <div id="chartNilai"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var categories = {!! json_encode($categories ?? []) !!};
        var nilai = {!! json_encode($nilai ?? []) !!};

        if (categories.length === 0 || nilai.length === 0) {
            console.error("Data chart kosong. Pastikan data dikirim dari controller.");
        }

        Highcharts.chart('chartNilai', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Laporan Nilai Siswa'
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'Mata Pelajaran'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
                }
            },
            series: [{
                name: 'Nilai',
                data: nilai
            }]
        });
    });
</script>
@endsection
