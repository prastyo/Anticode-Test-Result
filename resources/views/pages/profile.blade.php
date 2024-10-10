<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */
?>
@extends('layouts.app', ['title' => __('site.profile')])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('site.profile') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">{{ __('site.dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('site.profile') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-body">
                            <form id="form_profile" action="{{ route('profile.update') }}" method="POST">
                                <div class="form-group">
                    <label>{{ __('name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}">
                    <div class="invalid-feedback"></div>
                </div>
                    <div class="form-group">
                    <label>{{ __('username') }}</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ auth()->user()->username }}">
                    <div class="invalid-feedback"></div>
                </div>
                    <div class="form-group">
                    <label>{{ __('email') }}</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}">
                    <div class="invalid-feedback"></div>
                </div>
                    <div class="form-group">
                    <label>{{ __('bio') }}</label>
                    <input type="text" name="bio" id="bio" class="form-control" value="{{ auth()->user()->bio }}">
                    <div class="invalid-feedback"></div>
                </div>
                    <div class="form-group">
                                    <label for="password">{{ __('password') }}</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <!-- <small class="text-muted">Leave blank if you don't want to change it.</small> -->
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('password_confirm') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation">
                                    <div class="invalid-feedback"></div>
                                </div>                                    
                            </form>
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <button type="button" class="btn btn-icon icon-left float-right btn-success"
                                id="button_update"><i class="fas fa-refresh"></i> {{ __('site.update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#button_update').click(function() {
                    let buttone = $(this);
                    let form = $('#form_profile');

                    $.ajax({
                        url: '{{ url()->current() }}',
                        type: "PUT",
                        data: {
                            "name": $("#name").val(),
                "username": $("#username").val(),
                "email": $("#email").val(),
                "bio": $("#bio").val(),
                "password": $("#password").val(),
                "password_confirmation": $("#password_confirmation").val(),

							"password": $(form).find("#password").val(),
							"password_confirmation": $(form).find("#password_confirmation").val(),
                        },
                        beforeSend: function() {
                            $(form).find('input').each(function() {
                                $(this).removeClass('is-invalid');
                            })
                        },
                        success: function(response) {
                            $(form).find("input:text:visible").first().focus();

                            toastr.options = {"positionClass": "toast-bottom-right"}
                            toastr.success(response.message);
                        },
                        error: function(response) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(form).find('#' + field_name).addClass('is-invalid');
                                $(form).find('#' + field_name).siblings(
                                    '.invalid-feedback').html(error[0]);
                            });

                            toastr.options = {"positionClass": "toast-bottom-right"}
                            toastr.error(response.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
