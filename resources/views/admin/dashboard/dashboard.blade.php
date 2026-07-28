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
	.dash-loading{padding:20px;text-align:center;color:#A6AAB8;font-size:13px;}
	.dash-loading i{margin-right:6px;color:#1F5C85;}

	.dash-filter-form{margin-bottom:14px;}
	.dash-filter-row{display:flex;flex-wrap:wrap;gap:8px;align-items:center;}
	.dash-filter-field{width:auto;flex:1 1 150px;min-width:120px;height:34px;padding:6px 10px;font-size:12px;}
	.dash-filter-submit{height:34px;padding:6px 18px;font-size:12px;background:#1F5C85;border-color:#1F5C85;}
	.dash-filter-submit:hover{background:#184a6b;border-color:#184a6b;}

	.dash-pagination{margin-top:14px;text-align:center;}
	.dash-pagination .pagination{margin:0;}
	.dash-pagination .pagination > li > a,
	.dash-pagination .pagination > li > span{color:#1F5C85;}
	.dash-pagination .pagination > .active > span{background:#1F5C85;border-color:#1F5C85;color:#fff;}
  </style>
  @include('admin::partials.alert-messages')

  <div class="block-header">
      <h2>Rangkuman Aplikasi Pelayanan Umum</h2>
  </div>
  @if (Auth::user()->role == 'superadmin')
  <div class="row">
    <a href="{{url('admin/permohonan-konsumsi')}}" class="col-md-3">
        @include('admin::partials.infobox', [
          'id' => 'infobox-konsumsi',
          'icon' => 'fastfood',
          'count' => 0,
          'label' => 'Permohonan Konsumsi',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',
          ])
    </a>
    <a href="{{url('admin/permohonan-pemakaian-kendaraan')}}" class="col-md-3">
      @include('admin::partials.infobox', [
        'id' => 'infobox-kendaraan',
        'icon' => 'directions_car',
        'count' => 0,
        'label' => 'Permohonan Kendaraan',
        'hover_effect' => 'zoom',
        'icon_classes' => 'bg-blue',
      ])
    </a>
    <a href="{{url('admin/pemesanan-ruangan')}}" class="col-md-3">
      @include('admin::partials.infobox', [
        'id' => 'infobox-ruangan',
        'icon' => 'meeting_room',
        'count' => 0,
        'label' => 'Pemesanan Ruangan',
        'hover_effect' => 'zoom',
        'icon_classes' => 'bg-blue',

      ])
    </a>
    <a href="{{url('admin/surat-perintah-jalan')}}" class="col-md-3">
      @include('admin::partials.infobox', [
        'id' => 'infobox-spj',
        'icon' => 'directions_walk',
        'count' => 0,
        'label' => 'Surat Perintah Jalan',
        'hover_effect' => 'zoom',
        'icon_classes' => 'bg-blue',
      ])
    </a>
  </div>
  <div class="block-header">
    <h2>Data Aplikasi Pelayanan Umum</h2>
  </div>
  @component('admin::partials.card', [
    'title' => 'Permohonan Konsumsi',
    'description' => ''
  ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/permohonan-konsumsi')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.konsumsi') }}" data-infobox="infobox-konsumsi">
      <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
    </div>
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
    <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.kendaraan') }}" data-infobox="infobox-kendaraan">
      <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
    </div>
  @endcomponent

  @component('admin::partials.card', [
    'title' => 'Pemesanan Ruangan',
    'description' => ''
  ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/pemesanan-ruangan')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.ruangan') }}" data-infobox="infobox-ruangan">
      <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
    </div>
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
    <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.spj') }}" data-infobox="infobox-spj">
      <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
    </div>
  @endcomponent
  @endif
  @if (Auth::user()->role == 'adminruang')
    <div class="row">
      <a href="{{url('admin/permohonan-konsumsi')}}" class="col-md-6">
          @include('admin::partials.infobox', [
            'id' => 'infobox-konsumsi',
            'icon' => 'fastfood',
            'count' => 0,
            'label' => 'Permohonan Konsumsi',
            'hover_effect' => 'zoom',
            'icon_classes' => 'bg-blue',
            ])
      </a>
      <a href="{{url('admin/pemesanan-ruangan')}}" class="col-md-6">
        @include('admin::partials.infobox', [
          'id' => 'infobox-ruangan',
          'icon' => 'meeting_room',
          'count' => 0,
          'label' => 'Pemesanan Ruangan',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',

        ])
      </a>
    </div>

    <div class="block-header">
      <h2>Data Aplikasi Pelayanan Umum</h2>
    </div>
    @component('admin::partials.card', [
      'title' => 'Permohonan Konsumsi',
      'description' => ''
    ])
      @slot('header_dropdown')
      <ul class="header-dropdown m-r--5">
        <a href="{{url('admin/permohonan-konsumsi')}}" class="btn btn-primary">Semua</a>
      </ul>
      @endslot
      <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.konsumsi') }}" data-infobox="infobox-konsumsi">
        <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
      </div>
    @endcomponent
    @component('admin::partials.card', [
    'title' => 'Pemesanan Ruangan',
    'description' => ''
     ])
    @slot('header_dropdown')
    <ul class="header-dropdown m-r--5">
      <a href="{{url('admin/pemesanan-ruangan')}}" class="btn btn-primary">Semua</a>
    </ul>
    @endslot
    <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.ruangan') }}" data-infobox="infobox-ruangan">
      <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
    </div>
  @endcomponent
  @endif
  @if (Auth::user()->role == 'adminkendaraan')
    <div class="row">
      <a href="{{url('admin/permohonan-pemakaian-kendaraan')}}" class="col-md-6">
        @include('admin::partials.infobox', [
          'id' => 'infobox-kendaraan',
          'icon' => 'directions_car',
          'count' => 0,
          'label' => 'Permohonan Kendaraan',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',
        ])
      </a>
      <a href="{{url('admin/surat-perintah-jalan')}}" class="col-md-6">
        @include('admin::partials.infobox', [
          'id' => 'infobox-spj',
          'icon' => 'directions_walk',
          'count' => 0,
          'label' => 'Surat Perintah Jalan',
          'hover_effect' => 'zoom',
          'icon_classes' => 'bg-blue',
        ])
      </a>
    </div>
    <div class="block-header">
      <h2>Data Aplikasi Pelayanan Umum</h2>
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
      <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.kendaraan') }}" data-infobox="infobox-kendaraan">
        <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
      </div>
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
      <div class="dash-section" data-ajax-url="{{ route('admin::dashboard.ajax.spj') }}" data-infobox="infobox-spj">
        <div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>
      </div>
    @endcomponent
  @endif
@stop

@section('js')
  <script>
  (function ($) {
    function loadSection($section, url) {
      $section.html('<div class="dash-loading"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>');
      $.get(url)
        .done(function (res) {
          $section.html(res.html);
          var infoboxId = $section.data('infobox');
          if (infoboxId) {
            $('#' + infoboxId + ' .number').text(res.total);
          }
        })
        .fail(function () {
          $section.html('<div class="dash-empty">Gagal memuat data, silakan muat ulang halaman.</div>');
        });
    }

    $(function () {
      $('.dash-section[data-ajax-url]').each(function () {
        var $section = $(this);
        loadSection($section, $section.data('ajax-url'));
      });

      $(document).on('submit', '.dash-filter-form', function (e) {
        e.preventDefault();
        var $section = $(this).closest('.dash-section');
        var url = $(this).attr('action') + '?' + $(this).serialize();
        loadSection($section, url);
      });

      $(document).on('click', '.dash-pagination a', function (e) {
        e.preventDefault();
        var $section = $(this).closest('.dash-section');
        loadSection($section, $(this).attr('href'));
      });
    });
  })(jQuery);
  </script>
@stop
