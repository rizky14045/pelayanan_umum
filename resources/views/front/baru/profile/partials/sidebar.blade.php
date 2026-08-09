@php
	$sidebarUser = $user ?? App\Models\Karyawan::where('id', auth()->guard('front')->id())->first();
	$avatarName = trim($sidebarUser->nama);
	$avatarWords = preg_split('/\s+/', $avatarName);
	$avatarInitials = count($avatarWords) >= 2
		? strtoupper(substr($avatarWords[0], 0, 1) . substr($avatarWords[1], 0, 1))
		: strtoupper(substr($avatarName, 0, 2));
	$avatarColors = ['#F45B69', '#3E92CC', '#2E8B57', '#D46A6A', '#8E44AD', '#E67E22', '#16A085', '#C0392B', '#27AE60', '#D35400', '#6C5CE7', '#00A8A8'];
	$avatarColor = $avatarColors[crc32($avatarName) % count($avatarColors)];
	$active = $active ?? '';
	$showAtkSpj = $showAtkSpj ?? false;
@endphp
<style>
	.user-profile-sidebar{background:#1F5C85;border-radius:10px;box-shadow:0 2px 8px rgba(31,92,133,.18);}
	.user-profile-sidebar .user-profile-avatar{padding:24px 20px 18px;}
	.user-profile-sidebar .avatar-initials-lg{display:inline-flex;align-items:center;justify-content:center;width:84px;height:84px;border-radius:50%;color:#fff;font-size:30px;font-weight:700;margin:0 auto 12px;box-shadow:0 2px 6px rgba(0,0,0,.15);}
	.user-profile-sidebar .user-profile-avatar h5{color:#fff;margin-bottom:2px;font-size:15px;font-weight:700;}
	.user-profile-sidebar .user-profile-avatar p{font-size:11px;color:rgba(255,255,255,.7);margin-bottom:0;}
	.user-profile-sidebar .user-profile-nav>li{border-bottom:1px solid rgba(255,255,255,.1);}
	.user-profile-sidebar .user-profile-nav>li:first-child{border-top:1px solid rgba(255,255,255,.1);}
	.user-profile-sidebar .user-profile-nav>li>a{padding:11px 20px;color:rgba(255,255,255,.85);display:block;font-size:13px;transition:background .15s,color .15s;}
	.user-profile-sidebar .user-profile-nav>li>a>i{margin-right:8px;display:inline-block;width:18px;text-align:center;color:rgba(255,255,255,.6);}
	.user-profile-sidebar .user-profile-nav>li>a:hover{background:rgba(255,255,255,.08);color:#fff;}
	.user-profile-sidebar .user-profile-nav>li>a:hover>i{color:#fff;}
	.user-profile-sidebar .user-profile-nav>li.active>a{background:#fff;color:#1F5C85;font-weight:600;cursor:default;}
	.user-profile-sidebar .user-profile-nav>li.active>a>i{color:#1F5C85;}
	.user-profile-sidebar .user-profile-nav>li.active>a:hover{background:#fff;color:#1F5C85;}
</style>
<aside class="user-profile-sidebar">
	<div class="user-profile-avatar text-center">
		<span class="avatar-initials-lg" style="background-color: {{ $avatarColor }};">{{ $avatarInitials }}</span>
		<h5>{{ $sidebarUser->nama }}</h5>
		<p>{{ $sidebarUser->jabatan }}</p>
	</div>
	<ul class="list user-profile-nav">
		<li class="{{ $active == 'dashboard' ? 'active' : '' }}">
			<a href="{{ route('profile.index') }}"><i class="fa fa-user"></i> Dashboard</a>
		</li>
		<li class="{{ $active == 'setting' ? 'active' : '' }}">
			<a href="{{ route('profile.setting') }}"><i class="fa fa-cog"></i> Pengaturan</a>
		</li>
		<li class="{{ $active == 'ruangan' ? 'active' : '' }}">
			<a href="{{ route('list-peminjaman-ruang') }}"><i class="fa fa-home"></i> Pemesanan Ruangan</a>
		</li>
		<li class="{{ $active == 'konsumsi' ? 'active' : '' }}">
			<a href="{{ route('list-permohonan-konsumsi') }}"><i class="fa fa-spoon"></i> Permohonan Konsumsi</a>
		</li>
		<li class="{{ $active == 'kendaraan' ? 'active' : '' }}">
			<a href="{{ route('list-permohonan-kendaraan') }}"><i class="fa fa-map-marker"></i> Permohonan Kendaraan</a>
		</li>
		@if($showAtkSpj)
		<li class="{{ $active == 'atk' ? 'active' : '' }}">
			<a href="{{ route('list-permohonan-atk') }}"><i class="fa fa-pencil"></i> Permohonan ATK</a>
		</li>
		<li class="{{ $active == 'spj' ? 'active' : '' }}">
			<a href="{{ route('list-surat-perintah-jalan') }}"><i class="fa fa-map-marker"></i> Surat Perintah Jalan</a>
		</li>
		@endif
	</ul>
</aside>
