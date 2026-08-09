@extends('front.baru.master')
@section('content')
@php
$user = App\Models\Karyawan::where('id', auth()->guard('front')->id())->first();
@endphp
<style>
	.setting-card{background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);padding:24px;margin-bottom:24px;}
	.setting-card h4{font-size:16px;font-weight:700;color:#2A2E43;margin:0 0 20px;}
	.setting-card .btn-warning{border-radius:20px;padding:8px 22px;font-weight:600;}
</style>
<div class="container">
    <h1 class="page-title">Pengaturan Akun</h1>
</div>
<div class="container" style="margin-bottom: 30px;">
    <div class="row">
        <div class="col-md-3">
            @include('front.baru.profile.partials.sidebar', ['active' => 'setting', 'user' => $user])
        </div>
        <div class="col-md-9">
            @if(session('msg'))
            <div class="alert alert-warning" role="alert">
                <b>{{session('msg')}}</b>
            </div>
            @endif
            <div class="setting-card">
                <h4>Informasi Personal</h4>
                <form method="POST" action="{{route('profile.updateInfo')}}">
                    <div class="row">
                        <div class="col-md-6">
                            {{ csrf_field() }}
                            <div class="form-group form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                <label>Nomor Induk</label>
                                <input class="form-control" value="{{$user->no_induk}}" name="no_induk" type="text"
                                    readonly />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                <label>Nama Lengkap</label>
                                <input class="form-control" value="{{$user->nama}}" name="nama" type="text" readonly
                                    required />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-cubes input-icon"></i>
                                <label>Jabatan</label>
                                <input class="form-control" value="{{$user->jabatan}}" name="jabatan" type="text"
                                    required />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-cubes input-icon"></i>
                                <label>Sub-Bidang</label>
                                <input class="form-control" value="{{$user->sub_bidang}}" name="sub_bidang" type="text"
                                    required />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-bank input-icon"></i>
                                <label>Pendidikan</label>
                                <input class="form-control" value="{{$user->pendidikan}}" name="pendidikan" type="text"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                <label>NID</label>
                                <input class="form-control" value="{{$user->nid}}" name="nid" type="text" required
                                    readonly />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                <label>Nama Asli</label>
                                <input class="form-control" value="{{$user->nama_tanpa_gelar}}" name="nama_tanpa_gelar"
                                    type="text" required readonly />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-cubes input-icon"></i>
                                <label>Bidang</label>
                                <input class="form-control" value="{{$user->bidang}}" name="bidang" type="text" required />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-cubes input-icon"></i>
                                <label>Grade</label>
                                <input class="form-control" value="{{$user->grade}}" name="grade" type="text" required />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-bank input-icon"></i>
                                <label>Universitas</label>
                                <input class="form-control" value="{{$user->universitas}}" name="universitas" type="text"
                                    required />
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-warning" value="Ubah Data">
                </form>
            </div>
            <div class="setting-card">
                <h4>Ubah Password</h4>
                <form method="POST" action="{{route('profile.updatePass')}}">
                    {{ csrf_field() }}
                    <input class="form-control" value="{{$user->no_induk}}" name="no_induk" type="hidden" readonly />
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-6">
                            <div class="form-group form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                <label>Password Baru</label>
                                <input class="form-control" name="password_baru" type="password" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-icon-left"><i class="fa fa-key input-icon"></i>
                                <label>Ulangi Password Baru</label>
                                <input class="form-control" name="ulang_password_baru" type="password" required />
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-warning" value="Ubah Password">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
