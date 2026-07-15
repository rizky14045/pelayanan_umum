<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\KendaraanMail;
use App\Models\Notification;
use App\Models\PermohonanPemakaianKendaraan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormPermohonanKendaraanController extends Controller
{
    
    public function submit(Request $req)
    {
        $permohonan = new PermohonanPemakaianKendaraan;
        $date = explode(' - ',$req->range_date);
        $data = [
            'tujuan' => $req->get('tujuan'),
            'keperluan' => $req->get('keperluan'),
            'jenis_perjalanan' => $req->get('jenis_perjalanan'),
            'penanggung_jawab' => $req->get('penanggung_jawab'),
            'tanggal_berangkat' => $date[0],
            'tanggal_kembali' => $date[1],
            'jam_berangkat' => $req->get('jam_berangkat'),
            'jam_kembali' => $req->get('jam_kembali'),
            'pemohon' => $req->get('pemohon'),
            'keterangan' => $req->get('keterangan'),

        ];
        $emailTo = User::where('role','SuperAdmin')->pluck('email')->toArray();
        Mail::to($emailTo)->send(new KendaraanMail($data));
        $this->save($req, $permohonan);
        
        // alert()->success('Berhasil', 'Data berhasil dibuat');
        return redirect()
            ->route('list-permohonan-kendaraan')
            ->with('info', "Data permohonan pemakaian kendaraan telah disimpan.");
    }

    public function update(Request $req, $id)
    {
        $permohonan = PermohonanPemakaianKendaraan::findOrFail($id);

        $this->save($req, $permohonan);

        return redirect()
            ->route('list-permohonan-kendaraan')
            ->with('info', "Data permohonan pemakaian kendaraan telah disimpan.");
    }

    public function destroy(Request $req, $id)
    {
        $permohonan = PermohonanPemakaianKendaraan::findOrFail($id);
        $permohonan->delete();

        return redirect()
            ->route('list-permohonan-kendaraan')
            ->with('info', "Data permohonan pemakaian kendaraan telah dihapus.");
    }

    protected function save(Request $req, PermohonanPemakaianKendaraan $permohonan)
    {
        $date = explode(' - ',$req->range_date);
        $req->validate([
            'jenis_perjalanan' => 'required|in:Pergi Saja,Pulang Pergi',
        ]);
        // $req->validate([
        //     'pemohon' => 'required',
        //     'tujuan' => 'required',
        //     // 'latlng' => 'required',
        //     'keperluan' => 'required',
        //     'penanggung_jawab' => 'required',
        //     'tanggal_berangkat' => 'required',
        //     'tanggal_kembali' => 'required',
        //     'jam_berangkat' => 'required',
        //     'jam_kembali' => 'required',
        // ]);

        $permohonan->pemohon =$req->get('pemohon');
        $permohonan->pemohon_id =$req->get('pemohon_id');
        $permohonan->latlng =$req->get('latlng');
        $permohonan->tujuan =$req->get('tujuan');
        $permohonan->keperluan =$req->get('keperluan');
        $permohonan->jenis_perjalanan =$req->get('jenis_perjalanan');
        $permohonan->penanggung_jawab =$req->get('penanggung_jawab');
        $permohonan->tanggal_berangkat =$date[0];
        $permohonan->tanggal_kembali =$date[1];
        $permohonan->jam_berangkat =$req->get('jam_berangkat');
        $permohonan->jam_kembali =$req->get('jam_kembali');
        $permohonan->status_pj = 'Pending';
        $permohonan->keterangan = $req->get('keterangan');
        $permohonan->save();
        
        $notifications = new Notification;
        $notifications->permohonan_pemakaian_kendaraan_id = $permohonan->id;
        $notifications->status = false;
        $notifications->save();
     
    }

    protected function guard()
    {
        return auth()->guard('front');
    }
}
