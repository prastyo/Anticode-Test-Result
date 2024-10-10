
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('data_pekerjaan') }}</h5>
<!--
                <button type="button" class="btn btn-info" onClick="window.print();">Print</button>
-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                @can('trash_data_pekerjaan')
                <div class="card mr-5 ml-5" id="detail_softdelete" style="display: none;">
                    <div class="card-header text-white bg-danger">
                        <div style="display: flex; flex-direction: column;">
                            <div><span class="font-weight-bold">{{ __('site.deleted_at') }}</span> <span id="deleted_at"></span></div>
                            <div><span class="font-weight-bold">{{ __('site.deleted_by') }}</span> <span id="deleted_by"></span></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="id" value="">
                        <button type="button" class="btn btn-sm btn-icon icon-left btn-dark" id="button_delete_permanently" data-dismiss="modal"><i class="fas fa-close"></i> {{ __('site.delete_permanently') }}</button>
                        <button type="button" class="btn btn-sm btn-icon icon-left btn-success float-right" id="button_restore" data-dismiss="modal"><i class="fas fa-arrow-rotate-left"></i> {{ __('site.restore') }}</button>
                    </div>
                </div>
                @endcan
                <div class="row">
                    
                    <table class="table table-sm table_detail_left table-striped">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">{{ __('nama') }}</td>
                                <td>:</td>
                                <td id="nama"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke no-padding">
                <div class="mr-auto">
                    <small class="font-weight-bold">{{ __('site.created_at') }}</small>
                    <small class="text-muted" id="created_at"></small><br/>
                    <small class="font-weight-bold">{{ __('site.created_by') }}</small>
                    <small class="text-muted" id="created_by"></small>
                </div>
                <div>
                    <small class="font-weight-bold">{{ __('site.updated_at') }}</small>
                    <small class="text-muted" id="updated_at"></small><br/>
                    <small class="font-weight-bold">{{ __('site.updated_by') }}</small>
                    <small class="text-muted" id="updated_by"></small>
                </div>
            </div>
        </div>
    </div>
</div>
@push('jquery_detail')
<script>
    $('#modal_detail').on('shown.bs.modal', function(event) {
        let modale = $(this);
        let id = $(event.relatedTarget).data('id'); // Button that triggered the modal

        $.ajax({
            url: '{{ url()->current() }}/' + id,
            type: "GET",
            success: function(response) {
                $(modale).find('#id').val(id);
                $(modale).find('#nama').html(response.data.nama);
                $(modale).find('#created_at').html(response.data.created_at);
                $(modale).find('#updated_at').html(response.data.updated_at);
                $(modale).find('#created_by').html(response.data.created_by?.name);
                $(modale).find('#updated_by').html(response.data.updated_by?.name);

                $(modale).find('#deleted_at').html(response.data.deleted_at);
                $(modale).find('#deleted_by').html(response.data.deleted_by?.name);
                $('#detail_softdelete').toggle(response.data.deleted_at != null);
            },
            error: function(response) {
                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.error(response.responseJSON.message);
            }
        });
    });
</script>
@endpush