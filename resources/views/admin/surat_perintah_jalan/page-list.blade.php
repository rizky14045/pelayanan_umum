@extends('admin::layout.master')

@section('content')
<style>
	.kpi-toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
	.kpi-toolbar-search{flex:1;max-width:420px;margin-left:auto;}
	.kpi-toolbar-search .form-control{border-radius:20px;padding-left:16px;}

	#kpi-list{display:flex;flex-direction:column;gap:10px;}

	.kpi-card{display:flex;background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);overflow:hidden;}
	.kpi-card-accent{width:5px;flex-shrink:0;}
	.kpi-card-body{flex:1;padding:12px 20px;}
	.kpi-card-row{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:nowrap;}
	.kpi-card-title-wrap{flex:1;min-width:0;}
	.kpi-card-title-line{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
	.kpi-card-title{font-size:16px;font-weight:700;color:#2A2E43;word-break:break-word;overflow-wrap:anywhere;}
	.kpi-card-title-sub{font-weight:400;color:#8A8FA3;}
	.kpi-card-meta{display:flex;gap:16px;margin-top:6px;flex-wrap:wrap;}
	.kpi-card-meta span{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#6B7080;}
	.kpi-card-meta i{color:#A6AAB8;}
	.kpi-badge{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;white-space:nowrap;}
	.kpi-badge-success{background:#E5F7EF;color:#1BAA6B;}
	.kpi-badge-danger{background:#FDE7EC;color:#E03A5D;}
	.kpi-badge-warning{background:#FFF3D6;color:#C98A0A;}
	.kpi-badge-info{background:#E3EEFD;color:#2C7BE5;}
	.kpi-badge-muted{background:#F0F1F5;color:#8A8FA3;}
	.kpi-card-actions{display:flex;align-items:center;gap:14px;flex-wrap:nowrap;flex-shrink:0;}
	.kpi-action-buttons{display:flex;align-items:center;gap:6px;flex-wrap:wrap;justify-content:flex-end;}
	.kpi-toggle{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;color:#8A8FA3;font-size:14px;border-radius:50%;cursor:pointer;background:#F5F6FA;transition:background .15s,color .15s,transform .15s;}
	.kpi-toggle:hover{background:#E1EDF4;color:#1F5C85;}
	.kpi-toggle.is-open{color:#1F5C85;background:#E1EDF4;transform:rotate(180deg);}
	.kpi-card-detail{display:none;margin-top:14px;padding-top:14px;border-top:1px solid #F0F1F5;}
	.kpi-detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 24px;}
	.kpi-detail-item .kpi-detail-label{display:block;font-size:11px;text-transform:uppercase;letter-spacing:.03em;color:#A6AAB8;margin-bottom:2px;}
	.kpi-detail-item .kpi-detail-value{font-size:14px;color:#2A2E43;}

	.kpi-card-actions .btn{display:inline-flex;align-items:center;gap:6px;border-radius:20px;padding:6px 14px;font-size:12px;font-weight:600;color:#fff;border:none;box-shadow:none;line-height:1;transition:filter .15s,transform .15s;}
	.kpi-card-actions .btn:hover{filter:brightness(0.92);transform:translateY(-1px);text-decoration:none;color:#fff;}
	.kpi-card-actions .btn i{color:#fff;}
	.kpi-card-actions .btn-success{background:#15803D;}
	.kpi-card-actions .btn-danger{background:#DC2626;}
	.kpi-card-actions .btn-warning{background:#C2790A;}
	.kpi-card-actions .btn-primary{background:#2563EB;}

	.kpi-pagination{display:flex;justify-content:center;align-items:center;gap:16px;margin-top:20px;}

	.kpi-btn-create{display:inline-flex;align-items:center;gap:8px;background:#1F5C85;color:#fff;border:none;border-radius:20px;padding:9px 20px;font-size:14px;font-weight:600;box-shadow:0 2px 6px rgba(31,92,133,.35);transition:filter .15s,transform .15s;}
	.kpi-btn-create:hover{filter:brightness(0.94);transform:translateY(-1px);color:#fff;text-decoration:none;}
</style>

<div class="block-header">
    <h2>List Surat Perintah Jalan</h2>
</div>
@include('admin::partials.alert-messages')

<div class="kpi-toolbar">
	<a class="kpi-btn-create" href="{{ route('admin::surat-perintah-jalan.form-create') }}"><i class="fa fa-plus"></i> Tambah Surat Perintah Jalan</a>
	<div class="kpi-toolbar-search">
		<input id="search-spj" class="form-control" placeholder="Cari tujuan, driver, atau kendaraan ..."/>
	</div>
</div>

<div id="kpi-list">
	@foreach($pagination as $suratPerintahJalan)
		@php
			if ($suratPerintahJalan->status_perjalanan == 'Sudah Sampai') {
				$accentColor = '#2FBF88';
				$perjalananBadge = ['icon' => 'fa-flag-checkered', 'class' => 'kpi-badge-success', 'label' => 'Sudah Sampai'];
			} else {
				$accentColor = '#1F5C85';
				$perjalananBadge = ['icon' => 'fa-hourglass-half', 'class' => 'kpi-badge-muted', 'label' => 'Belum Sampai'];
			}

			$namaDriver = $suratPerintahJalan->driver->nama_driver ?? '-';
			$namaKendaraan = $suratPerintahJalan->kendaraan->nama_kendaraan ?? 'Tanpa Kendaraan';
			$noPol = $suratPerintahJalan->kendaraan->no_pol ?? '-';
		@endphp
		<div class="kpi-card" data-tujuan="{{ $suratPerintahJalan->tujuan }}" data-driver="{{ $namaDriver }}" data-kendaraan="{{ $namaKendaraan }}">
			<div class="kpi-card-accent" style="background: {{ $accentColor }}"></div>
			<div class="kpi-card-body">
				<div class="kpi-card-row">
					<div class="kpi-card-title-wrap">
						<div class="kpi-card-title-line">
							<span class="kpi-card-title">{{ $suratPerintahJalan->tujuan }}</span>
							<span class="kpi-badge {{ $perjalananBadge['class'] }}"><i class="fa {{ $perjalananBadge['icon'] }}"></i> {{ $perjalananBadge['label'] }}</span>
						</div>
						<div class="kpi-card-meta">
							<span><i class="fa fa-id-card"></i> {{ $namaDriver }}</span>
							<span><i class="fa fa-car"></i> {{ $namaKendaraan }} ({{ $noPol }})</span>
							<span><i class="fa fa-calendar"></i> {{ $suratPerintahJalan->tanggal_berangkat }} &ndash; {{ $suratPerintahJalan->tanggal_kembali }}</span>
							<span><i class="fa fa-clock-o"></i> {{ $suratPerintahJalan->jam_berangkat }} &ndash; {{ $suratPerintahJalan->jam_kembali }}</span>
						</div>
					</div>
					<div class="kpi-card-actions">
						<div class="kpi-action-buttons">
							@if (Auth::user()->role == 'superadmin')
								@if ($suratPerintahJalan->status_perjalanan != 'Sudah Sampai')
								<a class="btn btn-sm btn-success" href="{{ route('admin::surat-perintah-jalan.sampai', [$suratPerintahJalan->getKey()]) }}"><i class="fa fa-flag-checkered"></i> Sampai</a>
								<a class="btn btn-sm btn-primary" href="{{ route('admin::surat-perintah-jalan.form-edit', [$suratPerintahJalan->getKey()]) }}"><i class="fa fa-pencil"></i> Edit</a>
								<a class="btn btn-sm btn-danger delete-button" href="#" data-id="{{$suratPerintahJalan->id}}"><i class="fa fa-trash"></i> Delete</a>
								<a class="btn btn-sm btn-success" href="{{ route('admin::surat-perintah-jalan.send-email',['id'=>$suratPerintahJalan->id]) }}"><i class="fa fa-envelope"></i> Send Email</a>
								@endif
								<a class="btn btn-sm btn-warning" href="{{ route('admin::surat-perintah-jalan.page-pdf',['id'=>$suratPerintahJalan->id]) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
							@else
								@if ($suratPerintahJalan->status_perjalanan != 'Sudah Sampai')
								<a class="btn btn-sm btn-success" href="{{ route('admin::surat-perintah-jalan.sampai', [$suratPerintahJalan->getKey()]) }}"><i class="fa fa-flag-checkered"></i> Sampai</a>
								<a class="btn btn-sm btn-primary" href="{{ route('admin::surat-perintah-jalan.form-edit', [$suratPerintahJalan->getKey()]) }}"><i class="fa fa-pencil"></i> Edit</a>
								<a class="btn btn-sm btn-danger delete-button" href="#" data-id="{{$suratPerintahJalan->id}}"><i class="fa fa-trash"></i> Delete</a>
								<a class="btn btn-sm btn-success" href="{{ route('admin::surat-perintah-jalan.send-email',['id'=>$suratPerintahJalan->id]) }}"><i class="fa fa-envelope"></i> Send Email</a>
								@endif
								<a class="btn btn-sm btn-warning" href="{{ route('admin::surat-perintah-jalan.page-pdf',['id'=>$suratPerintahJalan->id]) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
							@endif
						</div>
						<a href="#" class="kpi-toggle"><i class="fa fa-chevron-down"></i></a>
					</div>
				</div>
				<div class="kpi-card-detail">
					<div class="kpi-detail-grid">
						<div class="kpi-detail-item"><span class="kpi-detail-label">Estimasi Pengisian BBM</span><span class="kpi-detail-value">{{ $suratPerintahJalan->pengisian_bbm }} L</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Biaya Tol</span><span class="kpi-detail-value">Rp . {{ number_format($suratPerintahJalan->biaya_toll) }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Estimasi Bbm Ke 1 (Pertalite / Dexlite)</span><span class="kpi-detail-value">Rp . {{ number_format($suratPerintahJalan->total_biaya - $suratPerintahJalan->biaya_toll) }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Estimasi Bbm Ke 2 (Pertamax / Dex)</span><span class="kpi-detail-value">Rp . {{ number_format($suratPerintahJalan->total_biaya_2 - $suratPerintahJalan->biaya_toll) }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Estimasi Total Biaya Ke 1 Perjalanan</span><span class="kpi-detail-value">Rp . {{ number_format($suratPerintahJalan->total_biaya) }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Estimasi Total Biaya Ke 2 Perjalanan</span><span class="kpi-detail-value">Rp . {{ number_format($suratPerintahJalan->total_biaya_2) }}</span></div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>

<div class="kpi-pagination">
	<button id="kpi-prev" type="button" class="btn btn-default btn-sm">Prev</button>
	<span id="kpi-page-info"></span>
	<button id="kpi-next" type="button" class="btn btn-default btn-sm">Next</button>
</div>
@stop
@section('js')
	<script>
		$('#kpi-list').on('click', '.kpi-toggle', function (e) {
			e.preventDefault();
			var $card = $(this).closest('.kpi-card');
			$card.find('.kpi-card-detail').slideToggle(150);
			$(this).toggleClass('is-open');
		});

		var kpiPageSize = 10;
		var kpiCurrentPage = 1;

		function kpiFilteredCards() {
			var keyword = $('#search-spj').val().toLowerCase();
			return $('#kpi-list .kpi-card').filter(function () {
				var $c = $(this);
				var tujuan = ($c.data('tujuan') || '').toString().toLowerCase();
				var driver = ($c.data('driver') || '').toString().toLowerCase();
				var kendaraan = ($c.data('kendaraan') || '').toString().toLowerCase();
				return tujuan.indexOf(keyword) !== -1 || driver.indexOf(keyword) !== -1 || kendaraan.indexOf(keyword) !== -1;
			});
		}

		function kpiRenderPage() {
			var filtered = kpiFilteredCards();
			var totalPages = Math.max(1, Math.ceil(filtered.length / kpiPageSize));
			if (kpiCurrentPage > totalPages) kpiCurrentPage = totalPages;
			$('#kpi-list .kpi-card').hide();
			filtered.slice((kpiCurrentPage - 1) * kpiPageSize, kpiCurrentPage * kpiPageSize).show();
			$('#kpi-page-info').text('Halaman ' + kpiCurrentPage + ' dari ' + totalPages + ' (' + filtered.length + ' data)');
			$('#kpi-prev').prop('disabled', kpiCurrentPage <= 1);
			$('#kpi-next').prop('disabled', kpiCurrentPage >= totalPages);
		}

		$('#search-spj').on('keyup', function () {
			kpiCurrentPage = 1;
			kpiRenderPage();
		});

		$('#kpi-prev').on('click', function () {
			if (kpiCurrentPage > 1) {
				kpiCurrentPage--;
				kpiRenderPage();
			}
		});

		$('#kpi-next').on('click', function () {
			kpiCurrentPage++;
			kpiRenderPage();
		});

		kpiRenderPage();
	</script>
	<script>
		$('.delete-button').on('click', function(e){
		   var form = this;
		   var id = $(this).attr("data-id")
		   e.preventDefault();
		   swal({
			   title: "Apakah ingin menghapus data ? ",
			   icon: "warning",
			   buttons: true,
			   dangerMode: true,
			   })
			   .then((willDelete) => {
			   if (willDelete) {
				   $.get("{{url('admin/surat-perintah-jalan/delete')}}"+'/'+id, function(){
					   swal(
						   'Terhapus!',
						   'Data berhasil terhapus !',
						   'success'
					   ).then(()=>{
						   location.reload()
					   })
				   });
			   }
			   });
	   });
	</script>
@stop
