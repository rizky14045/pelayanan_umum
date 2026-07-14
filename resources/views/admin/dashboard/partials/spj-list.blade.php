@if($spj->count())
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
				</div>
			</div>
		</div>
	@endforeach
</div>
@else
<div class="dash-empty">Tidak ada surat perintah jalan yang sedang berjalan</div>
@endif
