@extends('front.baru.master')
@section('content')
<style>
	.profile-stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;}
	.profile-stat-card{background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);padding:22px 18px;text-align:center;}
	.profile-stat-icon{display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;border-radius:50%;background:#E1EDF4;color:#1F5C85;font-size:22px;margin-bottom:12px;}
	.profile-stat-card h5{font-size:28px;font-weight:700;margin:0 0 4px;color:#2A2E43;}
	.profile-stat-card p{margin:0;font-size:13px;color:#6B7080;line-height:1.3;}
	.profile-section-title{font-size:16px;font-weight:700;color:#2A2E43;margin-bottom:16px;}
</style>
<div class="container">
    <h1 class="page-title">Profil Akun</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('front.baru.profile.partials.sidebar', ['active' => 'dashboard', 'user' => $user])
        </div>
        <div class="col-md-9">
            <div class="profile-section-title">Total Permohonan</div>
            <div class="profile-stat-grid">
                <div class="profile-stat-card">
                    <span class="profile-stat-icon"><i class="fa fa-home"></i></span>
                    <h5>{{$pemesananRuangan}}</h5>
                    <p>Pemesanan Ruangan</p>
                </div>
                <div class="profile-stat-card">
                    <span class="profile-stat-icon"><i class="fa fa-spoon"></i></span>
                    <h5>{{$permohonanKonsumsi}}</h5>
                    <p>Permohonan Konsumsi</p>
                </div>
                <div class="profile-stat-card">
                    <span class="profile-stat-icon"><i class="fa fa-map-marker"></i></span>
                    <h5>{{$permohonanPemakaianKendaraan}}</h5>
                    <p>Permohonan Kendaraan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
