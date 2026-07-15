<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display all notifications scoped to the current user's role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Semua Notifikasi';
        $data['notifications'] = $this->scopedQuery()->latest()->get();

        return view('admin::notification.index', $data);
    }

    /**
     * Mark every notification in scope as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllRead()
    {
        $this->scopedQuery()->where('status', false)->update(['status' => true]);

        return redirect()->route('admin::notifications.index')->with('info', 'Semua notifikasi ditandai sudah dibaca');
    }

    /**
     * Query notifications scoped to the current user's role.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopedQuery()
    {
        $query = Notification::query();

        if (Auth::user()->role == 'adminruang') {
            $query->where(function ($q) {
                $q->whereNotNull('pemesanan_ruangan_id')
                    ->orWhereNotNull('permohonan_konsumsi_id');
            });
        } elseif (Auth::user()->role == 'adminkendaraan') {
            $query->whereNotNull('permohonan_pemakaian_kendaraan_id');
        }

        return $query;
    }
}
