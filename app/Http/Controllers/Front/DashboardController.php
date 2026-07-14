<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananRuangan;
use App\Models\SuratPerintahJalan;
use App\Models\Ruang;
use App\Models\Karyawan;
use App\User;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{

public function dashboard() {
    $today = Date('Y-m-d');
    $ruangan = PemesananRuangan::join('ruang', 'pemesanan_ruangan.id_ruang', 'ruang.id')
    ->where('status_pj', 'Approved')
    ->where('status_pelaksana','Belum Terlaksana')
    ->where('tanggal', '<=', $today)
    ->where(function($query) use($today) {
        $query->where('tanggal_selesai', '>=', $today)
            ->orWhereNull('tanggal_selesai');
    })
    ->select('pemesanan_ruangan.nama_acara', 'pemesanan_ruangan.jumlah_peserta',
    'pemesanan_ruangan.tanggal', 'pemesanan_ruangan.tanggal_selesai', 'pemesanan_ruangan.waktu_awal', 'pemesanan_ruangan.waktu_akhir', 'ruang.nama_ruang', 'ruang.foto_ruang')
    ->orderBy('pemesanan_ruangan.tanggal','ASC')
    ->take(8)->get();
    $data['ruangan'] = $ruangan;
    return view('dashboard.dashboard', $data);
}

public function dashboardKendaraan() {
    $kendaraan = SuratPerintahJalan::join('permohonan_pemakaian_kendaraan', 'surat_perintah_jalan.id_permohonan_pemakaian_kendaraan', 'permohonan_pemakaian_kendaraan.id')
    ->leftJoin('kendaraan', 'surat_perintah_jalan.kendaraan_id', 'kendaraan.id')
    ->leftJoin('driver', 'surat_perintah_jalan.driver_id', 'driver.id')
    ->where('permohonan_pemakaian_kendaraan.status_pj', 'Approved')
    ->where(function($query) {
        $query->where('surat_perintah_jalan.status_perjalanan', '!=', 'Sudah Sampai')
            ->orWhereNull('surat_perintah_jalan.status_perjalanan');
    })
    ->select(
        'surat_perintah_jalan.tujuan',
        'surat_perintah_jalan.tanggal_berangkat', 'surat_perintah_jalan.tanggal_kembali',
        'surat_perintah_jalan.jam_berangkat', 'surat_perintah_jalan.jam_kembali',
        'surat_perintah_jalan.status_perjalanan',
        'kendaraan.nama_kendaraan', 'kendaraan.no_pol',
        'driver.nama_driver',
        'permohonan_pemakaian_kendaraan.jenis_perjalanan'
    )
    ->orderBy('surat_perintah_jalan.tanggal_berangkat', 'ASC')
    ->take(8)->get();
    $data['kendaraan'] = $kendaraan;
    return view('dashboard.dashboard-kendaraan', $data);
}

}