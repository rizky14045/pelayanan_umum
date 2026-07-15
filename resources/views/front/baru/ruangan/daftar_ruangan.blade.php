@extends('front.baru.master')
@section('content')
<style>
    .room-grid{display:flex;flex-wrap:wrap;margin:0 -10px;}
    .room-grid-item{width:25%;padding:10px;box-sizing:border-box;}
    @media (max-width:992px){ .room-grid-item{width:50%;} }
    @media (max-width:576px){ .room-grid-item{width:100%;} }

    .room-card{background:#fff;border:1px solid #EEF0F5;border-radius:10px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);display:flex;flex-direction:column;height:100%;transition:box-shadow .15s,transform .15s;}
    .room-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.1);transform:translateY(-2px);}
    .room-card-img{width:100%;height:160px;object-fit:cover;background:#f3f3f3;display:block;}
    .room-card-body{padding:14px 16px;display:flex;flex-direction:column;flex:1;}
    .room-card-title{font-size:15px;font-weight:700;color:#2A2E43;margin:0 0 6px;}
    .room-card-badge{display:inline-block;font-size:11px;background:#E3EEFD;color:#2C7BE5;padding:3px 8px;border-radius:12px;margin-bottom:6px;}
    .room-card-desc{font-size:13px;color:#6B7080;flex:1;margin-bottom:10px;}
    .room-card-footer{display:flex;justify-content:space-between;align-items:center;margin-top:auto;gap:8px;flex-wrap:wrap;}
    .room-card-capacity{font-size:13px;color:#2A2E43;}
    .room-card-capacity strong{font-size:16px;color:#1F5C85;}
    .room-card-btn{background:#1F5C85;color:#fff;border:none;border-radius:20px;padding:6px 16px;font-size:13px;font-weight:600;cursor:pointer;}
    .room-card-btn:hover{filter:brightness(0.92);color:#fff;}
    .room-card.is-conflicted{opacity:.75;}
    .room-card-badge-conflict{display:inline-block;font-size:11px;background:#FDE7EC;color:#E03A5D;padding:3px 8px;border-radius:12px;margin-bottom:6px;font-weight:600;}
    .room-card-btn-disabled{background:#E5E7EB;color:#8A8FA3;border:none;border-radius:20px;padding:6px 16px;font-size:13px;font-weight:600;cursor:not-allowed;}
</style>
<div class="container">
    <h3 class="booking-title">Daftar Ruangan tersedia untuk {{$jumlah_peserta}} orang pada tanggal
        {{$date}}</h3>
    <form class="booking-item-dates-change mb40" action="{{url('fetchruangan')}}" method="GET">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-lg form-group-icon-left">
                        <i class="fa fa-calendar input-icon input-icon-highlight"></i>
                        <label>Tanggal Pemesanan</label>
                        <input class="form-control" name="range_date" value="{{$date}}" required autocomplete="off" />
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-group form-group-lg form-group-icon-left">
                        <i class="fa fa-calendar input-icon input-icon-highlight"></i>
                        <label>Tanggal Selesai</label>
                        <input class="form-control" type="date" name="tanggal_selesai" value="{{Request::get('tanggal_selesai')}}" required autocomplete="off" />
                    </div>
                </div> --}}
            </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-lg form-group-icon-left">
                    <i class="fa fa-clock input-icon input-icon-highlight"></i>
                    <label>Waktu Mulai</label>
                    <input class="form-control" type="time" name="waktu_awal" value="{{Request::get('waktu_awal')}}" required autocomplete="off" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-lg form-group-icon-left">
                    <i class="fa fa-clock input-icon input-icon-highlight"></i>
                    <label>Waktu Selesai</label>
                    <input class="form-control" type="time" name="waktu_akhir" value="{{Request::get('waktu_akhir')}}" required autocomplete="off" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-lg form-group-icon-left">
                    <i class="fa fa-users input-icon input-icon-highlight"></i>
                    <label>Jumlah Peserta</label>
                    <input class="form-control" type="number" min="0" max="200" required autocomplete="off" name="jumlah_peserta" value="{{Request::get('jumlah_peserta')}}" />
                </div>
            </div>
        </div>
        </div>
        <button class="btn btn-primary btn-lg" type="submit">
            Cari Ruangan
        </button>
    </form>

    <div class="room-grid">
        @forelse($ruangs as $ruang)
            <div class="room-grid-item">
                <div class="room-card {{ $ruang->is_conflicted ? 'is-conflicted' : '' }}">
                    <img class="room-card-img" src="{{asset($ruang->foto_ruang)}}" alt="{{$ruang->nama_ruang}}" />
                    <div class="room-card-body">
                        <h5 class="room-card-title">{{$ruang->nama_ruang}}</h5>
                        @if($ruang->is_kombinasi)
                            <span class="room-card-badge">Gabungan: {{ $ruang->anggotaRooms->pluck('nama_ruang')->implode(', ') }}</span>
                        @endif
                        @if($ruang->is_conflicted)
                            <span class="room-card-badge-conflict">
                                Sudah dipesan pada jadwal ini
                                @if(!empty($ruang->conflict_booker_names))
                                    oleh {{ implode(', ', $ruang->conflict_booker_names) }}
                                @endif
                            </span>
                        @endif
                        <p class="room-card-desc">{{$ruang->deskripsi}}</p>
                        <div class="room-card-footer">
                            <span class="room-card-capacity"><strong>{{$ruang->kapasitas}}</strong> orang</span>
                            @if($ruang->is_conflicted)
                                <button type="button" class="room-card-btn-disabled" disabled>Tidak Tersedia</button>
                            @else
                                <form method="GET" action="pemesananruangan">
                                    <input type="hidden" value="{{$ruang->id}}" name="id_ruang">
                                    <input type="hidden" value="{{$ruang->nama_ruang}}" name="nama_ruang">
                                    <input type="hidden" value="{{$date}}" name="rangedate">
                                    <input type="hidden" value="{{$waktu_awal}}" name="waktu_awal">
                                    <input type="hidden" value="{{$waktu_akhir}}" name="waktu_akhir">
                                    <input type="hidden" value="{{$jumlah_peserta}}" name="jumlah_peserta">
                                    <button type="submit" class="room-card-btn">Tersedia</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="room-grid-item" style="width:100%;">
                <p class="text-center text-muted">Tidak ada ruangan tersedia untuk kriteria pencarian ini.</p>
            </div>
        @endforelse
    </div>
    <div class="gap"></div>
</div>
@endsection