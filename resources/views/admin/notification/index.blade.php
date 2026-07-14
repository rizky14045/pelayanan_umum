@extends('admin::layout.master')

@section('content')
<style>
	.notif-list{display:flex;flex-direction:column;gap:8px;}
	.notif-item{display:flex;align-items:center;gap:14px;padding:14px 18px;border:1px solid #EEF0F5;border-radius:10px;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,0.04);transition:background .15s;}
	.notif-item:hover{background:#F7FAFC;text-decoration:none;}
	.notif-item.is-unread{border-left:4px solid #1F5C85;background:#F3F8FB;}
	.notif-icon{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;}
	.notif-icon i{font-size:20px;}
	.notif-icon-ruangan{background:#F675A8;}
	.notif-icon-konsumsi{background:#2C7BE5;}
	.notif-icon-kendaraan{background:#15803D;}
	.notif-body{flex:1;min-width:0;}
	.notif-title{font-size:14px;font-weight:700;color:#2A2E43;word-break:break-word;}
	.notif-subtitle{font-size:12px;color:#8A8FA3;margin-top:2px;}
	.notif-time{font-size:12px;color:#A6AAB8;white-space:nowrap;flex-shrink:0;}
	.notif-dot{width:8px;height:8px;border-radius:50%;background:#1F5C85;flex-shrink:0;}
	.notif-empty{padding:40px;text-align:center;color:#A6AAB8;font-size:14px;}
	.kpi-btn-back{display:inline-flex;align-items:center;gap:8px;background:#F5F6FA;color:#1F5C85;border:none;border-radius:20px;padding:9px 20px;font-size:14px;font-weight:600;transition:background .15s,transform .15s;}
	.kpi-btn-back:hover{background:#E1EDF4;transform:translateX(-2px);color:#1F5C85;text-decoration:none;}
</style>

<div class="block-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
    <h2>Semua Notifikasi</h2>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        @if($notifications->where('status', false)->count() > 0)
            <a class="kpi-btn-back" href="{{ route('admin::notifications.mark-all-read') }}"><i class="fa fa-check"></i> Tandai Semua Dibaca</a>
        @endif
        <a class="kpi-btn-back" href="{{ route('admin::dashboard') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
</div>
@include('admin::partials.alert-messages')

<div class="notif-list">
	@forelse($notifications as $item)
		@if ($item->pemesanan_ruangan_id && $item->ruangan)
			<a href="{{ route('admin::pemesanan-ruangan.detail', ['id' => $item->pemesanan_ruangan_id]) }}" class="notif-item {{ !$item->status ? 'is-unread' : '' }}">
				<div class="notif-icon notif-icon-ruangan"><i class="material-icons">meeting_room</i></div>
				<div class="notif-body">
					<div class="notif-title">{{ $item->ruangan->no_pemesanan_ruangan }}</div>
					<div class="notif-subtitle">Pemesanan Ruangan</div>
				</div>
				<div class="notif-time">{{ $item->created_at->diffForHumans() }}</div>
				@if(!$item->status)<div class="notif-dot"></div>@endif
			</a>
		@elseif ($item->permohonan_konsumsi_id && $item->konsumsi)
			<a href="{{ route('admin::permohonan-konsumsi.detail', ['id' => $item->permohonan_konsumsi_id]) }}" class="notif-item {{ !$item->status ? 'is-unread' : '' }}">
				<div class="notif-icon notif-icon-konsumsi"><i class="material-icons">fastfood</i></div>
				<div class="notif-body">
					<div class="notif-title">{{ $item->konsumsi->pemohon }} &ndash; {{ $item->konsumsi->kegiatan }}</div>
					<div class="notif-subtitle">Permohonan Konsumsi</div>
				</div>
				<div class="notif-time">{{ $item->created_at->diffForHumans() }}</div>
				@if(!$item->status)<div class="notif-dot"></div>@endif
			</a>
		@elseif ($item->permohonan_pemakaian_kendaraan_id && $item->kendaraan)
			<a href="{{ route('admin::permohonan-pemakaian-kendaraan.detail', ['id' => $item->permohonan_pemakaian_kendaraan_id]) }}" class="notif-item {{ !$item->status ? 'is-unread' : '' }}">
				<div class="notif-icon notif-icon-kendaraan"><i class="material-icons">directions_car</i></div>
				<div class="notif-body">
					<div class="notif-title">{{ $item->kendaraan->pemohon }} &ndash; {{ $item->kendaraan->tujuan }}</div>
					<div class="notif-subtitle">Permohonan Pemakaian Kendaraan</div>
				</div>
				<div class="notif-time">{{ $item->created_at->diffForHumans() }}</div>
				@if(!$item->status)<div class="notif-dot"></div>@endif
			</a>
		@endif
	@empty
		<div class="notif-empty">Belum ada notifikasi</div>
	@endforelse
</div>
@stop
