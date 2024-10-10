
<div class="modal fade" id="modal_edit" tabindex="0" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.edit') }} {{ __('data_status_dasar') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_edit">
                    <input type="hidden" id="id" value="">
                    <div class="form-group">
                    <label>{{ __('nama') }}</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-icon icon-left btn-outline-secondary mr-auto" data-dismiss="modal">{{ __('site.cancel') }}</button>
                <button type="button" class="btn btn-icon icon-left btn-success" id="button_update"><i class="fas fa-refresh"></i> {{ __('site.update') }}</button>
            </div>
        </div>
    </div>
</div>
@push('jquery_edit')
<script>
    $('#button_update').click(function() {
        let modale = $('#modal_edit');
        let buttone = $(this);

        $.ajax({
            url: '{{ url()->current() }}/' + $(modale).find('#id').val(),
            type: "PUT",
            data: {
                "nama": $(modale).find("#nama").val(),
            },
            beforeSend: function() {
                $(modale).find(':input').each(function() {
                    $(this).removeClass('is-invalid');
                })
            },
            success: function(response) {
                table.draw(); //reload datatables after success

                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.success(response.message);

                $(modale).modal('hide');
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
    $('#modal_edit').on('shown.bs.modal', function(event) {
        let modale = $(this);
        let id = $(event.relatedTarget).data('id'); // Button that triggered the modal

        $(modale).find(':input').each(function() {
            $(this).removeClass('is-invalid');
        });
        $(modale).find('form')[0].reset();

        $.ajax({
            url: '{{ url()->current() }}/' + id,
            type: "GET",
            success: function(response) {
                //fill data to form
                $(modale).find('#id').val(response.data.id);
                $(modale).find('#nama').val(response.data.nama);
                
            },
            error: function(response) {
                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.error(response.responseJSON.message);
            }
        });
    });
</script>
@endpush