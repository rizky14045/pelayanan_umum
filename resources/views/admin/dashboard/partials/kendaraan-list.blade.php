@if($kendaraan->count())
<div class="dash-list">
	@foreach($kendaraan as $item)
		<div class="dash-item">
			<div class="dash-item-accent"></div>
			<div class="dash-item-body">
				<div class="dash-item-title">{{ $item->keperluan }}</div>
				<div class="dash-item-meta">
					<span><i class="fa fa-user"></i> {{ $item->pemohon }}</span>
					<span><i class="fa fa-map-marker"></i> {{ $item->tujuan }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
@else
<div class="dash-empty">Tidak ada permohonan kendaraan yang sedang berjalan</div>
@endif
