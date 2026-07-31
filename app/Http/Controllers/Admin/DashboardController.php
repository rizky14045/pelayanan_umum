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
        $pelaksana = $this->effectiveValue($request, 'konsumsi_pelaksana', 'Belum Terlaksana');

        $data['konsumsi'] = $this->filterKonsumsi($request, $pelaksana)
            ->latest()
            ->paginate(10, ['*'], 'konsumsi_page')
            ->appends($request->only(['konsumsi_status', 'konsumsi_pelaksana', 'konsumsi_dari', 'konsumsi_sampai', 'konsumsi_cari']));
        $data['konsumsiPelaksana'] = $pelaksana;

        return response()->json([
            'total' => PermohonanKonsumsi::where('status_pelaksana', 'Belum Terlaksana')->count(),
            'html' => view('admin::dashboard.partials.konsumsi-list', $data)->render(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxKendaraan(Request $request)
    {
        $status = $this->effectiveValue($request, 'kendaraan_status', 'Pending');

        $data['kendaraan'] = $this->filterKendaraan($request, $status)
            ->latest()
            ->paginate(10, ['*'], 'kendaraan_page')
            ->appends($request->only(['kendaraan_status', 'kendaraan_dari', 'kendaraan_sampai', 'kendaraan_cari']));
        $data['kendaraanStatus'] = $status;

        return response()->json([
            'total' => PermohonanPemakaianKendaraan::where('status_pj', 'Pending')->count(),
            'html' => view('admin::dashboard.partials.kendaraan-list', $data)->render(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRuangan(Request $request)
    {
        $pelaksana = $this->effectiveValue($request, 'ruangan_pelaksana', 'Belum Terlaksana');

        $data['ruangan'] = $this->filterRuangan($request, $pelaksana)
            ->latest()
            ->paginate(10, ['*'], 'ruangan_page')
            ->appends($request->only(['ruangan_status', 'ruangan_pelaksana', 'ruangan_dari', 'ruangan_sampai', 'ruangan_cari']));
        $data['ruanganPelaksana'] = $pelaksana;

        return response()->json([
            'total' => PemesananRuangan::where('status_pelaksana', 'Belum Terlaksana')->count(),
            'html' => view('admin::dashboard.partials.ruangan-list', $data)->render(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSpj(Request $request)
    {
        $perjalanan = $this->effectiveValue($request, 'spj_perjalanan', 'Belum Sampai');

        $data['spj'] = $this->filterSpj($request, $perjalanan)
            ->latest()
            ->paginate(10, ['*'], 'spj_page')
            ->appends($request->only(['spj_status', 'spj_perjalanan', 'spj_dari', 'spj_sampai', 'spj_cari']));
        $data['spjPerjalanan'] = $perjalanan;

        return response()->json([
            'total' => SuratPerintahJalan::where('status_perjalanan', 'Belum Sampai')->count(),
            'html' => view('admin::dashboard.partials.spj-list', $data)->render(),
        ]);
    }

    /**
     * Apply status / date range / search filters for Permohonan Konsumsi.
     *
     * @param string $pelaksana Resolved status_pelaksana filter value ('' means "semua").
     */
    protected function filterKonsumsi(Request $request, $pelaksana)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'konsumsi_dari', 'konsumsi_sampai');

        return PermohonanKonsumsi::query()
            ->when($request->filled('konsumsi_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('konsumsi_status'));
            })
            ->when($pelaksana !== '' && $pelaksana !== null, function ($query) use ($pelaksana) {
                $query->where('status_pelaksana', $pelaksana);
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
     *
     * @param string $status Resolved status_pj filter value ('' means "semua").
     */
    protected function filterKendaraan(Request $request, $status)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'kendaraan_dari', 'kendaraan_sampai');

        return PermohonanPemakaianKendaraan::query()
            ->when($status !== '' && $status !== null, function ($query) use ($status) {
                $query->where('status_pj', $status);
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
     *
     * @param string $pelaksana Resolved status_pelaksana filter value ('' means "semua").
     */
    protected function filterRuangan(Request $request, $pelaksana)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'ruangan_dari', 'ruangan_sampai');

        return PemesananRuangan::query()
            ->when($request->filled('ruangan_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('ruangan_status'));
            })
            ->when($pelaksana !== '' && $pelaksana !== null, function ($query) use ($pelaksana) {
                $query->where('status_pelaksana', $pelaksana);
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
     *
     * @param string $perjalanan Resolved status_perjalanan filter value ('' means "semua").
     */
    protected function filterSpj(Request $request, $perjalanan)
    {
        list($dari, $sampai) = $this->normalizedDateRange($request, 'spj_dari', 'spj_sampai');

        return SuratPerintahJalan::query()
            ->when($request->filled('spj_status'), function ($query) use ($request) {
                $query->where('status_pj', $request->get('spj_status'));
            })
            ->when($perjalanan !== '' && $perjalanan !== null, function ($query) use ($perjalanan) {
                $query->where('status_perjalanan', $perjalanan);
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
     * Resolve a filter's active value: whatever the request explicitly sent
     * (including an empty string, meaning the user picked "Semua"), or the
     * given default when the key is absent from the request entirely (i.e.
     * the very first, un-filtered load of a dashboard section).
     */
    protected function effectiveValue(Request $request, $key, $default)
    {
        return $request->has($key) ? $request->get($key) : $default;
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
