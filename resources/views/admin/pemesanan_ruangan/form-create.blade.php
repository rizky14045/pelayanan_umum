@extends('admin::layout.master')

@section('content')
<style>
	.kpi-form-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:20px;}
	.kpi-btn-back{display:inline-flex;align-items:center;gap:8px;background:#F5F6FA;color:#1F5C85;border:none;border-radius:20px;padding:9px 20px;font-size:14px;font-weight:600;transition:background .15s,transform .15s;}
	.kpi-btn-back:hover{background:#E1EDF4;transform:translateX(-2px);color:#1F5C85;text-decoration:none;}
	.kpi-form-card{background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);padding:24px;}
</style>
@include('admin::partials.alert-messages')
<div class="kpi-form-header">
    <h2 style="margin:0;">Create Pemesanan Ruangan</h2>
    <a class="kpi-btn-back" href="{{ route('admin::pemesanan-ruangan.page-list') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
</div>
<div class="kpi-form-card">
    {!! $form->render() !!}
</div>
@stop
@section('js')
<script>
(function ($) {
    function refreshRoomOptions() {
        var tanggal = $('#input-tanggal').val();
        var waktuAwal = $('#input-waktu_awal').val();
        var waktuAkhir = $('#input-waktu_akhir').val();
        if (!tanggal || !waktuAwal || !waktuAkhir) {
            return;
        }

        var $select = $('#input-id_ruang');
        var currentValue = $select.val();

        $.get("{{ route('admin::pemesanan-ruangan.available-rooms') }}", {
            tanggal: tanggal,
            waktu_awal: waktuAwal,
            waktu_akhir: waktuAkhir
        }).done(function (res) {
            var html = '<option value="">-- Pick Id Ruang --</option>';
            var stillAvailable = false;
            $.each(res.rooms || [], function (i, room) {
                var isSelected = String(room.id) === String(currentValue);
                if (isSelected) stillAvailable = true;
                html += '<option value="' + room.id + '"' + (isSelected ? ' selected' : '') + '>' + room.label + '</option>';
            });
            $select.html(html);
            if (currentValue && !stillAvailable) {
                $select.val('');
            }
            if ($.fn.selectpicker) {
                $select.selectpicker('refresh');
            }
        });
    }

    $(document).on('change', '#input-tanggal, #input-waktu_awal, #input-waktu_akhir', refreshRoomOptions);
    $(refreshRoomOptions);
})(jQuery);
</script>
@stop
