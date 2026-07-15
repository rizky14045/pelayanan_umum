<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelayanan Umum</title>
    <link rel="stylesheet" href="{{asset('vendor/dashboard')}}/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
    body {
        background-repeat: repeat;
        display: flex;
        height: 100%;
        flex-direction: column;
        min-height: 100vh;
    }
    .content {
        flex: 1;
    }
    .footer {
        /* Add styles for the footer here */
    }
    .status-perjalanan-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        background-color: #FFC107;
        color: #212529;
        font-weight: bold;
        font-size: 14px;
        margin-top: 6px;
    }

    /* Text-only card, responsive for portrait/narrow screens */
    .item-room {
        width: 100%;
    }
    .room-desc-full {
        background-color: white;
        padding: 18px 30px;
        border-radius: 10px;
        width: 100%;
    }
    .room-desc-header,
    .room-desc-info {
        white-space: normal;
        overflow-wrap: anywhere;
        word-break: break-word;
    }
    .room-desc-info p {
        margin-bottom: 8px;
    }

    @media (orientation: portrait), (max-width: 900px) {
        .room-desc-full {
            padding: 14px 16px;
        }
        .room-desc-header {
            padding-left: 20px;
            font-size: 1.1em;
        }
        .room-desc-info {
            padding-left: 20px;
            font-size: 0.9em;
        }
        .header-body h3 {
            font-size: 1.3em;
        }
    }
</style>
</head>

<body style="background-image: url({{asset('background.jpg')}})">
    <div class="container content">
        <div class="container-fluid">
            <!-- header -->
            <nav class="navbar p-4" center>
                <div class="container-fluid justify-content-center">
                    <img src="{{asset('vendor/dashboard')}}/images/logo-pln.png" alt="logo">
                </div>
            </nav>

            <!-- As a heading -->
            <nav class="navbar">
                <div class="header-body container-fluid text-center fs-4 lh-1 row justify-content-center">
                    <h3>Vehicle Trip Management<br> PT PLN Nusantara Power</h3>
                    <br>
                    <h3>Unit Pembangkitan Muara Karang</h3>
                </div>
            </nav>

            <div class="date">
                <p>Last Update : <div id="txt" class="clock" onload="startime()"></div>
                </p>

            </div>
            <div class="container-fluid">
                @php
                    function indonesian_date_kendaraan($date) {
                        $indo_month = array(
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember',
                        );
                        $indo_dayname = array(
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => "Jumat",
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu',
                        );
                        $dayname = date('l',strtotime($date));
                        $date_format = 'l, j F Y';
                        $date_string = date($date_format, strtotime($date));
                        $date_string = str_replace(array_keys($indo_month), array_values($indo_month), $date_string);
                        return str_replace($dayname, $indo_dayname[$dayname], $date_string);
                    }
                @endphp
                @forelse($kendaraan as $item)
                <hr class="mt-3">
                <div class="row">
                    <div class="item-room">
                        <div class="room-desc-full">
                            <h4 class="room-desc-header">
                                {{ $item->nama_kendaraan ?? 'Tanpa Kendaraan' }}
                                @if($item->no_pol) &ndash; {{ $item->no_pol }} @endif
                            </h4>
                            <div class="room-desc-info">
                                <p><strong>Tujuan :</strong> {{ $item->tujuan }}</p>
                                @if($item->jenis_perjalanan)
                                <p><strong>Jenis Perjalanan :</strong> {{ $item->jenis_perjalanan }}</p>
                                @endif
                                <p><img src="{{asset('vendor/dashboard')}}/images/icon-user.png" alt=""> Pengemudi : {{ $item->nama_driver ?? '-' }}</p>
                                <p><img src="{{asset('vendor/dashboard')}}/images/icon-calendar.png" alt=""> {{ indonesian_date_kendaraan($item->tanggal_berangkat) }} - {{ indonesian_date_kendaraan($item->tanggal_kembali) }}</p>
                                <p><img src="{{asset('vendor/dashboard')}}/images/icon-clock.png" alt=""> {{ $item->jam_berangkat }} - {{ $item->jam_kembali }}</p>
                                <span class="status-perjalanan-badge">Dalam Perjalanan</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <hr class="mt-3">
                <h5 class="text-center text-white mt-4">Tidak ada perjalanan kendaraan yang sedang berlangsung</h5>
                @endforelse
            </div>
        </div>
        <hr>
    </div>

    </div>
    <div class="footer">
        <h6 class="text-center">
            <marquee behavior="" direction="" scrollamount="10">
                SELAMAT DATANG DI PT. PLN NUSANTARA POWER UNIT PEMBANGKITAN MUARA KARANG
            </marquee>
        </h6>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        const days = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        function startTime() {
            const today = new Date();
            let h = checkTime(today.getHours());
            let m = checkTime(today.getMinutes());
            let s = checkTime(today.getSeconds());
            let day = days[today.getDay()];
            let date = checkTime(today.getDate());
            let month = checkTime(today.getMonth() + 1);
            let year = today.getFullYear();
            document.getElementById('txt').innerHTML = day + ", " + date + "/" + month + "/" + year + " " + h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        startTime();
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        setInterval(function() {
          location.reload();
        }, 60 * 60 * 1000);
      });
    </script>

</body>

</html>
