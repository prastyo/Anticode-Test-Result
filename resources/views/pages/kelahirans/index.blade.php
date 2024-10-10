<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */
?>
@extends('layouts.app', ['title' => __('kelahiran') ])
@section('content')
<div id="#section-to-print"></div>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('kelahiran') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('site.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('kelahiran') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-12 col-md-6">
                                @can('create_kelahiran')
                                <button type="button" class="btn btn-icon icon-left btn-primary mr-2"
                                    data-toggle="modal" data-target="#modal_add"><i class="fas fa-plus"></i>
                                    {{ __('site.add') }} {{ __('kelahiran') }}
                                </button>
                                @endcan

                                @can('trash_kelahiran')
                                <label class="mt-2 cursor-pointer">
                                    <input type="checkbox" id="trash" name="trash" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><span class="badge badge-secondary" id="badgeTrash">{{ __('site.trash') }} ( <strong id="trashCount">0</strong> )</span></span>
                                </label>
                                @endcan
                            </div>
                            <div class="col-sm-12 col-md-6 btn-group justify-content-end">
                            <form action="{{ route('kelahirans.excel') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="excel_search" id="excel_search">
                                    <button type="submit" class="btn btn-icon icon-left btn-success mr-2">
                                        <i class="fas fa-file-excel"></i> {{ __('site.excel') }}
                                    </button>
                                </form>
                                <form action="{{ route('kelahirans.print') }}" target="_blank" method="POST">
                                    @csrf
                                    <input type="hidden" name="print_search" id="print_search">
                                    <button type="submit" class="btn button-print btn-icon icon-left btn-warning mr-2">
                                        <i class="fas fa-print"></i> {{ __('site.print') }}
                                    </button>
                                </form>
                                <form action="{{ route('kelahirans.pdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pdf_search" id="pdf_search">
                                    <button type="submit" class="btn btn-icon icon-left btn-info">
                                        <i class="fas fa-file-pdf"></i> {{ __('site.pdf') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table_datatables" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('nama_anak') }}</th>
                                        <th>{{ __('jenis_kelamin') }}</th>
                                        <th>{{ __('ayah_nama') }}</th>
                                        <th>{{ __('ayah_nik') }}</th>
                                        <th>{{ __('ibu_nama') }}</th>
                                        <th>{{ __('ibu_nik') }}</th>
                                        <th>{{ __('hari_lahir') }}</th>
                                        <th>{{ __('tempat_lahir') }}</th>
                                        <th>{{ __('tanggal_lahir') }}</th>
                                        <th>{{ __('jam_lahir') }}</th>
                                        <th>{{ __('jenis_persalinan') }}</th>
                                        <th>{{ __('anak_ke') }}</th>
                                        <th>{{ __('berat_bayi') }}</th>
                                        <th>{{ __('panjang_bayi') }}</th>
                                        <th>{{ __('tempat_dilahirkan') }}</th>
                                        <th>{{ __('penolong_kelahiran') }}</th>
                                        <th>{{ __('site.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@can('create_kelahiran')
<!-- modal add -->@include('pages.kelahirans.modal-add')
<!-- end modal add -->
@endcan

@can('edit_kelahiran')
<!-- modal edit -->@include('pages.kelahirans.modal-edit')
<!-- end modal edit -->
@endcan

<!-- modal detail -->@include('pages.kelahirans.modal-detail')
<!-- end modal detail -->
@can('delete_kelahiran')
@include('components.modal-delete')
@endcan

<div class="modal fade" id="modal_search_Penduduk" tabindex="0" role="dialog" aria-labelledby="modal_search_Penduduk" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="table_search_Penduduk" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('nama') }}</th>
                                                <th>{{ __('nik') }}</th>
                                                <th>{{ __('tempat_lahir') }}</th>
                                                <th>{{ __('tanggal_lahir') }}</th>
                                                <th>{{ __('jenis_kelamin') }}</th>
                                                <th>{{ __('agama') }}</th>
                                                <th>{{ __('telepon') }}</th>
                                                <th>{{ __('email') }}</th>
                                                <th>{{ __('identitas_elektronik') }}</th>
                                                <th>{{ __('hubungan_keluarga') }}</th>
                                                <th>{{ __('rt') }}</th>
                                                <th>{{ __('rw') }}</th>
                                                <th>{{ __('alamat') }}</th>
                                                <th>{{ __('kodepos') }}</th>
                                                <th>{{ __('pendidikan') }}</th>
                                                <th>{{ __('nik_ayah') }}</th>
                                                <th>{{ __('nama_ayah') }}</th>
                                                <th>{{ __('nik_ibu') }}</th>
                                                <th>{{ __('nama_ibu') }}</th>
                                                <th>{{ __('akte_kelahiran') }}</th>
                                                <th>{{ __('kawin') }}</th>
                                                <th>{{ __('akseptor_kb') }}</th>
                                                <th>{{ __('pekerjaan') }}</th>
                                                <th>{{ __('sakit_menahun') }}</th>
                                                <th>{{ __('cacat') }}</th>
                                                <th>{{ __('kelainan_fisik_mental') }}</th>
                                                <th>{{ __('golongan_darah') }}</th>
                                                <th>{{ __('warganegara') }}</th>
                                                <th>{{ __('asuransi') }}</th>
                                                <th>{{ __('status_penduduk') }}</th>
                                                <th>{{ __('status_dasar') }}</th>
                                                <th>{{ __('suku') }}</th>
                                                <th>{{ __('kursus') }}</th>
                                                <th>{{ __('bahasa') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@push('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var table = $('#table_datatables').DataTable({
    serverSide: true,
    responsive: true,
    language: {
            url: "{{ asset('modules/datatables/i18n/'.app()->getLocale().'.json') }}",
    },
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 }
    ],
    ajax: {
        url: '{{ route('kelahirans.datatables') }}',
        type: 'POST',

        data: function(d){
            d.trash = $('#trash').is(':checked') ? 1 : 0;
        },
        dataSrc: function(json) {
            // Update the trash count when table data is loaded
            $('#trashCount').text(json.trashedCount); // Update element with trashedCount value
            return json.data; // Return the table data
        }
    },
    columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%'
        },
        { data: 'nama_anak', name: 'nama_anak' },
        { data: 'jenis_kelamin', name: 'jenis_kelamin' },
        { data: 'ayah.nama', name: 'ayah.nama' },
        { data: 'ayah.nik', name: 'ayah.nik' },
        { data: 'ibu.nama', name: 'ibu.nama' },
        { data: 'ibu.nik', name: 'ibu.nik' },
        { data: 'hari_lahir', name: 'hari_lahir' },
        { data: 'tempat_lahir', name: 'tempat_lahir' },
        { data: 'tanggal_lahir', name: 'tanggal_lahir' },
        { data: 'jam_lahir', name: 'jam_lahir' },
        { data: 'jenis_persalinan.nama', name: 'jenis_persalinan.nama' },
        { data: 'anak_ke', name: 'anak_ke' },
        { data: 'berat_bayi', name: 'berat_bayi' },
        { data: 'panjang_bayi', name: 'panjang_bayi' },
        { data: 'tempat_dilahirkan.nama', name: 'tempat_dilahirkan.nama' },
        { data: 'penolong_kelahiran.nama', name: 'penolong_kelahiran.nama' },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            width: '10%'
        }
    ]
});

// Trigger table update on checkbox change
$('#trash').on('change', function() {
    if ($(this).is(':checked')) {
        $('#badgeTrash').removeClass('badge-secondary').addClass('badge-danger');
    } else {
        $('#badgeTrash').removeClass('badge-danger').addClass('badge-secondary');
    }
    table.ajax.reload(); // Reload DataTable with updated checkbox value
});

$('#button_delete_permanently').click(function() {
    $.ajax({
        url: '{{ route('kelahirans.purge') }}',
        type: "POST",
        data: {
                id: $('#modal_detail').find('#id').val()
        },
        success: function(response) {
            table.draw(); //reload datatables after success

            toastr.options = {"positionClass": "toast-bottom-right"}
            toastr.success(response.message);
        },
        error: function(response) {
            toastr.options = {"positionClass": "toast-bottom-right"}
            toastr.error(response.responseJSON.message);
        }
    });
});

$('#button_restore').click(function() {
    $.ajax({
        url: '{{ route('kelahirans.restore') }}',
        type: "POST",
        data: {
                id: $('#modal_detail').find('#id').val()
        },
        success: function(response) {
            table.draw(); //reload datatables after success

            toastr.options = {"positionClass": "toast-bottom-right"}
            toastr.success(response.message);
        },
        error: function(response) {
            toastr.options = {"positionClass": "toast-bottom-right"}
            toastr.error(response.responseJSON.message);
        }
    });
});

var table_search_Penduduk
$('#modal_search_Penduduk').on('shown.bs.modal', function(event) {
    // Initialize DataTable only when the modal is opened
    if (!$.fn.DataTable.isDataTable('#table_search_Penduduk')) {
        table_search_Penduduk = $('#table_search_Penduduk').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('penduduks.datatables') }}',
                type: 'POST',
            },
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'nik', name: 'nik' },
                { data: 'tempat_lahir', name: 'tempat_lahir' },
                { data: 'tanggal_lahir', name: 'tanggal_lahir' },
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'agama.nama', name: 'agama_id' },
                { data: 'telepon', name: 'telepon' },
                { data: 'email', name: 'email' },
                { data: 'identitas_elektronik', name: 'identitas_elektronik' },
                { data: 'hubungan_keluarga.nama', name: 'hubungan_keluarga_id' },
                { data: 'rt', name: 'rt' },
                { data: 'rw', name: 'rw' },
                { data: 'alamat', name: 'alamat' },
                { data: 'kodepos', name: 'kodepos' },
                { data: 'pendidikan.nama', name: 'pendidikan_id' },
                { data: 'nik_ayah', name: 'nik_ayah' },
                { data: 'nama_ayah', name: 'nama_ayah' },
                { data: 'nik_ibu', name: 'nik_ibu' },
                { data: 'nama_ibu', name: 'nama_ibu' },
                { data: 'akte_kelahiran', name: 'akte_kelahiran' },
                { data: 'kawin.nama', name: 'kawin_id' },
                { data: 'akseptor_kb.nama', name: 'akseptor_kb_id' },
                { data: 'pekerjaan.nama', name: 'pekerjaan_id' },
                { data: 'sakit_menahun.nama', name: 'sakit_menahun_id' },
                { data: 'cacat.nama', name: 'cacat_id' },
                { data: 'kelainan_fisik_mental', name: 'kelainan_fisik_mental' },
                { data: 'golongan_darah.nama', name: 'golongan_darah_id' },
                { data: 'warganegara.nama', name: 'warganegara_id' },
                { data: 'asuransi.nama', name: 'asuransi_id' },
                { data: 'status_penduduk', name: 'status_penduduk' },
                { data: 'status_dasar.nama', name: 'status_dasar_id' },
                { data: 'suku.nama', name: 'suku_id' },
                { data: 'kursus.nama', name: 'kursus_id' },
                { data: 'bahasa.nama', name: 'bahasa_id' },

            ]
        });
    }

    // Not brilliant solution, but fair enough hehe..
    if ($('#modal_add').hasClass('show')){
        var modale = 'modal_add';
    }else{
        var modale = 'modal_edit';
    }
    let parse_search = $(event.relatedTarget).data('parse_search');
    $('#'+ modale).attr('parse_search', parse_search);
});
$('#table_search_Penduduk').on('click', 'tr', function () {
    if ($('#modal_add').hasClass('show')){
        var modale = 'modal_add';
    }else{
        var modale = 'modal_edit';
    }
    var parse_search = $('#'+ modale).attr('parse_search');
    var result = table_search_Penduduk.row(this).data();
    $('#'+ modale).find('#'+ parse_search).val(result.id);
    $('#'+ modale).find('#parse_search_'+ parse_search).html(
        '<tr><td>{{ __('nama') }}</td><td>:</td><td>'+result.nama+'</td></tr>'
            +'<tr><td>{{ __('nik') }}</td><td>:</td><td>'+result.nik+'</td></tr>'
            +'<tr><td>{{ __('tempat_lahir') }}</td><td>:</td><td>'+result.tempat_lahir+'</td></tr>'
            +'<tr><td>{{ __('tanggal_lahir') }}</td><td>:</td><td>'+result.tanggal_lahir+'</td></tr>'
            +'<tr><td>{{ __('jenis_kelamin') }}</td><td>:</td><td>'+result.jenis_kelamin+'</td></tr>'
            +'<tr><td>{{ __('agama') }}</td><td>:</td><td>'+result.agama.nama+'</td></tr>'
            +'<tr><td>{{ __('telepon') }}</td><td>:</td><td>'+result.telepon+'</td></tr>'
            +'<tr><td>{{ __('email') }}</td><td>:</td><td>'+result.email+'</td></tr>'
            +'<tr><td>{{ __('identitas_elektronik') }}</td><td>:</td><td>'+result.identitas_elektronik+'</td></tr>'
            +'<tr><td>{{ __('hubungan_keluarga') }}</td><td>:</td><td>'+result.hubungan_keluarga.nama+'</td></tr>'
            +'<tr><td>{{ __('rt') }}</td><td>:</td><td>'+result.rt+'</td></tr>'
            +'<tr><td>{{ __('rw') }}</td><td>:</td><td>'+result.rw+'</td></tr>'
            +'<tr><td>{{ __('alamat') }}</td><td>:</td><td>'+result.alamat+'</td></tr>'
            +'<tr><td>{{ __('kodepos') }}</td><td>:</td><td>'+result.kodepos+'</td></tr>'
            +'<tr><td>{{ __('pendidikan') }}</td><td>:</td><td>'+result.pendidikan.nama+'</td></tr>'
            +'<tr><td>{{ __('nik_ayah') }}</td><td>:</td><td>'+result.nik_ayah+'</td></tr>'
            +'<tr><td>{{ __('nama_ayah') }}</td><td>:</td><td>'+result.nama_ayah+'</td></tr>'
            +'<tr><td>{{ __('nik_ibu') }}</td><td>:</td><td>'+result.nik_ibu+'</td></tr>'
            +'<tr><td>{{ __('nama_ibu') }}</td><td>:</td><td>'+result.nama_ibu+'</td></tr>'
            +'<tr><td>{{ __('akte_kelahiran') }}</td><td>:</td><td>'+result.akte_kelahiran+'</td></tr>'
            +'<tr><td>{{ __('kawin') }}</td><td>:</td><td>'+result.kawin.nama+'</td></tr>'
            +'<tr><td>{{ __('akseptor_kb') }}</td><td>:</td><td>'+result.akseptor_kb.nama+'</td></tr>'
            +'<tr><td>{{ __('pekerjaan') }}</td><td>:</td><td>'+result.pekerjaan.nama+'</td></tr>'
            +'<tr><td>{{ __('sakit_menahun') }}</td><td>:</td><td>'+result.sakit_menahun.nama+'</td></tr>'
            +'<tr><td>{{ __('cacat') }}</td><td>:</td><td>'+result.cacat.nama+'</td></tr>'
            +'<tr><td>{{ __('kelainan_fisik_mental') }}</td><td>:</td><td>'+result.kelainan_fisik_mental+'</td></tr>'
            +'<tr><td>{{ __('golongan_darah') }}</td><td>:</td><td>'+result.golongan_darah.nama+'</td></tr>'
            +'<tr><td>{{ __('warganegara') }}</td><td>:</td><td>'+result.warganegara.nama+'</td></tr>'
            +'<tr><td>{{ __('asuransi') }}</td><td>:</td><td>'+result.asuransi.nama+'</td></tr>'
            +'<tr><td>{{ __('status_penduduk') }}</td><td>:</td><td>'+result.status_penduduk+'</td></tr>'
            +'<tr><td>{{ __('status_dasar') }}</td><td>:</td><td>'+result.status_dasar.nama+'</td></tr>'
            +'<tr><td>{{ __('suku') }}</td><td>:</td><td>'+result.suku.nama+'</td></tr>'
            +'<tr><td>{{ __('kursus') }}</td><td>:</td><td>'+result.kursus.nama+'</td></tr>'
            +'<tr><td>{{ __('bahasa') }}</td><td>:</td><td>'+result.bahasa.nama+'</td></tr>'

    );
    $('#modal_search_Penduduk').modal('hide');
});
</script>
@stack('jquery_add')
@stack('jquery_edit')
@stack('jquery_detail')
@stack('jquery_delete')

@endpush
@endsection