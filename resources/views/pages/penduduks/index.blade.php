<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */
?>
@extends('layouts.app', ['title' => __('penduduk') ])
@section('content')
<div id="#section-to-print"></div>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('penduduk') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('site.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('penduduk') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-12 col-md-6">
                                @can('create_penduduk')
                                <button type="button" class="btn btn-icon icon-left btn-primary mr-2"
                                    data-toggle="modal" data-target="#modal_add"><i class="fas fa-plus"></i>
                                    {{ __('site.add') }} {{ __('penduduk') }}
                                </button>
                                @endcan

                                @can('trash_penduduk')
                                <label class="mt-2 cursor-pointer">
                                    <input type="checkbox" id="trash" name="trash" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><span class="badge badge-secondary" id="badgeTrash">{{ __('site.trash') }} ( <strong id="trashCount">0</strong> )</span></span>
                                </label>
                                @endcan
                            </div>
                            <div class="col-sm-12 col-md-6 btn-group justify-content-end">
                            <form action="{{ route('penduduks.excel') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="excel_search" id="excel_search">
                                    <button type="submit" class="btn btn-icon icon-left btn-success mr-2">
                                        <i class="fas fa-file-excel"></i> {{ __('site.excel') }}
                                    </button>
                                </form>
                                <form action="{{ route('penduduks.print') }}" target="_blank" method="POST">
                                    @csrf
                                    <input type="hidden" name="print_search" id="print_search">
                                    <button type="submit" class="btn button-print btn-icon icon-left btn-warning mr-2">
                                        <i class="fas fa-print"></i> {{ __('site.print') }}
                                    </button>
                                </form>
                                <form action="{{ route('penduduks.pdf') }}" method="POST">
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
@can('create_penduduk')
<!-- modal add -->@include('pages.penduduks.modal-add')
<!-- end modal add -->
@endcan

@can('edit_penduduk')
<!-- modal edit -->@include('pages.penduduks.modal-edit')
<!-- end modal edit -->
@endcan

<!-- modal detail -->@include('pages.penduduks.modal-detail')
<!-- end modal detail -->
@can('delete_penduduk')
@include('components.modal-delete')
@endcan

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
        url: '{{ route('penduduks.datatables') }}',
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
        { data: 'nama', name: 'nama' },
        { data: 'nik', name: 'nik' },
        { data: 'tempat_lahir', name: 'tempat_lahir' },
        { data: 'tanggal_lahir', name: 'tanggal_lahir' },
        { data: 'jenis_kelamin', name: 'jenis_kelamin' },
        { data: 'agama.nama', name: 'agama.nama' },
        { data: 'telepon', name: 'telepon' },
        { data: 'email', name: 'email' },
        { data: 'identitas_elektronik', name: 'identitas_elektronik' },
        { data: 'hubungan_keluarga.nama', name: 'hubungan_keluarga.nama' },
        { data: 'rt', name: 'rt' },
        { data: 'rw', name: 'rw' },
        { data: 'alamat', name: 'alamat' },
        { data: 'kodepos', name: 'kodepos' },
        { data: 'pendidikan.nama', name: 'pendidikan.nama' },
        { data: 'nik_ayah', name: 'nik_ayah' },
        { data: 'nama_ayah', name: 'nama_ayah' },
        { data: 'nik_ibu', name: 'nik_ibu' },
        { data: 'nama_ibu', name: 'nama_ibu' },
        { data: 'akte_kelahiran', name: 'akte_kelahiran' },
        { data: 'kawin.nama', name: 'kawin.nama' },
        { data: 'akseptor_kb.nama', name: 'akseptor_kb.nama' },
        { data: 'pekerjaan.nama', name: 'pekerjaan.nama' },
        { data: 'sakit_menahun.nama', name: 'sakit_menahun.nama' },
        { data: 'cacat.nama', name: 'cacat.nama' },
        { data: 'kelainan_fisik_mental', name: 'kelainan_fisik_mental' },
        { data: 'golongan_darah.nama', name: 'golongan_darah.nama' },
        { data: 'warganegara.nama', name: 'warganegara.nama' },
        { data: 'asuransi.nama', name: 'asuransi.nama' },
        { data: 'status_penduduk', name: 'status_penduduk' },
        { data: 'status_dasar.nama', name: 'status_dasar.nama' },
        { data: 'suku.nama', name: 'suku.nama' },
        { data: 'kursus.nama', name: 'kursus.nama' },
        { data: 'bahasa.nama', name: 'bahasa.nama' },
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
        url: '{{ route('penduduks.purge') }}',
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
        url: '{{ route('penduduks.restore') }}',
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

</script>
@stack('jquery_add')
@stack('jquery_edit')
@stack('jquery_detail')
@stack('jquery_delete')

@endpush
@endsection