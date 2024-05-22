@extends('layouts.master')

@section('title')
Daftar Produk
@endsection

@section('breadcrumb')
@parent
<li class="active">Daftar Produk</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="btn-group">
                        <button onclick="addForm('{{route('produk.store')}}')" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <button onclick="deleteSelected('{{ route ('produk.deleteSelected')}}')" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                        <button onclick="cetakBarcode('{{ route ('produk.cetakBarcode')}}')" class="btn btn-info btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                        
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="POST" class="form-produk">
                        @csrf
                        <table class="table table-stiped table-border">
                            <thead>
                                <th>
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th tidth="15%"><i class="fa fa-cog"></i></th>
                                </thead>
                        </table>
                    </form>
                </div>
            </div>
            </section>
@includeIf('produk.form')
@endsection

            @push('scripts')
<script>
    let table;
        $(function(){
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('produk.data')}}',
                },
                columns: [
                    {data: 'select_all', searchable: false, sortable:false},
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'kode_produk'},
                    {data: 'nama_produk'},
                    {data: 'nama_kategori'},
                    {data: 'merk'},
                    {data: 'harga_beli'},
                    {data: 'harga_jual'},
                    {data: 'diskon'},
                    {data: 'stok'},
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

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();

    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
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

    function deleteSelected(url) {
        if ($('input:checked').length >= 1){
            if (confirm('Yakin ingin Menghapus ?')){
                $.post(url, $('.form-produk').serialize())
                .done((response)=> {
                    table.ajax.reload();
                })
                .fail((error)=>{
                    alert('Tidak Dapat Menghapus Data');
                    return;
                })
            }
        } else{
            alert('Pilih Data yang akan Dihapus');
            return;
        }
    }

    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
            return;
        } else {
            $('.form-produk')
                .attr('target', '_blank').attr('action', url).submit();
        }
    }
                    
</script>
@endpush
