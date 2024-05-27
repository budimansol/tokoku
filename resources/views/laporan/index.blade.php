@extends('layouts.master')

@section('title')
Laporan Pendapatan {{tanggal_indonesia($tanggal_awal, false) }} - {{tanggal_indonesia($tanggal_akhir, false)}}
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endpush

@section('breadcrumb')
@parent
<li class="active">Laporan</li>
@endsection

@section('content')
<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="updatePeriode()" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                    <a href="{{route ('laporan.export_pdf', [$tanggal_awal, $tanggal_akhir])}}" class="btn btn-info xs btn-flat"><i class="fa fa-file-excel-o"></i> Ekspor PDF</a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-border">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Penjualan</th>
                        <th>Pembelian</th>
                        <th>Pengeluaran</th>
                        <th>Pendapatan</th>
                    </thead>
            </table>
        </div>
    </div>
</section>
@includeIf('laporan.form')
@endsection

@push('scripts')
<!-- datepicker -->
<script src="{{asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    let table;
        $(function(){
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('laporan.data', [$tanggal_awal, $tanggal_akhir])}}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'tanggal'},
                    {data: 'penjualan'},
                    {data: 'pembelian'},
                    {data: 'pengeluaran'},
                    {data: 'pendapatan'}
                ],
                dom: 'Btr',
                bSort: false,
                bPaginate: false
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        })
    });

    function updatePeriode(url) {
        $('#modal-form').modal('show');
    }
                    
</script>
@endpush
