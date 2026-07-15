@php
  $userName = trim(request()->user()->name);
  $words = preg_split('/\s+/', $userName);
  $initials = count($words) >= 2
    ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
    : strtoupper(substr($userName, 0, 2));

  $avatarColors = ['#F45B69', '#3E92CC', '#2E8B57', '#D46A6A', '#8E44AD', '#E67E22', '#16A085', '#C0392B', '#27AE60', '#D35400', '#6C5CE7', '#00A8A8'];
  $avatarColor = $avatarColors[crc32($userName) % count($avatarColors)];
@endphp
<div class="user-info">
  <div class="image">
    <div style="width:48px;height:48px;border-radius:50%;background-color:{{ $avatarColor }};color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;">{{ $initials }}</div>
  </div>
  <div class="info-container">
    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ request()->user()->name }}</div>
    <div class="email">{{ request()->user()->email }}</div>
    <div class="btn-group user-helper-dropdown">
      <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
      <ul class="dropdown-menu pull-right">
        {{-- <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
        <li role="seperator" class="divider"></li>
        <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
        <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
        <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
        <li role="seperator" class="divider"></li> --}}
        <li><a href="{{ route('admin::auth.logout') }}""><i class="material-icons">input</i>Sign Out</a></li>
      </ul>
    </div>
  </div>
</div>