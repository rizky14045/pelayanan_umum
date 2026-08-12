@extends('admin::layout.master')

@section('content')
<style>
	.kpi-toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
	.kpi-toolbar-search{flex:1;max-width:420px;margin-left:auto;}
	.kpi-toolbar-search .form-control{border-radius:20px;padding-left:16px;}
	.kpi-toolbar-date{display:flex;align-items:center;gap:6px;}
	.kpi-toolbar-date .form-control{border-radius:20px;width:170px;}

	#kpi-list{display:flex;flex-direction:column;gap:10px;}

	.kpi-card{display:flex;background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);overflow:hidden;}
	.kpi-card-accent{width:5px;flex-shrink:0;}
	.kpi-card-body{flex:1;padding:12px 20px;}
	.kpi-card-row{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:nowrap;}
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
	.kpi-badge-info{background:#E3EEFD;color:#2C7BE5;}
	.kpi-badge-muted{background:#F0F1F5;color:#8A8FA3;}
	.kpi-card-actions{display:flex;align-items:center;gap:14px;flex-wrap:nowrap;flex-shrink:0;}
	.kpi-action-buttons{display:flex;align-items:center;gap:6px;flex-wrap:nowrap;}
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

	.kpi-btn-outline{display:inline-flex;align-items:center;gap:8px;background:#fff;color:#1F5C85;border:1px solid #1F5C85;border-radius:20px;padding:8px 20px;font-size:14px;font-weight:600;transition:background .15s,color .15s;}
	.kpi-btn-outline:hover{background:#1F5C85;color:#fff;text-decoration:none;}

	.avail-form-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;margin-bottom:16px;}
	.avail-form-field{flex:1 1 140px;min-width:120px;}
	.avail-form-field label{display:block;font-size:11px;text-transform:uppercase;letter-spacing:.03em;color:#8A8FA3;margin-bottom:4px;}
	.avail-submit{height:34px;padding:6px 20px;font-size:13px;background:#1F5C85;border-color:#1F5C85;border-radius:20px;color:#fff;}
	.avail-submit:hover{background:#184a6b;border-color:#184a6b;color:#fff;}

	#avail-results{display:flex;flex-direction:column;gap:8px;max-height:420px;overflow-y:auto;}
	.avail-card{display:flex;background:#fff;border:1px solid #EEF0F5;border-radius:10px;overflow:hidden;}
	.avail-card-accent{width:5px;flex-shrink:0;}
	.avail-card-body{flex:1;padding:10px 16px;}
	.avail-card-title-line{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
	.avail-card-title{font-size:14px;font-weight:700;color:#2A2E43;}
	.avail-card-meta{display:flex;gap:16px;margin-top:6px;flex-wrap:wrap;}
	.avail-card-meta span{display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#6B7080;}
	.avail-conflict-by{color:#E03A5D !important;font-weight:600;}
	.avail-badge{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;white-space:nowrap;}
	.avail-badge-success{background:#E5F7EF;color:#1BAA6B;}
	.avail-badge-danger{background:#FDE7EC;color:#E03A5D;}
	.avail-badge-muted{background:#F0F1F5;color:#8A8FA3;}
	.avail-empty{padding:20px;text-align:center;color:#A6AAB8;font-size:13px;}
	.avail-loading{padding:20px;text-align:center;color:#A6AAB8;font-size:13px;}
	.avail-loading i{margin-right:6px;color:#1F5C85;}
</style>

<div class="block-header">
    <h2>List Pemesanan Ruangan</h2>
</div>
@include('admin::partials.alert-messages')

<div class="kpi-toolbar">
	<a class="kpi-btn-create" href="{{ route('admin::pemesanan-ruangan.form-create') }}"><i class="fa fa-plus"></i> Tambah Pemesanan</a>
	<a href="#" class="kpi-btn-outline" data-toggle="modal" data-target="#availabilityModal"><i class="fa fa-search"></i> Cek Ketersediaan Ruangan</a>
	<div class="kpi-toolbar-search">
		<input id="search-acara" class="form-control" placeholder="Cari acara ..."/>
	</div>
	<div class="kpi-toolbar-date">
		<input type="date" id="filter-tanggal" class="form-control" title="Cek ruangan yang sudah dibooking pada tanggal ini">
		<button type="button" id="filter-tanggal-reset" class="btn btn-default" style="display:none;">&times;</button>
	</div>
</div>

<div id="kpi-list">
	@foreach($pagination as $pemesananRuangan)
		@php
			if ($pemesananRuangan->status_pj == 'Approved' && $pemesananRuangan->status_pelaksana == 'Terlaksana') {
				$accentColor = '#F0C808';
			} elseif ($pemesananRuangan->status_pj == 'Approved') {
				$accentColor = '#2FBF88';
			} elseif ($pemesananRuangan->status_pj == 'Rejected') {
				$accentColor = '#FF6584';
			} else {
				$accentColor = '#1F5C85';
			}

			if ($pemesananRuangan->status_pj == 'Approved') {
				$approvalBadge = ['icon' => 'fa-check-circle', 'class' => 'kpi-badge-success', 'label' => 'Disetujui'];
			} elseif ($pemesananRuangan->status_pj == 'Rejected') {
				$approvalBadge = ['icon' => 'fa-times-circle', 'class' => 'kpi-badge-danger', 'label' => 'Ditolak'];
			} else {
				$approvalBadge = ['icon' => 'fa-clock-o', 'class' => 'kpi-badge-warning', 'label' => 'Pending'];
			}

			if ($pemesananRuangan->status_pelaksana == 'Terlaksana') {
				$pelaksanaBadge = ['icon' => 'fa-flag-checkered', 'class' => 'kpi-badge-info', 'label' => 'Terlaksana'];
			} else {
				$pelaksanaBadge = ['icon' => 'fa-hourglass-half', 'class' => 'kpi-badge-muted', 'label' => 'Belum Terlaksana'];
			}

			$tanggalMulai = $pemesananRuangan->tanggal ? \Carbon\Carbon::parse($pemesananRuangan->tanggal)->format('d-m-Y') : '';
			$tanggalSelesai = $pemesananRuangan->tanggal_selesai ? \Carbon\Carbon::parse($pemesananRuangan->tanggal_selesai)->format('d-m-Y') : '';
			$jamMulai = $pemesananRuangan->waktu_awal ? date('H:i', $pemesananRuangan->waktu_awal) : '';
			$jamSelesai = $pemesananRuangan->waktu_akhir ? date('H:i', $pemesananRuangan->waktu_akhir) : '';
		@endphp
		<div class="kpi-card" data-acara="{{ $pemesananRuangan->nama_acara }}" data-nomor="{{ $pemesananRuangan->no_pemesanan_ruangan }}" data-tanggal-mulai="{{ $pemesananRuangan->tanggal }}" data-tanggal-selesai="{{ $pemesananRuangan->tanggal_selesai ?: $pemesananRuangan->tanggal }}">
			<div class="kpi-card-accent" style="background: {{ $accentColor }}"></div>
			<div class="kpi-card-body">
				<div class="kpi-card-row">
					<div class="kpi-card-title-wrap">
						<div class="kpi-card-title-line">
							<span class="kpi-card-title">{{ $pemesananRuangan->nama_acara }}</span>
							<span class="kpi-badge {{ $approvalBadge['class'] }}"><i class="fa {{ $approvalBadge['icon'] }}"></i> {{ $approvalBadge['label'] }}</span>
							<span class="kpi-badge {{ $pelaksanaBadge['class'] }}"><i class="fa {{ $pelaksanaBadge['icon'] }}"></i> {{ $pelaksanaBadge['label'] }}</span>
						</div>
						<div class="kpi-card-meta">
							<span><i class="fa fa-calendar"></i> {{ $tanggalMulai }} &ndash; {{ $tanggalSelesai }}</span>
							<span><i class="fa fa-clock-o"></i> {{ $jamMulai }} &ndash; {{ $jamSelesai }}</span>
						</div>
					</div>
					<div class="kpi-card-actions">
						<div class="kpi-action-buttons">
							@if (Auth::user()->role == 'adminruang')
								@if($pemesananRuangan->status_pj == 'Pending')
									<a class="btn btn-sm btn-delete btn-primary" href="{{ route('admin::pemesanan-ruangan.approve', [$pemesananRuangan->getKey()]) }}"><i class="fa fa-check"></i> Approve</a>
									<a class="btn btn-sm btn-delete btn-danger reject-button" data-id="{{$pemesananRuangan->id}}" href="#" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"></i> Reject</a>
								@endif
							@else
								@if($pemesananRuangan->status_pj == 'Pending')
									<a class="btn btn-sm btn-delete btn-primary" href="{{ route('admin::pemesanan-ruangan.approve', [$pemesananRuangan->getKey()]) }}"><i class="fa fa-check"></i> Approve</a>
									<a class="btn btn-sm btn-delete btn-danger reject-button" href="#" data-toggle="modal" data-target="#exampleModal" data-id="{{$pemesananRuangan->id}}"><i class="fa fa-times"></i> Reject</a>
									<a class="btn btn-sm btn-edit btn-warning" href="{{ route('admin::pemesanan-ruangan.form-edit', [$pemesananRuangan->getKey()]) }}"><i class="fa fa-pencil"></i> Edit</a>
									<a class="btn btn-sm btn-delete btn-danger delete-button" href="#" data-id="{{$pemesananRuangan->id}}"><i class="fa fa-trash"></i> Delete</a>
								@endif
								@if($pemesananRuangan->status_pj == 'Approved' && $pemesananRuangan->status_pelaksana == 'Belum Terlaksana' )
									<a class="btn btn-sm btn-delete btn-success" href="{{ route('admin::pemesanan-ruangan.terlaksana', [$pemesananRuangan->getKey()]) }}"><i class="fa fa-flag-checkered"></i> Selesai</a>
									<a class="btn btn-sm btn-edit btn-warning" href="{{ route('admin::pemesanan-ruangan.form-edit', [$pemesananRuangan->getKey()]) }}"><i class="fa fa-pencil"></i> Edit</a>
									<a class="btn btn-sm btn-delete btn-danger delete-button" href="#" data-id="{{$pemesananRuangan->id}}"><i class="fa fa-trash"></i> Delete</a>
								@endif
								@if ( $pemesananRuangan->status_pj == 'Rejected')
									<a class="btn btn-sm btn-edit btn-warning" href="{{ route('admin::pemesanan-ruangan.form-edit', [$pemesananRuangan->getKey()]) }}"><i class="fa fa-pencil"></i> Edit</a>
									<a class="btn btn-sm btn-delete btn-danger delete-button" href="#" data-id="{{$pemesananRuangan->id}}"><i class="fa fa-trash"></i> Delete</a>
								@endif
							@endif
						</div>
						<a href="#" class="kpi-toggle"><i class="fa fa-chevron-down"></i></a>
					</div>
				</div>
				<div class="kpi-card-detail">
					<div class="kpi-detail-grid">
						<div class="kpi-detail-item"><span class="kpi-detail-label">No Pemesanan Ruangan</span><span class="kpi-detail-value">{{ $pemesananRuangan->no_pemesanan_ruangan }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Tanggal Pemesanan</span><span class="kpi-detail-value">{{ $pemesananRuangan->created_at->format('d-m-Y H:i:s') }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Pemohon</span><span class="kpi-detail-value">{{ $pemesananRuangan->pemohon }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Jumlah Peserta</span><span class="kpi-detail-value">{{ $pemesananRuangan->jumlah_peserta }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Ruangan</span><span class="kpi-detail-value">{{ $pemesananRuangan->ruang['nama_ruang'] ?? '' }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Design Ruangan</span><span class="kpi-detail-value">{{ $pemesananRuangan->design_ruangan }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Status</span><span class="kpi-detail-value">{{ $pemesananRuangan->status_pj }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Status Pelaksana</span><span class="kpi-detail-value">{{ $pemesananRuangan->status_pelaksana }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Alasan Reject</span><span class="kpi-detail-value">{{ $pemesananRuangan->alasan_reject }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Keterangan</span><span class="kpi-detail-value">{{ $pemesananRuangan->keterangan }}</span></div>
						<div class="kpi-detail-item"><span class="kpi-detail-label">Attachment</span><span class="kpi-detail-value">
							@if ($pemesananRuangan->attachment == null)
								-
							@else
								<a target="_blank" href="{{asset('pemesanan_ruangan/attachment/'.$pemesananRuangan->attachment) }}" download>Click</a>
							@endif
						</span></div>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Beri Alasan Untuk Reject</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('admin::pemesanan-ruangan.reject')}}" method="get">
			<div class="form-group">
				<input type="hidden" id="id-ruangan" name="id_ruangan">
				<label for="exampleFormControlTextarea1">Alasan Reject</label>
				<textarea class="form-control" id="alasan" rows="3" name="alasan"></textarea>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>

<div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="availabilityModalLabel">Cek Ketersediaan Ruangan</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form id="avail-form">
			<div class="avail-form-row">
				<div class="avail-form-field">
					<label>Tanggal</label>
					<input type="date" name="tanggal" class="form-control" required>
				</div>
				<div class="avail-form-field">
					<label>Jam Mulai</label>
					<input type="time" name="waktu_awal" class="form-control" value="08:00" required>
				</div>
				<div class="avail-form-field">
					<label>Jam Selesai</label>
					<input type="time" name="waktu_akhir" class="form-control" value="17:00" required>
				</div>
				<div class="avail-form-field" style="flex:0 0 auto;">
					<button type="submit" class="avail-submit">Cek</button>
				</div>
			</div>
		  </form>
		  <div id="avail-results">
			<div class="avail-empty">Pilih tanggal dan jam, lalu klik Cek untuk melihat ketersediaan ruangan.</div>
		  </div>
		</div>
	  </div>
	</div>
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
			var keyword = $('#search-acara').val().toLowerCase();
			var tanggalCek = $('#filter-tanggal').val();
			return $('#kpi-list .kpi-card').filter(function () {
				var $c = $(this);
				var acara = ($c.data('acara') || '').toString().toLowerCase();
				var nomor = ($c.data('nomor') || '').toString().toLowerCase();
				var cocokKeyword = acara.indexOf(keyword) !== -1 || nomor.indexOf(keyword) !== -1;
				if (!cocokKeyword) return false;

				if (tanggalCek) {
					var mulai = ($c.data('tanggal-mulai') || '').toString();
					var selesai = ($c.data('tanggal-selesai') || '').toString();
					if (!mulai || tanggalCek < mulai || tanggalCek > selesai) return false;
				}

				return true;
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

		$('#search-acara').on('keyup', function () {
			kpiCurrentPage = 1;
			kpiRenderPage();
		});

		$('#filter-tanggal').on('change', function () {
			$('#filter-tanggal-reset').toggle(!!this.value);
			kpiCurrentPage = 1;
			kpiRenderPage();
		});

		$('#filter-tanggal-reset').on('click', function () {
			$('#filter-tanggal').val('');
			$(this).hide();
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
		$('.reject-button').on('click', function () {
			$('#id-ruangan').val($(this).attr("data-id"));
		})
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
					$.get("{{url('admin/pemesanan-ruangan/delete')}}"+'/'+id, function(){
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
	<script>
		$('#avail-form').on('submit', function (e) {
			e.preventDefault();
			var $results = $('#avail-results');
			$results.html('<div class="avail-loading"><i class="fa fa-spinner fa-spin"></i> Mengecek ketersediaan...</div>');
			$.get("{{ route('admin::pemesanan-ruangan.check-availability') }}", $(this).serialize())
				.done(function (res) {
					$results.html(res.html);
				})
				.fail(function () {
					$results.html('<div class="avail-empty">Gagal mengecek ketersediaan, silakan coba lagi.</div>');
				});
		});
	</script>

@stop
