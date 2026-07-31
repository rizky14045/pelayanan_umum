<form method="GET" action="{{ route('admin::dashboard.ajax.spj') }}" class="dash-filter-form">
	<div class="dash-filter-row">
		<select name="spj_status" class="form-control ms dash-filter-field">
			<option value="">Semua Status</option>
			<option value="Pending" {{ request('spj_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
			<option value="Approved" {{ request('spj_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
			<option value="Rejected" {{ request('spj_status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
		</select>
		<select name="spj_perjalanan" class="form-control ms dash-filter-field">
			<option value="">Semua Perjalanan</option>
			<option value="Belum Sampai" {{ $spjPerjalanan == 'Belum Sampai' ? 'selected' : '' }}>Belum Sampai</option>
			<option value="Sudah Sampai" {{ $spjPerjalanan == 'Sudah Sampai' ? 'selected' : '' }}>Sudah Sampai</option>
		</select>
		<input type="date" name="spj_dari" class="form-control ms dash-filter-field" value="{{ request('spj_dari') }}" placeholder="Dari Tanggal">
		<input type="date" name="spj_sampai" class="form-control ms dash-filter-field" value="{{ request('spj_sampai') }}" placeholder="Sampai Tanggal">
		<input type="text" name="spj_cari" class="form-control ms dash-filter-field" value="{{ request('spj_cari') }}" placeholder="Cari tujuan ...">
		<button type="submit" class="btn btn-primary dash-filter-submit">Filter</button>
	</div>
</form>
@if($spj->total())
<div class="dash-list">
	@foreach($spj as $item)
		<div class="dash-item">
			<div class="dash-item-accent"></div>
			<div class="dash-item-body">
				<div class="dash-item-title">{{ $item->kendaraan->nama_kendaraan ?? 'Tanpa Kendaraan' }} <span class="dash-item-title-sub">({{ $item->kendaraan->no_pol ?? '-' }})</span></div>
				<div class="dash-item-meta">
					<span><i class="fa fa-id-card"></i> {{ $item->driver->nama_driver ?? '' }}</span>
					<span><i class="fa fa-map-marker"></i> {{ $item->tujuan }}</span>
					<span><i class="fa fa-calendar"></i> {{ $item->tanggal_berangkat }} &ndash; {{ $item->tanggal_kembali }}</span>
					<span><i class="fa fa-info-circle"></i> {{ $item->status_pj }}</span>
					<span><i class="fa fa-flag-checkered"></i> {{ $item->status_perjalanan ?: 'Belum Sampai' }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
<div class="dash-pagination">
	{{ $spj->links('admin::partials.pagination') }}
</div>
@else
<div class="dash-empty">Tidak ada surat perintah jalan yang sesuai filter</div>
@endif
