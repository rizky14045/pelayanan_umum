@extends('admin::layout.master')

@section('content')
@include('admin::partials.alert-messages')
<div class="block-header">
    <h2>Edit Ruang</h2>
</div>
<div class="card">
  <div class="body">
    {!! $form->render() !!}
  </div>
</div>

<div class="card">
  <div class="header">
    <h2>Pengaturan Gabungan Ruangan</h2>
  </div>
  <div class="body">
    <form method="POST" action="{{ route('admin::ruang.sync-kombinasi', [$ruang->id]) }}">
      {{ csrf_field() }}
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_kombinasi" id="is_kombinasi_toggle" value="1" {{ $ruang->is_kombinasi ? 'checked' : '' }}>
          Ini adalah gabungan dari beberapa ruangan
        </label>
      </div>
      <div id="anggota-list" style="{{ $ruang->is_kombinasi ? '' : 'display:none;' }} margin-top:10px;">
        @if($atomicRooms->isEmpty())
          <p class="text-muted">Tidak ada ruangan atomik lain yang bisa dijadikan anggota.</p>
        @else
          @foreach($atomicRooms as $atomic)
            <div class="checkbox">
              <label>
                <input type="checkbox" name="anggota[]" value="{{ $atomic->id }}" {{ in_array($atomic->id, $currentAnggotaIds) ? 'checked' : '' }}>
                {{ $atomic->nama_ruang }} ({{ $atomic->kapasitas }} orang)
              </label>
            </div>
          @endforeach
        @endif
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:10px;">Simpan Gabungan</button>
    </form>
  </div>
</div>
@stop

@section('js')
<script>
  $('#is_kombinasi_toggle').on('change', function () {
    $('#anggota-list').toggle(this.checked);
  });
</script>
@stop
