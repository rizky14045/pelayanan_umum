<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\KonsumsiMail;
use App\Models\Karyawan;
use App\Models\Notification;
use App\Models\PermohonanKonsumsi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class FormKonsumsiController extends Controller
{
    
    public function submit(Request $req)
    {
        $req->validate([
            'jenis_peserta' => 'required|in:Internal,Internal VIP,External,External VIP',
        ]);

        $file= $req->file('attachment');
        $image_name = $file->getClientOriginalName();
        $file->move(public_path('pemesanan_ruangan/attachment/'),$image_name);

        $pemohon = Karyawan::where('nama', $req->get('pemohon'))->first();
        // dd($pemohon);
        $permohonanKonsumsi = new PermohonanKonsumsi;
        $permohonanKonsumsi->no_permohonan_konsumsi = str_replace("PR", "PK", $req->get('no_permohonan_konsumsi'));
        $permohonanKonsumsi->tanggal = $req->get('tanggal');
        $permohonanKonsumsi->tanggal_selesai = $req->get('tanggal_selesai');
        $permohonanKonsumsi->jumlah =$req->get('jumlah');
        $permohonanKonsumsi->sumber_dana =$req->get('sumber_dana');
        $permohonanKonsumsi->kegiatan =$req->get('kegiatan');
        $permohonanKonsumsi->jenis_konsumsi =$req->get('jenis_konsumsi');
        $permohonanKonsumsi->jenis_peserta =$req->get('jenis_peserta');
        $permohonanKonsumsi->jumlah_peserta =$req->get('jumlah_peserta');
        $permohonanKonsumsi->pemohon =$req->get('pemohon');
        $permohonanKonsumsi->pemohon_id =$req->get('pemohon_id');
        $permohonanKonsumsi->status_pj ='Pending';
        $permohonanKonsumsi->status_supervisor = 'Pending';
        $permohonanKonsumsi->status_manajer = 'Pending';
        $permohonanKonsumsi->keterangan =$req->get('keterangan');
        $permohonanKonsumsi->attachment = $image_name;
        $permohonanKonsumsi->save();

        $data = [
            'no_permohonan_konsumsi' => str_replace("PR", "PK", $req->get('no_permohonan_konsumsi')),
            'tanggal' => $req->get('tanggal'),
            'tanggal_selesai' => $req->get('tanggal_selesai'),
            'jumlah' =>$req->get('jumlah'),
            'sumber_dana' =>$req->get('sumber_dana'),
            'kegiatan' =>$req->get('kegiatan'),
            'jenis_konsumsi' =>$req->get('jenis_konsumsi'),
            'jenis_peserta' =>$req->get('jenis_peserta'),
            'jumlah_peserta' =>$req->get('jumlah_peserta'),
            'pemohon' =>$req->get('pemohon'),
            'keterangan' =>$req->get('keterangan'),
            'ruang' =>$req->get('ruang'),
        ];
        $emailTo = User::where('role','SuperAdmin')->pluck('email')->toArray();
        Mail::to($emailTo)->send(new KonsumsiMail($data));
        $notifications = new Notification;
        $notifications->permohonan_konsumsi_id = $permohonanKonsumsi->id;
        $notifications->status = false;
        $notifications->save();
        
        // alert()->success('Berhasil', 'Data berhasil dibuat');
        return redirect()->route('list-permohonan-konsumsi');
    }
}
