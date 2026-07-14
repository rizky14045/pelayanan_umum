@if($konsumsi->count())
<div class="dash-list">
	@foreach($konsumsi as $item)
		<div class="dash-item">
			<div class="dash-item-accent"></div>
			<div class="dash-item-body">
				<div class="dash-item-title">{{ $item->kegiatan }}</div>
				<div class="dash-item-meta">
					<span><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}@if($item->tanggal_selesai) &ndash; {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}@endif</span>
					<span><i class="fa fa-cutlery"></i> {{ $item->jumlah }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
@else
<div class="dash-empty">Tidak ada permohonan konsumsi yang belum terlaksana</div>
@endif
