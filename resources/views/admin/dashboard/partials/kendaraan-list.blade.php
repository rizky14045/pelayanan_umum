<form method="GET" action="{{ route('admin::dashboard.ajax.kendaraan') }}" class="dash-filter-form">
	<div class="dash-filter-row">
		<select name="kendaraan_status" class="form-control ms dash-filter-field">
			<option value="">Semua Status</option>
			<option value="Pending" {{ request('kendaraan_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
			<option value="Approved" {{ request('kendaraan_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
			<option value="Rejected" {{ request('kendaraan_status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
		</select>
		<input type="date" name="kendaraan_dari" class="form-control ms dash-filter-field" value="{{ request('kendaraan_dari') }}" placeholder="Dari Tanggal">
		<input type="date" name="kendaraan_sampai" class="form-control ms dash-filter-field" value="{{ request('kendaraan_sampai') }}" placeholder="Sampai Tanggal">
		<input type="text" name="kendaraan_cari" class="form-control ms dash-filter-field" value="{{ request('kendaraan_cari') }}" placeholder="Cari keperluan/tujuan ...">
		<button type="submit" class="btn btn-primary dash-filter-submit">Filter</button>
	</div>
</form>
@if($kendaraan->total())
<div class="dash-list">
	@foreach($kendaraan as $item)
		<div class="dash-item">
			<div class="dash-item-accent"></div>
			<div class="dash-item-body">
				<div class="dash-item-title">{{ $item->keperluan }}</div>
				<div class="dash-item-meta">
					<span><i class="fa fa-user"></i> {{ $item->pemohon }}</span>
					<span><i class="fa fa-map-marker"></i> {{ $item->tujuan }}</span>
					<span><i class="fa fa-info-circle"></i> {{ $item->status_pj }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
<div class="dash-pagination">
	{{ $kendaraan->links('admin::partials.pagination') }}
</div>
@else
<div class="dash-empty">Tidak ada permohonan kendaraan yang sesuai filter</div>
@endif
