<form method="GET" action="{{ route('admin::dashboard.ajax.ruangan') }}" class="dash-filter-form">
	<div class="dash-filter-row">
		<select name="ruangan_status" class="form-control ms dash-filter-field">
			<option value="">Semua Status</option>
			<option value="Pending" {{ request('ruangan_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
			<option value="Approved" {{ request('ruangan_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
			<option value="Rejected" {{ request('ruangan_status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
		</select>
		<select name="ruangan_pelaksana" class="form-control ms dash-filter-field">
			<option value="">Semua Pelaksanaan</option>
			<option value="Terlaksana" {{ $ruanganPelaksana == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
			<option value="Belum Terlaksana" {{ $ruanganPelaksana == 'Belum Terlaksana' ? 'selected' : '' }}>Belum Terlaksana</option>
		</select>
		<input type="date" name="ruangan_dari" class="form-control ms dash-filter-field" value="{{ request('ruangan_dari') }}" placeholder="Dari Tanggal">
		<input type="date" name="ruangan_sampai" class="form-control ms dash-filter-field" value="{{ request('ruangan_sampai') }}" placeholder="Sampai Tanggal">
		<input type="text" name="ruangan_cari" class="form-control ms dash-filter-field" value="{{ request('ruangan_cari') }}" placeholder="Cari nama acara ...">
		<button type="submit" class="btn btn-primary dash-filter-submit">Filter</button>
	</div>
</form>
@if($ruangan->total())
<div class="dash-list">
	@foreach($ruangan as $item)
		<div class="dash-item">
			<div class="dash-item-accent"></div>
			<div class="dash-item-body">
				<div class="dash-item-title">{{ $item->nama_acara }}</div>
				<div class="dash-item-meta">
					<span><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}@if($item->tanggal_selesai) &ndash; {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}@endif</span>
					<span><i class="fa fa-clock-o"></i> {{ date('H:i', $item->waktu_awal) }} &ndash; {{ date('H:i', $item->waktu_akhir) }}</span>
					<span><i class="fa fa-info-circle"></i> {{ $item->status_pj }}</span>
					<span><i class="fa fa-flag-checkered"></i> {{ $item->status_pelaksana ?: 'Belum Terlaksana' }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
<div class="dash-pagination">
	{{ $ruangan->links('admin::partials.pagination') }}
</div>
@else
<div class="dash-empty">Tidak ada pemesanan ruangan yang sesuai filter</div>
@endif
