<div class="menu">
  @php
    $sidebarNotifQuery = \App\Models\Notification::where('status', false);
    if (Auth::user()->role == 'adminruang') {
      $sidebarNotifQuery->where(function ($q) {
        $q->whereNotNull('pemesanan_ruangan_id')
          ->orWhereNotNull('permohonan_konsumsi_id');
      });
    } elseif (Auth::user()->role == 'adminkendaraan') {
      $sidebarNotifQuery->whereNotNull('permohonan_pemakaian_kendaraan_id');
    }
    $sidebarNotifCount = in_array(Auth::user()->role, ['superadmin', 'adminruang', 'adminkendaraan'])
      ? $sidebarNotifQuery->count()
      : 0;
  @endphp
  <ul class="list">
    <li class="header">MAIN NAVIGATION</li>
    @if (Auth::user()->role == 'superadmin')
      @foreach(config('superadmin.menu') as $menu)
        @include('admin::layout.sidebar-menu-item', ['menu' => $menu])
      @endforeach
    @endif
    @if (Auth::user()->role == 'adminruang')
      @foreach(config('adminruang.menu') as $menu)
        @include('admin::layout.sidebar-menu-item', ['menu' => $menu])
      @endforeach
    @endif
    @if (Auth::user()->role == 'adminkendaraan')
      @foreach(config('adminkendaraan.menu') as $menu)
        @include('admin::layout.sidebar-menu-item', ['menu' => $menu])
      @endforeach
    @endif
    @if (in_array(Auth::user()->role, ['superadmin', 'adminruang', 'adminkendaraan']))
      <li class="{{ Request::route()->getName() == 'admin::notifications.index' ? 'active' : '' }}">
        <a href="{{ route('admin::notifications.index') }}" style="display:flex;align-items:center;justify-content:space-between;">
          <span><i class="material-icons">notifications</i><span>Notifikasi</span></span>
          @if($sidebarNotifCount > 0)
            <span class="badge" style="background-color:#DC2626;color:#fff;">{{ $sidebarNotifCount }}</span>
          @endif
        </a>
      </li>
    @endif

  </ul>
</div>