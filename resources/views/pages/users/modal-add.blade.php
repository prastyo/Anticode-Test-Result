
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.add_new') }} {{ __('users') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_add">
                    <div class="form-group">
            <label>{{ __('site.role') }}</label>
            <select name="role_name" id="role_name" class="form-control">
            <option value="">{{ __('site.select_option') }}</option>
            @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
                    <div class="form-group">
                    <label>{{ __('name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('username') }}</label>
                    <input type="text" name="username" id="username" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('email') }}</label>
                    <input type="text" name="email" id="email" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('bio') }}</label>
                    <input type="text" name="bio" id="bio" class="form-control" value="">
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
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-icon icon-left btn-outline-secondary mr-auto" data-dismiss="modal">{{ __('site.cancel') }}</button>
                <button type="button" class="btn btn-icon icon-left btn-success" id="button_create"><i class="fas fa-check"></i> {{ __('site.submit') }}</button>
            </div>
        </div>
    </div>
</div>
@push('jquery_add')
<script>
$('#button_create').click(function() {
        let modale = $("#modal_add");
        let buttone = $(this);

        $.ajax({
            url: '{{ route('users.store') }}',
            type: "POST",
            data:{
                "role_name": $(modale).find("#role_name").val(),
                "name": $(modale).find("#name").val(),
                "username": $(modale).find("#username").val(),
                "email": $(modale).find("#email").val(),
                "bio": $(modale).find("#bio").val(),
                "password": $(modale).find("#password").val(),
                "password_confirmation": $(modale).find("#password_confirmation").val(),
            },
            beforeSend: function() {
                $(modale).find(':input').each(function() {
                    $(this).removeClass('is-invalid');
                })
            },
            success: function(response) {
                $(modale).find('form')[0].reset();
                $(modale).find("input:visible").first().focus();
                

                table.draw(); //reload datatables after success

                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.success(response.message);
            },
            error: function(response) {
                $.each(response.responseJSON.errors, function(field_name, error) {
                    $(modale).find('#' + field_name).addClass('is-invalid');
                    $(modale).find('#' + field_name).siblings('.invalid-feedback').html(error[0]);
                });
                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.error(response.responseJSON.message);
            }
        });
    });

    $('#modal_add').on('shown.bs.modal', function(event) {
        let modale = $(this);
        
        $(modale).find("input:text:visible").first().focus();
        $(modale).find('form')[0].reset();
        $(modale).find(':input').each(function() {
            $(this).removeClass('is-invalid');
        });
        $(modale).modal('show');
    });
</script>
@endpush