<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */
?>
@extends('layouts.app', ['title' => __('site.role') ])
@section('content')
@push('styles')
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('site.role') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('site.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('site.role') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row justify-content-center" id="parse_total"></div>
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-12 col-md-6">
                                @can('create_roles')
                                <button type="button" class="btn btn-icon icon-left btn-primary mr-2"
                                    data-toggle="modal" data-target="#modal_add"><i class="fas fa-plus"></i>
                                    {{ __('site.add') }} {{ __('site.role') }}
                                </button>
                                @endcan
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table_datatables" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('site.name') }}</th>
                                        <th>{{ __('site.guard') }}</th>
                                        <th>{{ __('site.permission') }}</th>
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

<div class="modal fade" id="modal_add" tabindex="0" role="dialog" aria-labelledby="modal_add" aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.add_new') }} {{ __('site.role') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>{{ __('site.name') }}</label>
                    <input type="text" id="name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="check_all_add">
                        <label class="form-check-label" for="check_all_add">
                        {{ __('site.select_all') }}
                        </label>
                    </div>
                </div>
                <table class="table table-hover" id="checked">
                    <tbody id="parse_permission">
                    </tbody>
                </table>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-icon icon-left btn-outline-secondary mr-auto"
                    data-dismiss="modal">{{ __('site.cancel') }}</button>
                <button type="button" class="btn btn-icon icon-left btn-success" id="button_create"><i
                        class="fas fa-check"></i> {{ __('site.submit') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_show" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('site.role') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="3">{{ __('site.name') }} <span id="role_badge"></span></th>
                        </tr>
                    </thead>
                    <tbody id="parse_permission">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <div class="mr-auto">
                    <small class="font-weight-bold">{{ __('site.created_at') }}</small>
                    <small class="text-muted" id="created_at"></small>
                </div>
                <div>
                    <small class="font-weight-bold">{{ __('site.updated_at') }}</small>
                    <small class="text-muted" id="updated_at"></small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_edit" tabindex="0" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.edit') }} {{ __('site.role') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" value="">
                <div class="form-group">
                    <label>{{ __('site.name') }}</label>
                    <input type="text" id="name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="check_all_edit">
                        <label class="form-check-label" for="check_all_edit">
                        {{ __('site.select_all') }}
                        </label>
                    </div>
                </div>
                <table class="table table-hover" id="checked">
                    <tbody id="parse_permission"></tbody>
                </table>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-icon icon-left btn-outline-secondary mr-auto"
                    data-dismiss="modal">{{ __('site.cancel') }}</button>
                <button type="button" class="btn btn-icon icon-left btn-success" id="button_update"><i
                        class="fas fa-refresh"></i> {{ __('site.update') }}</button>
            </div>
        </div>
    </div>
</div>
@include('components.modal-delete')

@push('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var table = $('#table_datatables').DataTable({
    serverSide: true,
    info: false,
    ordering: false,
    paging: false,
    searching: false,
    language: {
            url: "{{ asset('modules/datatables/i18n/'.app()->getLocale().'.json') }}",
    },
    ajax: {
        url: '{{ route('roles.datatables') }}',
        type: 'POST'
    },
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%'
        },
        {
            data: 'role_badge',
            name: 'role_badge'
        },
        {
            data: 'guard_name',
            name: 'guard_name',
            className: "dt-nowrap",
        },
        {
            data: 'permission_list',
            name: 'permission_list',
            orderable: false,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            width: '10%'
        }
    ],
    drawCallback: function(settings) {
        /// Here the response
        var response = settings.json;
        var total = '';
        var i = 0;
        response.data.forEach(element => {
            total += show_total(element, i);
            i++;
        });

        $("#parse_total").html(total);
    },
});

function show_total(item,i){
    let color = ['primary', 'info', 'success', 'warning', 'danger', 'dark', 'secondary'];
    return '<div class="col-lg-3 col-md-6 col-sm-6 col-12">'+
                '<div class="card card-statistic-1">'+
                    '<div class="card-icon bg-'+color[i % color.length]+'"><i class="fas fa-users"></i></div>'+
                    '<div class="card-wrap"><div class="card-header"><h4>Total '+item.name+'</h4></div>'+
                        '<div class="card-body">'+item.user_count+'</div>'+
                    '</div>'+
                '</div>'+
            '</div>';
}

$('#button_create').click(function() {
    let modale = $("#modal_add");
    let buttone = $(this);

    var values = [];
    $(modale).find('.list_check_input').each(function() {
        if ($(this).is(':checked')) {
            values.push($(this).val());
        }
    });

    $.ajax({
        url: '{{ route('roles.store') }}',
        type: "POST",
        data: {
            "name": $(modale).find("#name").val(),
            "checked": values
        },
        beforeSend: function() {
            $(modale).find('#name').removeClass('is-invalid');
            $(modale).find('#checked').removeClass('is-invalid');
        },
        success: function(response) {
            $(modale).find('input:checkbox').prop('checked', false);
            $(modale).find("#name").val('');
            $(modale).find("#name").focus();

            table.draw(); //reload datatables after success

            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.success(response.message);
        },
        error: function(response) {
            $.each(response.responseJSON.errors, function(field_name, error) {
                $(modale).find('#' + field_name).addClass('is-invalid');
                $(modale).find('#' + field_name).siblings('.invalid-feedback')
                    .html(error[0]);
            });

            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.error(response.responseJSON.message);
        }
    });
});

$('#button_update').click(function() {
    let modale = $('#modal_edit');
    let buttone = $(this);

    var values = [];
    $(modale).find('.list_check_input').each(function() {
        if ($(this).is(':checked')) {
            values.push($(this).val());
        }
    });

    $.ajax({
        url: '{{ url()->current() }}/' + $(modale).find('#id').val(),
        type: "PUT",
        data: {
            "name": $(modale).find("#name").val(),
            "checked": values
        },
        beforeSend: function() {
            $(modale).find('#name').removeClass('is-invalid');
            $(modale).find('#checked').removeClass('is-invalid');
        },
        success: function(response) {
            table.draw(); //reload datatables after success

            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.success(response.message);

            $(modale).modal('hide');
        },
        error: function(response) {
            $.each(response.responseJSON.errors, function(field_name, error) {
                $(modale).find('#' + field_name).addClass('is-invalid');
                $(modale).find('#' + field_name).siblings('.invalid-feedback')
                    .html(error[0]);
            });

            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.error(response.responseJSON.message);
        }
    });
});

$('#modal_add').on('shown.bs.modal', function(event) {
    let modale = $(this);

    $.ajax({
        url: '{{ url()->current() }}/list',
        type: "GET",
        beforeSend: function() {
            $(modale).find('#name').removeClass('is-invalid');
            $(modale).find('#checked').removeClass('is-invalid');
        },
        success: function(response) {
            $(modale).find("#name").focus();
            $(modale).find('#parse_permission').html(response.table);
            $(modale).find('#check_all_add').prop('checked', false);
        },
        error: function(response) {
            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.error(response.responseJSON.message);
        }
    });
});

$("#check_all_add").click(function() {
    $('#modal_add').find('input:checkbox').not(this).prop('checked', this.checked);
});

$('#modal_edit').on('shown.bs.modal', function(event) {
    let modale = $(this);
    let id = $(event.relatedTarget).data('id'); // Button that triggered the modal

    $.ajax({
        url: '{{ url()->current() }}/list/' + id,
        type: "GET",
        beforeSend: function() {
            $(modale).find('#name').removeClass('is-invalid');
            $(modale).find('#checked').removeClass('is-invalid');
        },
        success: function(response) {
            $(modale).find('#id').val(response.data.id);
            $(modale).find('#name').val(response.data.name);
            $(modale).find("#name").focus();
            $(modale).find('#parse_permission').html(response.table);
            $(modale).find('input').each(function() {
                $(this).removeClass('is-invalid');
            });
            $(modale).find('#check_all_edit').prop('checked', false);
        },
        error: function(response) {
            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.error(response.responseJSON.message);
        }
    });
});
$("#check_all_edit").click(function() {
    $('#modal_edit').find('input:checkbox').not(this).prop('checked', this.checked);
});
$('#modal_detail').on('shown.bs.modal', function(event) {
    let modale = $(this);
    let id = $(event.relatedTarget).data('id'); // Button that triggered the modal

    $.ajax({
        url: '{{ url()->current() }}/list/' + id + '/plain',
        type: "GET",
        success: function(response) {
            $(modale).find('#role_badge').html(response.data.role_badge);
            $(modale).find('#created_at').html(response.data.created_at);
            $(modale).find('#updated_at').html(response.data.updated_at);

            $(modale).find('#parse_permission').html(response.table);
        },
        error: function(response) {
            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.error(response.responseJSON.message);
        }
    });
});
</script>
@stack('jquery_delete')
@endpush
@endsection