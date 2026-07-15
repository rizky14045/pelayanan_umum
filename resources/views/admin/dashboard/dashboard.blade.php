@extends('admin::layout.master')

@section('content')
  <style>
	.dash-list{display:flex;flex-direction:column;gap:8px;}
	.dash-item{display:flex;align-items:stretch;gap:12px;padding:10px 14px;border:1px solid #EEF0F5;border-radius:8px;background:#fff;}
	.dash-item-accent{width:4px;border-radius:2px;background:#1F5C85;flex-shrink:0;}
	.dash-item-body{flex:1;min-width:0;}
	.dash-item-title{font-weight:700;font-size:14px;color:#2A2E43;word-break:break-word;}
	.dash-item-title-sub{font-weight:400;color:#8A8FA3;}
	.dash-item-meta{display:flex;gap:16px;flex-wrap:wrap;margin-top:4px;}
	.dash-item-meta span{font-size:12px;color:#6B7080;display:inline-flex;align-items:center;gap:5px;}
	.dash-item-meta i{color:#A6AAB8;}
	.dash-empty{padding:20px;text-align:center;color:#A6AAB8;font-size:13px;}
  </style>
  @include('admin::partials.alert-messages')

  <div class="block-header">
      <h2>Rangkuman Berjalan Aplikasi Pelayanan Umum</h2>
  </div>
  @if (Auth::user()->role == 'superadmin')
  <div class="row">
    <a href="{{url('admin/permohonan-konsumsi')}}" class="col-md-3">
        @include('admin::partials.infobox', [
          'icon' => 'fastfood',
          'count' => $konsumsi->count(),
          'label' => 'Permohonan Konsumsi',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',
          ])
    </a>
    <a href="{{url('admin/permohonan-pemakaian-kendaraan')}}" class="col-md-3">
      @include('admin::partials.infobox', [
        'icon' => 'directions_car',
        'count' => $kendaraan->count(),
        'label' => 'Permohonan Kendaraan',
        'hover_effect' => 'zoom',
        'icon_classes' => 'bg-blue',
      ])
    </a>
    <a href="{{url('admin/pemesanan-ruangan')}}" class="col-md-3">
      @include('admin::partials.infobox', [
        'icon' => 'meeting_room',
        'count' => $ruangan->count(),
        'label' => 'Pemesanan Ruangan',
        'hover_effect' => 'zoom',
        'icon_classes' => 'bg-blue',

      ])
    </a>
    <a href="{{url('admin/surat-perintah-jalan')}}" class="col-md-3">
      @include('admin::partials.infobox', [
        'icon' => 'directions_walk',
        'count' => $spj->count(),
        'label' => 'Surat Perintah Jalan',
        'hover_effect' => 'zoom',
        'icon_classes' => 'bg-blue',
      ])
    </a>
  </div>
  <div class="block-header">
    <h2>Rangkuman Data Berjalan Aplikasi Pelayanan Umum</h2>
  </div>
  @component('admin::partials.card', [
    'title' => 'Permohonan Konsumsi (Belum Terlaksana)',
    'description' => ''
  ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/permohonan-konsumsi')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    @include('admin::dashboard.partials.konsumsi-list')
  @endcomponent

  @component('admin::partials.card', [
    'title' => 'Permohonan Kendaraan',
    'description' => ''
  ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/permohonan-pemakaian-kendaraan')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    @include('admin::dashboard.partials.kendaraan-list')
  @endcomponent

  @component('admin::partials.card', [
    'title' => 'Pemesanan Ruangan (Belum Terlaksana)',
    'description' => ''
  ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/pemesanan-ruangan')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    @include('admin::dashboard.partials.ruangan-list')
  @endcomponent

  @component('admin::partials.card', [
    'title' => 'Surat Perintah Jalan',
    'description' => ''
  ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/surat-perintah-jalan')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    @include('admin::dashboard.partials.spj-list')
  @endcomponent
  @endif
  @if (Auth::user()->role == 'adminruang')
    <div class="row">
      <a href="{{url('admin/permohonan-konsumsi')}}" class="col-md-6">
          @include('admin::partials.infobox', [
            'icon' => 'fastfood',
            'count' => $konsumsi->count(),
            'label' => 'Permohonan Konsumsi',
            'hover_effect' => 'zoom',
            'icon_classes' => 'bg-blue',
            ])
      </a>
      <a href="{{url('admin/pemesanan-ruangan')}}" class="col-md-6">
        @include('admin::partials.infobox', [
          'icon' => 'meeting_room',
          'count' => $ruangan->count(),
          'label' => 'Pemesanan Ruangan',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',

        ])
      </a>
    </div>

    <div class="block-header">
      <h2>Rangkuman Data Berjalan Aplikasi Pelayanan Umum</h2>
    </div>
    @component('admin::partials.card', [
      'title' => 'Permohonan Konsumsi (Belum Terlaksana)',
      'description' => ''
    ])
      @slot('header_dropdown')
      <ul class="header-dropdown m-r--5">
        <a href="{{url('admin/permohonan-konsumsi')}}" class="btn btn-primary">Semua</a>
      </ul>
      @endslot
      @include('admin::dashboard.partials.konsumsi-list')
    @endcomponent
    @component('admin::partials.card', [
    'title' => 'Pemesanan Ruangan (Belum Terlaksana)',
    'description' => ''
     ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/pemesanan-ruangan')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    @include('admin::dashboard.partials.ruangan-list')
  @endcomponent
  @endif
  @if (Auth::user()->role == 'adminkendaraan')
    <div class="row">
      <a href="{{url('admin/permohonan-pemakaian-kendaraan')}}" class="col-md-6">
        @include('admin::partials.infobox', [
          'icon' => 'directions_car',
          'count' => $kendaraan->count(),
          'label' => 'Permohonan Kendaraan',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',
        ])
      </a>
      <a href="{{url('admin/surat-perintah-jalan')}}" class="col-md-6">
        @include('admin::partials.infobox', [
          'icon' => 'directions_walk',
          'count' => $spj->count(),
          'label' => 'Surat Perintah Jalan',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',
        ])
      </a>
    </div>
    <div class="block-header">
      <h2>Rangkuman Data Berjalan Aplikasi Pelayanan Umum</h2>
    </div>
      @component('admin::partials.card', [
      'title' => 'Permohonan Kendaraan',
      'description' => ''
        ])
      @slot('header_dropdown')
      <ul class="header-dropdown m-r--5">
        <a href="{{url('admin/permohonan-pemakaian-kendaraan')}}" class="btn btn-primary">Semua</a>
      </ul>
      @endslot
      @include('admin::dashboard.partials.kendaraan-list')
    @endcomponent
      @component('admin::partials.card', [
      'title' => 'Surat Perintah Jalan',
      'description' => ''
        ])
      @slot('header_dropdown')
      <ul class="header-dropdown m-r--5">
        <a href="{{url('admin/surat-perintah-jalan')}}" class="btn btn-primary">Semua</a>
      </ul>
      @endslot
      @include('admin::dashboard.partials.spj-list')
    @endcomponent
  @endif


@stop
