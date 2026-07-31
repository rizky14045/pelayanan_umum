<form method="GET" action="{{ route('admin::dashboard.ajax.konsumsi') }}" class="dash-filter-form">
	<div class="dash-filter-row">
		<select name="konsumsi_status" class="form-control ms dash-filter-field">
			<option value="">Semua Status</option>
			<option value="Pending" {{ request('konsumsi_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
			<option value="Approved" {{ request('konsumsi_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
			<option value="Rejected" {{ request('konsumsi_status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
		</select>
		<select name="konsumsi_pelaksana" class="form-control ms dash-filter-field">
			<option value="">Semua Pelaksanaan</option>
			<option value="Terlaksana" {{ $konsumsiPelaksana == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
			<option value="Belum Terlaksana" {{ $konsumsiPelaksana == 'Belum Terlaksana' ? 'selected' : '' }}>Belum Terlaksana</option>
		</select>
		<input type="date" name="konsumsi_dari" class="form-control ms dash-filter-field" value="{{ request('konsumsi_dari') }}" placeholder="Dari Tanggal">
		<input type="date" name="konsumsi_sampai" class="form-control ms dash-filter-field" value="{{ request('konsumsi_sampai') }}" placeholder="Sampai Tanggal">
		<input type="text" name="konsumsi_cari" class="form-control ms dash-filter-field" value="{{ request('konsumsi_cari') }}" placeholder="Cari nama kegiatan ...">
		<button type="submit" class="btn btn-primary dash-filter-submit">Filter</button>
	</div>
</form>
@if($konsumsi->total())
<div class="dash-list">
	@foreach($konsumsi as $item)
		<div class="dash-item">
			<div class="dash-item-accent"></div>
			<div class="dash-item-body">
				<div class="dash-item-title">{{ $item->kegiatan }}</div>
				<div class="dash-item-meta">
					<span><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}@if($item->tanggal_selesai) &ndash; {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}@endif</span>
					<span><i class="fa fa-cutlery"></i> {{ $item->jumlah }}</span>
					<span><i class="fa fa-info-circle"></i> {{ $item->status_pj }}</span>
					<span><i class="fa fa-flag-checkered"></i> {{ $item->status_pelaksana ?: 'Belum Terlaksana' }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
<div class="dash-pagination">
	{{ $konsumsi->links('admin::partials.pagination') }}
</div>
@else
<div class="dash-empty">Tidak ada permohonan konsumsi yang sesuai filter</div>
@endif
