@extends('front.baru.master')
@section('content')
@php
$user = App\Models\Karyawan::where('id', auth()->guard('front')->id())->first();
$avatarName = trim($user->nama);
$avatarWords = preg_split('/\s+/', $avatarName);
$avatarInitials = count($avatarWords) >= 2
    ? strtoupper(substr($avatarWords[0], 0, 1) . substr($avatarWords[1], 0, 1))
    : strtoupper(substr($avatarName, 0, 2));
$avatarColors = ['#F45B69', '#3E92CC', '#2E8B57', '#D46A6A', '#8E44AD', '#E67E22', '#16A085', '#C0392B', '#27AE60', '#D35400', '#6C5CE7', '#00A8A8'];
$avatarColor = $avatarColors[crc32($avatarName) % count($avatarColors)];
@endphp
<style>
    tr td:last-child,
    td,
    th {
        width: auto;
        white-space: nowrap;
        vertical-align: middle;
    }
    .user-profile-avatar .avatar-initials-lg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        color: #fff;
        font-size: 42px;
        font-weight: 700;
        margin: 0 auto;
    }
</style>
<div class="container">
    <h1 class="page-title">List Permohonan Kendaraan</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <aside class="user-profile-sidebar">
                <div class="user-profile-avatar text-center">
                    <span class="avatar-initials-lg" style="background-color: {{ $avatarColor }};">{{ $avatarInitials }}</span>
                    <h5>{{$user->nama}}</h5>
                    <p>{{$user->jabatan}}</p>
                </div>
                <ul class="list user-profile-nav">
                    <li>
                        <a href="{{route('profile.index')}}">
                            <i class="fa fa-user"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{route('profile.setting')}}">
                            <i class="fa fa-cog"></i>
                            Pengaturan
                        </a>
                    </li>
                    <li>
                        <a href="{{route('list-peminjaman-ruang')}}">
                            <i class="fa fa-home"></i>
                            Pemesanan Ruangan
                        </a>
                    </li>
                    <li>
                        <a href="{{route('list-permohonan-konsumsi')}}">
                            <i class="fa fa-spoon"></i>
                            Permohonan Konsumsi
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{route('list-permohonan-atk')}}">
                            <i class="fa fa-pencil"></i>
                            Permohonan ATK
                        </a>
                    </li> --}}
                    <li class="active">
                        <a href="{{route('list-permohonan-kendaraan')}}">
                            <i class="fa fa-map-marker"></i>
                            Permohonan Kendaraan
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{route('list-surat-perintah-jalan')}}">
                            <i class="fa fa-map-marker"></i>
                            Surat Perintah Jalan
                        </a>
                    </li> --}}
                </ul>
            </aside>
        </div>

        <div class="col-md-9" style="overflow-x: scroll;">
            <table id="my-table" class="table table-bordered table-striped table-booking-history">
                <thead>
                    <tr align="center">
                        <th class="text-center column-number" width="20">
                            No
                        </th>
                        <th class="column-pemohon">
                            Pemohon
                        </th>
                        <th class="column-tujuan">
                            Tujuan
                        </th>
                        <th class="column-keperluan">
                            Keperluan
                        </th>
                        <th class="column-penanggung_jawab">
                           Nama Pemesan
                        </th>
                        <th class="column-tanggal_berangkat">
                            Tanggal Berangkat
                        </th>
                        <th class="column-tanggal_kembali">
                            Tanggal Kembali
                        </th>
                        <th class="column-jam_berangkat">
                            Jam Berangkat
                        </th>
                        <th class="column-jam-kembali">
                            Jam Kembali
                        </th>
                        <th class="column-nama-driver">
                            Nama Driver
                        </th>
                        <th class="column-status_pj">
                            Status Permohon
                        </th>
                        <th class="column-status_pj">
                            Alasan Reject
                        </th>
                        <th class="text-center column-action">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagination as $i => $permohonanPemakaianKendaraan)
                    <tr align="center">
                        <td class="text-center column-number">
                            {{ $loop->iteration }}
                        </td>
                        <td class="column-pemohon">
                            {{ $permohonanPemakaianKendaraan->pemohon }}
                        </td>
                        <td class="column-tujuan">
                            {{ $permohonanPemakaianKendaraan->tujuan }}
                        </td>
                        <td class="column-keperluan">
                            {{ $permohonanPemakaianKendaraan->keperluan }}
                        </td>
                        <td class="column-penanggung_jawab">
                            {{ $permohonanPemakaianKendaraan->penanggung_jawab }}
                        </td>
                        <td class="column-tanggal_berangkat">
                            {{ $permohonanPemakaianKendaraan->tanggal_berangkat }}
                        </td>
                        <td class="column-tanggal_kembali">
                            {{ $permohonanPemakaianKendaraan->tanggal_kembali }}
                        </td>
                        <td class="column-jam_berangkat">
                            {{ $permohonanPemakaianKendaraan->jam_berangkat }}
                        </td>
                        <td class="column-jam_kembali">
                            {{ $permohonanPemakaianKendaraan->jam_kembali }}
                        </td>
                        <td class="column-nama-driver">
                            {{ $permohonanPemakaianKendaraan->spj->driver->nama_driver ?? '-' }}
                        </td>
                        <td class="column-status_pj">
                            {{ $permohonanPemakaianKendaraan->status_pj }}
                        </td>
                        <td class="column-status_pj">
                            {{ $permohonanPemakaianKendaraan->alasan_reject }}
                        </td>
                        <td class="text-center column-action" width="200">
                                @if($permohonanPemakaianKendaraan->status_pj == 'Pending')
                                {{-- <a href="{{ route('permohonankendaraan.edit', $permohonanPemakaianKendaraan->id) }}"
                                    class="btn btn-info btn-sm">Edit</a> --}}
                                <a
                                    href="#"
                                    data-id="{{$permohonanPemakaianKendaraan->id}}"
                                    class="btn btn-danger btn-sm delete-button">Delete</a>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.delete-button').on('click', function(e){
       var form = this;
       var id = $(this).attr("data-id")
       e.preventDefault();
       swal({
           title: "Apakah ingin menghapus data ? ",
           icon: "warning",
           buttons: true,
           dangerMode: true,
           })
           .then((willDelete) => {
           if (willDelete) {
               $.get("{{url('deletelistKendaraan')}}"+'/'+id, function(){
                   swal(
                       'Terhapus!',
                       'Data berhasil terhapus !',
                       'success'
                   ).then(()=>{
                       location.reload()
                   })
               });
           }
           });
   }); 
</script>

@endsection