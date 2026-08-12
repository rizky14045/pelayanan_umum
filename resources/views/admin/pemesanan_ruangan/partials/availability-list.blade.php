@forelse($ruangs as $ruang)
	<div class="avail-card {{ $ruang->is_conflicted ? 'is-conflicted' : '' }}">
		<div class="avail-card-accent" style="background: {{ $ruang->is_conflicted ? '#FF6584' : '#2FBF88' }}"></div>
		<div class="avail-card-body">
			<div class="avail-card-title-line">
				<span class="avail-card-title">{{ $ruang->nama_ruang }}</span>
				@if($ruang->is_kombinasi)
					<span class="avail-badge avail-badge-muted">Gabungan: {{ $ruang->anggotaRooms->pluck('nama_ruang')->implode(', ') }}</span>
				@endif
				@if($ruang->is_conflicted)
					<span class="avail-badge avail-badge-danger"><i class="fa fa-times-circle"></i> Tidak Tersedia</span>
				@else
					<span class="avail-badge avail-badge-success"><i class="fa fa-check-circle"></i> Tersedia</span>
				@endif
			</div>
			<div class="avail-card-meta">
				<span><i class="fa fa-users"></i> Kapasitas {{ $ruang->kapasitas }} orang</span>
				@if($ruang->is_conflicted && !empty($ruang->conflict_booker_names))
					<span class="avail-conflict-by"><i class="fa fa-user"></i> Dipakai oleh: {{ implode(', ', $ruang->conflict_booker_names) }}</span>
				@endif
			</div>
		</div>
	</div>
@empty
	<div class="avail-empty">Tidak ada ruangan dengan kriteria ini.</div>
@endforelse
