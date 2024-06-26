@extends('layouts.master')

@section('title')
Daftar Supplier
@endsection

@section('breadcrumb')
@parent
<li class="active">Daftar Supplier</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{route('supplier.store')}}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i>Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-border">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('supplier.form')
@endsection

            @push('scripts')
<script>
    let table;
        $(function(){
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('supplier.data')}}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'nama'},
                    {data: 'telepon', sortable: false},
                    {data: 'alamat', sortable: false},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Supplier');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();

    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Supplier');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=alamat]').val(response.alamat);
                $('#modal-form [name=telepon]').val(response.telepon);
            })
            .fail((error) => {
                alert('Tidak dapat menampilkan data');
            });

    }

    function deleteData(url) {
        if (confirm ('Hapus Data ?')){
            $.post(url,{
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'

        })
        .done((response) => {
            table.ajax.reload();
        })
        .fail((error) => {
            alert('Tidak dapat Menghapus Data');
            return;
        });
        }
    }
                    
</script>
@endpush
