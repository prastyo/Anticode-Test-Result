<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */
?>
@extends('layouts.app', ['title' => __('data_status_dasar') ])
@section('content')
<div id="#section-to-print"></div>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('data_status_dasar') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('site.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('data_status_dasar') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-12 col-md-6">
                                @can('create_data_status_dasar')
                                <button type="button" class="btn btn-icon icon-left btn-primary mr-2"
                                    data-toggle="modal" data-target="#modal_add"><i class="fas fa-plus"></i>
                                    {{ __('site.add') }} {{ __('data_status_dasar') }}
                                </button>
                                @endcan

                                @can('trash_data_status_dasar')
                                <label class="mt-2 cursor-pointer">
                                    <input type="checkbox" id="trash" name="trash" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><span class="badge badge-secondary" id="badgeTrash">{{ __('site.trash') }} ( <strong id="trashCount">0</strong> )</span></span>
                                </label>
                                @endcan
                            </div>
                            <div class="col-sm-12 col-md-6 btn-group justify-content-end">
                            <form action="{{ route('data-status-dasars.excel') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="excel_search" id="excel_search">
                                    <button type="submit" class="btn btn-icon icon-left btn-success mr-2">
                                        <i class="fas fa-file-excel"></i> {{ __('site.excel') }}
                                    </button>
                                </form>
                                <form action="{{ route('data-status-dasars.print') }}" target="_blank" method="POST">
                                    @csrf
                                    <input type="hidden" name="print_search" id="print_search">
                                    <button type="submit" class="btn button-print btn-icon icon-left btn-warning mr-2">
                                        <i class="fas fa-print"></i> {{ __('site.print') }}
                                    </button>
                                </form>
                                <form action="{{ route('data-status-dasars.pdf') }}" method="POST">
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
@can('create_data_status_dasar')
<!-- modal add -->@include('pages.data-status-dasars.modal-add')
<!-- end modal add -->
@endcan

@can('edit_data_status_dasar')
<!-- modal edit -->@include('pages.data-status-dasars.modal-edit')
<!-- end modal edit -->
@endcan

<!-- modal detail -->@include('pages.data-status-dasars.modal-detail')
<!-- end modal detail -->
@can('delete_data_status_dasar')
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
        url: '{{ route('data-status-dasars.datatables') }}',
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
        url: '{{ route('data-status-dasars.purge') }}',
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
        url: '{{ route('data-status-dasars.restore') }}',
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