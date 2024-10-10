<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */
?>
@extends('layouts.app', ['title' => __('site.permission') ])
@section('content')
@push('styles')
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('site.permission') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('site.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('site.permission') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-12 col-md-6">
                                @can('create_permissions')
                                <button type="button" class="btn btn-icon icon-left btn-primary mr-2"
                                    data-toggle="modal" data-target="#modal_add"><i class="fas fa-plus"></i>
                                    {{ __('site.add') }} {{ __('site.permission') }}
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
                                        <th>{{ __('site.role_list') }}</th>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.add_new') }} {{ __('site.permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_add">
                    <div class="form-group">
                        <label>{{ __('site.name') }}</label>
                        <br/>
                        <code>create_* delete_* edit_* view_* trash_*</code>
                        <input type="text" id="name" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
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

<div class="modal fade" id="modal_edit" tabindex="0" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.edit') }} {{ __('site.permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <span>
                        <div class="alert-title">{{ __('site.warning') }}</div>
                        {{ __('site.sure_edit_permission') }}
                    </span>
                </div>
                <form action="#" method="POST" id="form_add">
                    <input type="hidden" id="id" value="">
                    <div class="form-group">
                        <label>{{ __('site.name') }}</label>
                        <input type="text" id="name" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
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
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('site.permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table_detail_left">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">{{ __('site.name') }}</td>
                            <td>:</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{ __('site.guard') }}</td>
                            <td>:</td>
                            <td id="guard_name"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{ __('site.role_list') }}</td>
                            <td>:</td>
                            <td id="roles_list"></td>
                        </tr>
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
    language: {
            url: "{{ asset('modules/datatables/i18n/'.app()->getLocale().'.json') }}",
    },
    ajax: {
        url: '{{ route('permissions.datatables') }}',
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
            data: 'permission_badge',
            name: 'permission_badge'
        },
        {
            data: 'guard_name',
            name: 'guard_name',
            className: "dt-nowrap",
        },
        {
            data: 'roles_list',
            name: 'roles_list'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            width: '10%'
        }
    ]
});

$('#button_create').click(function() {
    let modale = $("#modal_add");
    let buttone = $(this);

    $.ajax({
        url: '{{ route('permissions.store') }}',
        type: "POST",
        data: {
            "name": $(modale).find("#name").val(),
        },
        beforeSend: function() {
            $(modale).find('input').each(function() {
                $(this).removeClass('is-invalid');
            })
        },
        success: function(response) {
            $(modale).find('form')[0].reset();
            $(modale).find("input:text:visible").first().focus();

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

    $.ajax({
        url: '{{ url()->current() }}/' + $(modale).find('#id').val(),
        type: "PUT",
        data: {
            "name": $(modale).find("#name").val(),
        },
        beforeSend: function() {
            $(modale).find('input').each(function() {
                $(this).removeClass('is-invalid');
            })
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

    $(modale).find("input:text:visible").first().focus();
    $(modale).find('form')[0].reset();
    $(modale).find('input').each(function() {
        $(this).removeClass('is-invalid');
    });
    $(modale).modal('show');
});

$('#modal_edit').on('shown.bs.modal', function(event) {
    let modale = $(this);
    let id = $(event.relatedTarget).data('id'); // Button that triggered the modal

    $(modale).find('input').each(function() {
        $(this).removeClass('is-invalid');
    });

    $.ajax({
        url: '{{ url()->current() }}/' + id,
        type: "GET",
        success: function(response) {
            //fill data to form
            $(modale).find('#id').val(response.data.id);
            $(modale).find('#name').val(response.data.name);
        },
        error: function(response) {
            toastr.options = {
                "positionClass": "toast-bottom-right"
            }
            toastr.error(response.responseJSON.message);
        }
    });
});
$('#modal_detail').on('shown.bs.modal', function(event) {
    let modale = $(this);
    let id = $(event.relatedTarget).data('id'); // Button that triggered the modal

    $.ajax({
        url: '{{ url()->current() }}/' + id,
        type: "GET",
        success: function(response) {
            $(modale).find('#name').html(response.data.permission_badge);
            $(modale).find('#guard_name').html(response.data.guard_name);
            $(modale).find('#roles_list').html(response.data.roles_list);
            $(modale).find('#created_at').html(response.data.created_at);
            $(modale).find('#updated_at').html(response.data.updated_at);
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