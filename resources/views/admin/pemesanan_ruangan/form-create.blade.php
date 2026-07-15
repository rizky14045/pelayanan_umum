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
