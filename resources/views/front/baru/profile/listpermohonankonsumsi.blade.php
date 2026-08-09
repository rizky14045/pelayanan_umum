@extends('front.baru.master')
@section('content')
<style>
	.kpi-toolbar{display:flex;justify-content:flex-end;align-items:center;margin-bottom:16px;}
	.kpi-toolbar-search{flex:1;max-width:360px;}
	.kpi-toolbar-search .form-control{border-radius:20px;padding-left:16px;}

	#kpi-list{display:flex;flex-direction:column;gap:10px;}

	.kpi-card{display:flex;background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);overflow:hidden;}
	.kpi-card-accent{width:5px;flex-shrink:0;}
	.kpi-card-body{flex:1;padding:12px 20px;}
	.kpi-card-row{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;}
	.kpi-card-title-wrap{flex:1;min-width:0;}
	.kpi-card-title-line{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
	.kpi-card-title{font-size:16px;font-weight:700;color:#2A2E43;word-break:break-word;overflow-wrap:anywhere;}
	.kpi-card-meta{display:flex;gap:16px;margin-top:6px;flex-wrap:wrap;}
	.kpi-card-meta span{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#6B7080;}
	.kpi-card-meta i{color:#A6AAB8;}
	.kpi-badge{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;white-space:nowrap;}
	.kpi-badge-success{background:#E5F7EF;color:#1BAA6B;}
	.kpi-badge-danger{background:#FDE7EC;color:#E03A5D;}
	.kpi-badge-warning{background:#FFF3D6;color:#C98A0A;}
	.kpi-card-actions{display:flex;align-items:center;gap:14px;flex-wrap:nowrap;flex-shrink:0;}
	.kpi-toggle{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;color:#8A8FA3;font-size:14px;border-radius:50%;cursor:pointer;background:#F5F6FA;transition:background .15s,color .15s,transform .15s;}
	.kpi-toggle:hover{background:#E1EDF4;color:#1F5C85;}
	.kpi-toggle.is-open{color:#1F5C85;background:#E1EDF4;transform:rotate(180deg);}
	.kpi-card-detail{display:none;margin-top:14px;padding-top:14px;border-top:1px solid #F0F1F5;}
	.kpi-detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 24px;}
	.kpi-detail-item .kpi-detail-label{display:block;font-size:11px;text-transform:uppercase;letter-spacing:.03em;color:#A6AAB8;margin-bottom:2px;}
	.kpi-detail-item .kpi-detail-value{font-size:14px;color:#2A2E43;}

	.kpi-card-actions .btn{display:inline-flex;align-items:center;gap:6px;border-radius:20px;padding:6px 14px;font-size:12px;font-weight:600;color:#fff;border:none;box-shadow:none;line-height:1;}
	.kpi-card-actions .btn:hover{filter:brightness(0.92);text-decoration:none;color:#fff;}
	.kpi-card-actions .btn-danger{background:#DC2626;}

	.kpi-pagination{display:flex;justify-content:center;align-items:center;gap:16px;margin-top:20px;}
	.kpi-empty{padding:30px;text-align:center;color:#A6AAB8;background:#fff;border:1px solid #EEF0F5;border-radius:10px;}
</style>
<div class="container">
    <h1 class="page-title">List Permohonan Konsumsi</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('front.baru.profile.partials.sidebar', ['active' => 'konsumsi'])
        </div>

        <div class="col-md-9">
			<div class="kpi-toolbar">
				<div class="kpi-toolbar-search">
					<input id="search-konsumsi" class="form-control" placeholder="Cari nama kegiatan ..."/>
				</div>
			</div>

			<div id="kpi-list">
				@forelse($pagination as $permohonanKonsumsi)
					@php
						if ($permohonanKonsumsi->status_pj == 'Approved') {
							$accentColor = '#2FBF88';
							$statusBadge = ['icon' => 'fa-check-circle', 'class' => 'kpi-badge-success', 'label' => 'Disetujui'];
						} elseif ($permohonanKonsumsi->status_pj == 'Rejected') {
							$accentColor = '#FF6584';
							$statusBadge = ['icon' => 'fa-times-circle', 'class' => 'kpi-badge-danger', 'label' => 'Ditolak'];
						} else {
							$accentColor = '#1F5C85';
							$statusBadge = ['icon' => 'fa-clock-o', 'class' => 'kpi-badge-warning', 'label' => 'Pending'];
						}
					@endphp
					<div class="kpi-card" data-kegiatan="{{ $permohonanKonsumsi->kegiatan }}">
						<div class="kpi-card-accent" style="background: {{ $accentColor }}"></div>
						<div class="kpi-card-body">
							<div class="kpi-card-row">
								<div class="kpi-card-title-wrap">
									<div class="kpi-card-title-line">
										<span class="kpi-card-title">{{ $permohonanKonsumsi->kegiatan }}</span>
										<span class="kpi-badge {{ $statusBadge['class'] }}"><i class="fa {{ $statusBadge['icon'] }}"></i> {{ $statusBadge['label'] }}</span>
									</div>
									<div class="kpi-card-meta">
										<span><i class="fa fa-calendar"></i> {{ $permohonanKonsumsi->tanggal }} &ndash; {{ $permohonanKonsumsi->tanggal_selesai }}</span>
										<span><i class="fa fa-clock-o"></i> {{ $permohonanKonsumsi->jam }}</span>
										<span><i class="fa fa-cutlery"></i> {{ $permohonanKonsumsi->jenis_konsumsi }} ({{ $permohonanKonsumsi->jumlah }})</span>
										<span><i class="fa fa-users"></i> {{ $permohonanKonsumsi->jumlah_peserta }} peserta</span>
									</div>
								</div>
								<div class="kpi-card-actions">
									<div class="kpi-action-buttons">
										@if($permohonanKonsumsi->status_pj == 'Pending')
											<a class="btn btn-sm btn-danger delete-button" href="#" data-id="{{$permohonanKonsumsi->id}}"><i class="fa fa-trash"></i> Delete</a>
										@endif
									</div>
									<a href="#" class="kpi-toggle"><i class="fa fa-chevron-down"></i></a>
								</div>
							</div>
							<div class="kpi-card-detail">
								<div class="kpi-detail-grid">
									<div class="kpi-detail-item"><span class="kpi-detail-label">No Permohonan</span><span class="kpi-detail-value">{{ $permohonanKonsumsi->no_permohonan_konsumsi == 0 ? 'Tanpa Ruangan' : ($permohonanKonsumsi->nomor['no_pemesanan_ruangan'] ?? '-') }}</span></div>
									<div class="kpi-detail-item"><span class="kpi-detail-label">Sumber Dana</span><span class="kpi-detail-value">{{ $permohonanKonsumsi->sumber_dana }}</span></div>
									<div class="kpi-detail-item"><span class="kpi-detail-label">Alasan Reject</span><span class="kpi-detail-value">{{ $permohonanKonsumsi->alasan_reject ?: '-' }}</span></div>
									<div class="kpi-detail-item"><span class="kpi-detail-label">Keterangan</span><span class="kpi-detail-value">{{ $permohonanKonsumsi->keterangan ?: '-' }}</span></div>
									<div class="kpi-detail-item"><span class="kpi-detail-label">Attachment</span><span class="kpi-detail-value">
										@if ($permohonanKonsumsi->attachment)
											<a target="_blank" href="{{asset('pemesanan_ruangan/attachment/'.$permohonanKonsumsi->attachment) }}" download>Click</a>
										@else
											-
										@endif
									</span></div>
								</div>
							</div>
						</div>
					</div>
				@empty
					<div class="kpi-empty">Belum ada permohonan konsumsi.</div>
				@endforelse
			</div>

			<div class="kpi-pagination">
				<button id="kpi-prev" type="button" class="btn btn-default btn-sm">Prev</button>
				<span id="kpi-page-info"></span>
				<button id="kpi-next" type="button" class="btn btn-default btn-sm">Next</button>
			</div>
        </div>
    </div>
</div>
@endsection

@section('script')
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
		var keyword = $('#search-konsumsi').val().toLowerCase();
		return $('#kpi-list .kpi-card').filter(function () {
			var kegiatan = ($(this).data('kegiatan') || '').toString().toLowerCase();
			return kegiatan.indexOf(keyword) !== -1;
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

	$('#search-konsumsi').on('keyup', function () {
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
               $.get("{{url('deletelistKonsumsi')}}"+'/'+id, function(){
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
@endsection
