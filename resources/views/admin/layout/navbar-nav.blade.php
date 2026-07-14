@php
  $notifQuery = \App\Models\Notification::where('status', false);
  if (Auth::user()->role == 'adminruang') {
    $notifQuery->where(function ($q) {
      $q->whereNotNull('pemesanan_ruangan_id')
        ->orWhereNotNull('permohonan_konsumsi_id');
    });
  } elseif (Auth::user()->role == 'adminkendaraan') {
    $notifQuery->whereNotNull('permohonan_pemakaian_kendaraan_id');
  }
  $notifications = in_array(Auth::user()->role, ['superadmin', 'adminruang', 'adminkendaraan'])
    ? $notifQuery->latest()->take(8)->get()
    : collect();
  $notifCount = $notifications->count();
@endphp
<style>
  .notification-list{
    display: flex;
    align-items: center;
  }
  .notification-list .icon-circle{ flex-shrink: 0; }
  .dropdown-menu .body{ max-height: 360px; overflow-y: auto; }
  .dropdown-menu .menu-info p{ margin: 0; font-size: 11px; color: #A6AAB8; }
  .dropdown-menu .menu-info small{ display:block; font-size: 11px; color: #A6AAB8; margin-top: 2px; }
</style>
<ul class="nav navbar-nav navbar-right">
  {{-- notif --}}
  @if (in_array(Auth::user()->role, ['superadmin', 'adminruang', 'adminkendaraan']))
    <li class="dropdown">
      <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
          <i class="material-icons">notifications</i>
          <span class="label-count" style="background-color:white;color:red">{{ $notifCount }}</span>
      </a>
      <ul class="dropdown-menu">
          <li class="header">NOTIFICATIONS</li>
          <li class="body">
              <ul class="menu">
                @forelse ($notifications as $item)
                  @if ($item->pemesanan_ruangan_id && $item->ruangan)
                    <li>
                      <a href="{{ route('admin::pemesanan-ruangan.detail', ['id' => $item->pemesanan_ruangan_id]) }}" class="notification-list">
                          <div class="icon-circle" style="background-color: #F675A8 !important;">
                              <i class="material-icons">meeting_room</i>
                          </div>
                          <div class="menu-info">
                              <h4>{{ $item->ruangan->no_pemesanan_ruangan }}</h4>
                              <p>Pemesanan Ruangan</p>
                              <small>{{ $item->created_at->diffForHumans() }}</small>
                          </div>
                      </a>
                  </li>
                  @elseif ($item->permohonan_konsumsi_id && $item->konsumsi)
                    <li>
                      <a href="{{ route('admin::permohonan-konsumsi.detail', ['id' => $item->permohonan_konsumsi_id]) }}" class="notification-list">
                          <div class="icon-circle" style="background-color: #2C7BE5 !important;">
                              <i class="material-icons">fastfood</i>
                          </div>
                          <div class="menu-info">
                              <h4>{{ $item->konsumsi->pemohon }} &ndash; {{ $item->konsumsi->kegiatan }}</h4>
                              <p>Permohonan Konsumsi</p>
                              <small>{{ $item->created_at->diffForHumans() }}</small>
                          </div>
                      </a>
                      </li>
                  @elseif ($item->permohonan_pemakaian_kendaraan_id && $item->kendaraan)
                    <li>
                      <a href="{{ route('admin::permohonan-pemakaian-kendaraan.detail', ['id' => $item->permohonan_pemakaian_kendaraan_id]) }}" class="notification-list">
                          <div class="icon-circle" style="background-color: #15803D !important;">
                              <i class="material-icons">directions_car</i>
                          </div>
                          <div class="menu-info">
                              <h4>{{ $item->kendaraan->pemohon }} &ndash; {{ $item->kendaraan->tujuan }}</h4>
                              <p>Permohonan Pemakaian Kendaraan</p>
                              <small>{{ $item->created_at->diffForHumans() }}</small>
                          </div>
                      </a>
                  </li>
                  @endif
                @empty
                  <li>
                    <a href="javascript:void(0);" class="notification-list">
                      <div class="menu-info">
                        <p>Tidak ada notifikasi baru</p>
                      </div>
                    </a>
                  </li>
                @endforelse
              </ul>
          </li>
          <li class="footer">
              <a href="{{ route('admin::notifications.index') }}">Lihat Semua Notifikasi</a>
          </li>
      </ul>
  </li>
  @endif
  <!-- #END# Notifications -->
</ul>
