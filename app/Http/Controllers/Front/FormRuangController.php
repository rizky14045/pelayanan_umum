<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\RuanganMail;
use App\Models\Karyawan;
use App\Models\Notification;
use App\Models\PemesananRuangan;
use App\Models\PermohonanKonsumsi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormRuangController extends Controller
{

    public function submit(Request $req)
    {
        if ($req->get('konsumsi') == 'Ya') {
            $req->validate([
                'konsumsi_jenis_konsumsi' => 'required',
                'konsumsi_jenis_peserta' => 'required|in:Internal,Internal VIP,External,External VIP',
                'konsumsi_attachment' => 'required|file|max:2048',
            ]);
        }

        $pemohon = Karyawan::where('nama', $req->get('pemohon'))->first();
        dd($req->all());
        if($req->hasFile('attachment')){
            $file= $req->file('attachment');
            $image_name = $file->getClientOriginalName();
            $file->move(public_path('pemesanan_ruangan/attachment/'),$image_name);

        }else{
            $image_name = null;
        }

        $date = explode(' - ',$req->rangedate);

        $pemesananRuangan = new PemesananRuangan;
        $pemesananRuangan->no_pemesanan_ruangan = $req->get('no_pemesanan_ruangan');
        $pemesananRuangan->tanggal = $date[0];
        $pemesananRuangan->tanggal_selesai =  $date[1];
        $pemesananRuangan->pemohon = $req->get('pemohon');
        $pemesananRuangan->pemohon_id = $req->get('pemohon_id');
        $pemesananRuangan->nama_acara =$req->get('nama_acara');
        $pemesananRuangan->nama_pemesan =$req->get('nama_pemesan');
        $pemesananRuangan->waktu_awal =strtotime($req->get('waktu_awal'));
        $pemesananRuangan->waktu_akhir =strtotime($req->get('waktu_akhir'));
        $pemesananRuangan->jumlah_peserta =$req->get('jumlah_peserta');
        $pemesananRuangan->id_ruang = $req->get('id_ruang');
        $pemesananRuangan->attachment = $image_name;
        $pemesananRuangan->keterangan =$req->get('keterangan');
        $pemesananRuangan->design_ruangan =$req->get('design_ruangan');
        $pemesananRuangan->status_pj = 'Pending';
        $pemesananRuangan->status_supervisor = 'Pending';
        $pemesananRuangan->status_manajer = 'Pending';
        if (!empty($req->get('subruang'))) {
            $pemesananRuangan->child_ruang = implode(";", $req->get('subruang'));
        } else {
            $pemesananRuangan->child_ruang = "";
        }
        $pemesananRuangan->save();

        $notifications = new Notification;
        $notifications->pemesanan_ruangan_id = $pemesananRuangan->id;
        $notifications->status = false;
        $notifications->save();

        $data = [
            'no_pemesanan_ruangan' => $req->get('no_pemesanan_ruangan'),
            'tanggal' => $date[0],
            'tanggal_selesai' =>  $date[1],
            'pemohon' => $req->get('pemohon'),
            'nama_acara' =>$req->get('nama_acara'),
            'nama_ruang' => $req->get('nama_ruang'),
            'waktu_awal' =>$req->get('waktu_awal'),
            'waktu_akhir' =>$req->get('waktu_akhir'),
            'jumlah_peserta' =>$req->get('jumlah_peserta'),
            'id_ruang' => $req->get('id_ruang'),
            'attachment' => $image_name,
            'keterangan' =>$req->get('keterangan'),
            'design_ruangan' =>$req->get('design_ruangan'),
        ];
        $emailTo = User::where('role','SuperAdmin')->pluck('email')->toArray();
        Mail::to($emailTo)->send(new RuanganMail($data));

        if ($req->get('konsumsi') == 'Ya') {
            $konsumsiFile = $req->file('konsumsi_attachment');
            $konsumsiFileName = $konsumsiFile->getClientOriginalName();
            $konsumsiFile->move(public_path('pemesanan_ruangan/attachment/'), $konsumsiFileName);

            $permohonanKonsumsi = new PermohonanKonsumsi;
            // nomor() relation on PermohonanKonsumsi resolves via PemesananRuangan.id, not the PR-code string
            $permohonanKonsumsi->no_permohonan_konsumsi = $pemesananRuangan->id;
            $permohonanKonsumsi->tanggal = $date[0];
            $permohonanKonsumsi->tanggal_selesai = $date[1];
            $permohonanKonsumsi->jumlah = $req->get('konsumsi_jumlah');
            $permohonanKonsumsi->sumber_dana = $req->get('konsumsi_sumber_dana');
            $permohonanKonsumsi->kegiatan = $req->get('nama_acara');
            $permohonanKonsumsi->jenis_konsumsi = $req->get('konsumsi_jenis_konsumsi');
            $permohonanKonsumsi->jenis_peserta = $req->get('konsumsi_jenis_peserta');
            $permohonanKonsumsi->jumlah_peserta = $req->get('jumlah_peserta');
            $permohonanKonsumsi->pemohon = $req->get('pemohon');
            $permohonanKonsumsi->pemohon_id = $req->get('pemohon_id');
            $permohonanKonsumsi->status_pj = 'Pending';
            $permohonanKonsumsi->status_supervisor = 'Pending';
            $permohonanKonsumsi->status_manajer = 'Pending';
            $permohonanKonsumsi->keterangan = $req->get('konsumsi_keterangan');
            $permohonanKonsumsi->attachment = $konsumsiFileName;
            $permohonanKonsumsi->save();

            $konsumsiNotification = new Notification;
            $konsumsiNotification->permohonan_konsumsi_id = $permohonanKonsumsi->id;
            $konsumsiNotification->status = false;
            $konsumsiNotification->save();
        }

        // alert()->success('Berhasil', 'Data berhasil dibuat');
        return redirect()->route('list-peminjaman-ruang');
    }
}
