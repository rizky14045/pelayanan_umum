<!DOCTYPE HTML>
<html>

<head>
    <title>PT PLN Nusantara Power Unit Pembangkitan Muara Karang</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <link href='//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{asset('vendor/frontend')}}/css/bootstrap.css">
    <link rel="stylesheet" href="{{asset('vendor/frontend')}}/css/font-awesome.css">
    <link rel="stylesheet" href="{{asset('vendor/frontend')}}/css/icomoon.css">
    <link rel="stylesheet" href="{{asset('vendor/frontend')}}/css/styles.css">
    <link rel="stylesheet" href="{{asset('vendor/frontend')}}/css/mystyles.css">
    <link rel="stylesheet" href="{{asset('vendor/frontend')}}/css/switcher.css" />
    @styles()

    <style>
        .header-top { background: #1F5C85 !important; }
        ul.slimmenu li.active>a,
        ul.slimmenu li:hover>a { background: #1F5C85 !important; color: #fff !important; }
        .top-user-area-avatar .avatar-initials {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            vertical-align: middle;
            margin-right: 6px;
        }
    </style>

    <link rel="icon" href="{{asset('vendor/home')}}/images/new-logo.ico">

    <script src="{{asset('vendor/frontend')}}/js/modernizr.js"></script>
</head>

<body>

    <div class="global-wrap">
        <header id="main-header">
            <div class="header-top">
                <div class="container p-1">
                    <div class="row">
                        <div class="col-md-3">
                                <a class="logo" href="{{url('')}}">
                                    <img src="{{asset('logo/new-logo.png')}}" alt="" height="35" width="35" style="margin-right: auto; margin-left:auto;">
                                </a>
                        </div>
                        <div class="col-md-9">
                            <div class="top-user-area clearfix">
                                <ul class="top-user-area-list list list-horizontal list-border">
                                    <li class="top-user-area-avatar">
                                        <a href="{{route('profile.index')}}">
                                            @php
                                            $user = App\Models\Karyawan::where('id',
                                            auth()->guard('front')->id())->first();
                                            $avatarName = trim($user->nama);
                                            $avatarWords = preg_split('/\s+/', $avatarName);
                                            $avatarInitials = count($avatarWords) >= 2
                                                ? strtoupper(substr($avatarWords[0], 0, 1) . substr($avatarWords[1], 0, 1))
                                                : strtoupper(substr($avatarName, 0, 2));
                                            $avatarColors = ['#F45B69', '#3E92CC', '#2E8B57', '#D46A6A', '#8E44AD', '#E67E22', '#16A085', '#C0392B', '#27AE60', '#D35400', '#6C5CE7', '#00A8A8'];
                                            $avatarColor = $avatarColors[crc32($avatarName) % count($avatarColors)];
                                            @endphp
                                            <span class="avatar-initials" style="background-color: {{ $avatarColor }};">{{ $avatarInitials }}</span>Hi, {{$user->nama}}
                                        </a>
                                    </li>
                                    <li><a href="{{route('logout')}}">Keluar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav">
                <ul class="slimmenu" id="slimmenu">
                    <li><a href="{{url('/')}}">Beranda</a></li>
                    <li><a href="{{route('pemesananruangan')}}">Pemesanan Ruangan</a></li>
                    <li><a href="{{route('permohonankonsumsi')}}">Permohonan Konsumsi</a></li>
                    {{-- <li><a href="{{route('permohonanatk')}}">Permohonan ATK</a></li> --}}
                    <li><a href="{{route('permohonankendaraan')}}">Peminjaman Kendaraan</a></li>
                    <li><a href="{{route('layoutdesign')}}">Layout Design & Ruangan</a></li>
                </ul>
            </div>
        </header>

        @yield('content')

        <footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="center">
                        <p class="text-center">{{date('Y')}} - Aplikasi Pelayanan Umum  PT PLN Nusantara Power Unit Pembangkitan Muara Karang By Ditamadigital</p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{asset('vendor/frontend')}}/js/jquery.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/bootstrap.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/slimmenu.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/bootstrap-datepicker.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/bootstrap-timepicker.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/nicescroll.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/dropit.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/ionrangeslider.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/icheck.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/fotorama.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/typeahead.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/card-payment.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/magnific.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/owl-carousel.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/fitvids.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/tweet.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/countdown.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/gridrotator.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/custom.js"></script>
        <script src="{{asset('vendor/frontend')}}/js/switcher.js"></script>
        <script src="{{asset('vendor/sweetalert/')}}sweetalert.all.js"></script>
      
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $(document).ready( function () {
                $('#my-table').DataTable();
            } );
        </script>
        <script>
            $('input[name="range_date"]').daterangepicker({
                
                locale: {
                            format: 'YYYY-MM-DD',
                            }
            });
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSrThpCRzBbdGhfA27I6T4H-JkzEl4zk0&libraries=places"></script>
        @yield('script')
        @scripts()
    </div>
</body>

</html>