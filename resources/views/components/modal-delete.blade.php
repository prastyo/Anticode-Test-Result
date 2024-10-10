<!-- modal delete -->
<div class="modal fade" id="modal_delete" tabindex="0" role="dialog" aria-labelledby="modal_delete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.confirm_delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id">
                {{ __('site.confirm_sure') }} <mark><strong class="parse_delete_info text-danger"></strong></mark> ?
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button id="button_destroy" type="button" class="btn btn-icon icon-left btn-danger mr-auto"><i class="fas fa-times"></i> {{ __('site.yes_delete') }}</button>
                <button type="button" class="btn btn-icon icon-left btn-secondary" data-dismiss="modal">{{ __('site.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@push('jquery_delete')
<script>
$('#button_destroy').click(function(event) {
    let modale = $("#modal_delete");

    $.ajax({
        url: '{{ url()->current() }}',
        type: "DELETE",
        data: {
                id: $(modale).find('#id').val()
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
    $(modale).modal('hide');
});

$('#modal_delete').on('shown.bs.modal', function(event) {
    let id = $(event.relatedTarget).data('id'); // Button that triggered the modal
    let delete_info = $(event.relatedTarget).data('delete_info'); // Button that triggered the modal

    $(this).find('#id').val(id);
    $(this).find('.parse_delete_info').html(delete_info);
});
</script>
@endpush
<!-- end modal delete -->