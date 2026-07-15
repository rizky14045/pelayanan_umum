<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>{{ $title or 'Aplikasi Pemesanan Ruang dan Konsumsi' }}</title>
  <!-- Favicon-->
  <link rel="icon" href="{{asset('vendor/home')}}/images/new-logo.ico">

  @section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

  <!-- Font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-dt/1.13.1/css/jquery.dataTables.min.css">
  

  <!-- Bootstrap Core Css -->
  <link href="{{ asset('vendor/admin-bsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="{{ asset('vendor/admin-bsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="{{ asset('vendor/admin-bsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

  <!-- Custom Css -->
  <link href="{{ asset('vendor/admin-bsb/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('admin-template/css/style.css') }}" rel="stylesheet">

  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <link href="{{ asset('vendor/admin-bsb/css/themes/all-themes.css') }}" rel="stylesheet" />

  <!-- Custom Navy Palette Override -->
  <style>
    body.theme-blue .navbar { background: #1F5C85 !important; }
    body.theme-blue .navbar-brand,
    body.theme-blue .navbar-brand:hover,
    body.theme-blue .navbar-brand:active,
    body.theme-blue .navbar-brand:focus,
    body.theme-blue .bars,
    body.theme-blue .nav > li > a { color: #fff !important; }

    body.theme-blue #leftsidebar,
    body.theme-blue .sidebar { background: #1F5C85 !important; }

    body.theme-blue .sidebar .user-info {
      background: #1F5C85 !important;
      border-bottom: 1px solid rgba(255,255,255,0.15) !important;
    }
    body.theme-blue .sidebar .menu .list .header {
      background: #1F5C85 !important;
      color: #fff !important;
    }
    body.theme-blue .sidebar .menu .list li a,
    body.theme-blue .sidebar .menu .list li a span { color: #fff !important; }
    body.theme-blue .sidebar .menu .list li a i.material-icons { color: #fff !important; }
    body.theme-blue .sidebar .menu .list li a:hover,
    body.theme-blue .sidebar .menu .list li.active,
    body.theme-blue .sidebar .menu .list .toggled { background: rgba(255,255,255,0.12) !important; }
    body.theme-blue .sidebar .menu .list li.active > :first-child i,
    body.theme-blue .sidebar .menu .list li.active > :first-child span { color: #fff !important; }
    body.theme-blue .sidebar .menu .list .ml-menu { background: rgba(0,0,0,0.12) !important; }
    body.theme-blue .sidebar .legal {
      background: #1F5C85 !important;
      border-top: 1px solid rgba(255,255,255,0.15) !important;
    }
    body.theme-blue .sidebar .legal .copyright,
    body.theme-blue .sidebar .legal .version { color: #fff !important; }
    body.theme-blue .sidebar .legal .copyright a { color: #fff !important; }
  </style>

  @styles
  @show
</head>

<body class="theme-blue">
  <!-- Page Loader -->
  @include('admin::layout.page-loader')
  <!-- #END# Page Loader -->
  <!-- Overlay For Sidebars -->
  <div class="overlay"></div>
  <!-- #END# Overlay For Sidebars -->
  <!-- Top Bar -->
  <nav class="navbar">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
        <a href="javascript:void(0);" class="bars"></a>
        <a class="navbar-brand" href="/">
          <img src="{{ asset('admin-template/img/logo-laraspells.png') }}" alt="" class="logo">
          <span>Aplikasi Pemesanan Ruang dan Konsumsi</span>
        </a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        @include('admin::layout.navbar-nav')
      </div>
    </div>
  </nav>
  <!-- #Top Bar -->
  <section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
      <!-- User Info -->
      @include('admin::layout.sidebar-user-info')
      
      <!-- #User Info -->
      <!-- Menu -->
      @include('admin::layout.sidebar-menu')
      <!-- #Menu -->
      <!-- Footer -->
      <div class="legal">
        <div class="copyright">
          &copy; {{date('Y')}}<a href="javascript:void(0);"> Ditama Digital</a>
        </div>
        <div class="version">
          <b>Version: </b> 2.0
        </div>
      </div>
      <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    @include('admin::layout.right-sidebar')
    <!-- #END# Right Sidebar -->
  </section>

  <section class="content">
    <div class="container-fluid">
      @yield('content')
    </div>
  </section>
  <!-- Jquery Core Js -->
  @section('scripts')
  
 
  <script src="{{ asset('vendor/admin-bsb/plugins/jquery/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/1.13.1/jquery.dataTables.min.js"></script>
<script>
  
  $(document).ready( function () {
    $('#my-table').DataTable();
} );
  $(document).ready( function () {
    $('#my-table2').DataTable();
} );
  $(document).ready( function () {
    $('#my-table3').DataTable();
} );
  $(document).ready( function () {
    $('#my-table4').DataTable();
} );

</script>
  <!-- Bootstrap Core Js -->
  <script src="{{ asset('vendor/admin-bsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

  <!-- Select Plugin Js -->
  <script src="{{ asset('vendor/admin-bsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

  <!-- Slimscroll Plugin Js -->
  <script src="{{ asset('vendor/admin-bsb/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

  <!-- Waves Effect Plugin Js -->
  <script src="{{ asset('vendor/admin-bsb/plugins/node-waves/waves.js') }}"></script>

  <!-- Custom Js -->
  <script src="{{ asset('vendor/admin-bsb/js/admin.js') }}"></script>
  
  @scripts

  <!-- Demo Js -->
  <script src="{{ asset('vendor/admin-bsb/js/demo.js') }}"></script>
  @show
  @yield('js')
  <script src="{{asset('vendor/sweetalert')}}sweetalert.all.js"></script>
</body>
</html>