<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PemesananRuangan;
use App\Models\PermohonanKonsumsi;
use App\Models\SuratPerintahJalan;
use App\Http\Controllers\Controller;
use App\Models\PermohonanPemakaianKendaraan;

class DashboardController extends Controller
{

    /**
     * Show the dashboard page shell. The 4 data sections (Konsumsi, Kendaraan,
     * Ruangan, SPJ) are intentionally NOT queried here — they're fetched via
     * AJAX right after the page loads, so the initial response stays fast
     * regardless of how much data each table holds.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageDashboard()
    {
        return view('admin::dashboard.dashboard');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxKonsumsi(Request $request)
    {
        $data['konsumsi'] = $this->filterKonsumsi($request)
            ->latest()
            ->paginate(10, ['*'], 'konsumsi_page')
            ->appends($request->only(['konsumsi_status', 'konsumsi_pelaksana', 'konsumsi_dari', 'konsumsi_sampai', 'konsumsi_cari']));

        return response()->json([
            'total' => $data['konsumsi']->total(),
            'html' => view('admin::dashboard.partials.konsumsi-list', $data)->render(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxKendaraan(Request $request)
    {
        $data['kendaraan'] = $this->filterKendaraan($request)
            ->latest()
            ->paginate(10, ['*'], 'kendaraan_page')
            ->appends($request->only(['kendaraan_status', 'kendaraan_dari', 'kendaraan_sampai', 'kendaraan_cari']));

        return response()->json([
            'total' => $data['kendaraan']->total(),
            'html' => view('admin::dashboard.partials.kendaraan-list', $data)->render(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRuangan(Request $request)
    {
        $data['ruangan'] = $this->filterRuangan($request)
            ->latest()
            ->paginate(10, ['*'], 'ruangan_page')
            ->appends($request->only(['ruangan_status', 'ruangan_pelaksana', 'ruangan_dari', 'ruangan_sampai', 'ruangan_cari']));

        return response()->json([
            'total' => $data['ruangan']->total(),
            'html' => view('admin::dashboard.partials.ruangan-list', $data)->render(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSpj(Request $request)
    {
        $data['spj'] = $this->filterSpj($request)
            ->latest()
            ->paginate(10, ['*'], 'spj_page')
            ->appends($request->only(['spj_status', 'spj_perjalanan', 'spj_dari', 'spj_sampai', 'spj_cari']));

        return response()->json([
            'total' => $data['spj']->total(),
            'html' => view('admin::dashboard.partials.spj-list', $data)->render(),
        ]);
    }

    /**
     * Apply status / date range / search filters for Permohonan Konsumsi.
     */
    protected function filterKonsumsi(Request $request)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'konsumsi_dari', 'konsumsi_sampai');

        return PermohonanKonsumsi::query()
            ->when($request->filled('konsumsi_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('konsumsi_status'));
            })
            ->when($request->filled('konsumsi_pelaksana'), function ($query) use ($request) {
                $query->where('status_pelaksana', $request->get('konsumsi_pelaksana'));
            })
            ->when($dari, function ($query) use ($dari) {
                $query->where('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->where('tanggal_selesai', '<=', $sampai);
            })
            ->when($request->filled('konsumsi_cari'), function ($query) use ($request) {
                $query->where('kegiatan', 'like', '%' . $request->get('konsumsi_cari') . '%');
            });
    }

    /**
     * Apply status / date range / search filters for Permohonan Pemakaian Kendaraan.
     */
    protected function filterKendaraan(Request $request)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'kendaraan_dari', 'kendaraan_sampai');

        return PermohonanPemakaianKendaraan::query()
            ->when($request->filled('kendaraan_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('kendaraan_status'));
            })
            ->when($dari, function ($query) use ($dari) {
                $query->where('tanggal_berangkat', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->where('tanggal_kembali', '<=', $sampai);
            })
            ->when($request->filled('kendaraan_cari'), function ($query) use ($request) {
                $keyword = '%' . $request->get('kendaraan_cari') . '%';
                $query->where(function ($q) use ($keyword) {
                    $q->where('keperluan', 'like', $keyword)
                        ->orWhere('tujuan', 'like', $keyword);
                });
            });
    }

    /**
     * Apply status / date range / search filters for Pemesanan Ruangan.
     */
    protected function filterRuangan(Request $request)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'ruangan_dari', 'ruangan_sampai');

        return PemesananRuangan::query()
            ->when($request->filled('ruangan_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('ruangan_status'));
            })
            ->when($request->filled('ruangan_pelaksana'), function ($query) use ($request) {
                $query->where('status_pelaksana', $request->get('ruangan_pelaksana'));
            })
            ->when($dari, function ($query) use ($dari) {
                $query->where('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->where('tanggal_selesai', '<=', $sampai);
            })
            ->when($request->filled('ruangan_cari'), function ($query) use ($request) {
                $query->where('nama_acara', 'like', '%' . $request->get('ruangan_cari') . '%');
            });
    }

    /**
     * Apply status / date range / search filters for Surat Perintah Jalan.
     */
    protected function filterSpj(Request $request)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'spj_dari', 'spj_sampai');

        return SuratPerintahJalan::query()
            ->when($request->filled('spj_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('spj_status'));
            })
            ->when($request->filled('spj_perjalanan'), function ($query) use ($request) {
                $query->where('status_perjalanan', $request->get('spj_perjalanan'));
            })
            ->when($dari, function ($query) use ($dari) {
                $query->where('tanggal_berangkat', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->where('tanggal_kembali', '<=', $sampai);
            })
            ->when($request->filled('spj_cari'), function ($query) use ($request) {
                $query->where('tujuan', 'like', '%' . $request->get('spj_cari') . '%');
            });
    }

    /**
     * Read a "dari"/"sampai" date pair from the request, swapping them if
     * reversed so a mistyped range never silently produces an empty result.
     *
     * @return array{0: ?string, 1: ?string}
     */
    protected function normalizedDateRange(Request $request, $fromKey, $toKey)
    {
        $dari = $request->filled($fromKey) ? $request->get($fromKey) : null;
        $sampai = $request->filled($toKey) ? $request->get($toKey) : null;

        if ($dari && $sampai && $dari > $sampai) {
            list($dari, $sampai) = [$sampai, $dari];
        }

        return [$dari, $sampai];
    }
}
