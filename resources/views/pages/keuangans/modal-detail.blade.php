
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('keuangan') }}</h5>
<!--
                <button type="button" class="btn btn-info" onClick="window.print();">Print</button>
-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                @can('trash_keuangan')
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
                                <td class="font-weight-bold">{{ __('tahun_anggaran') }}</td>
                                <td>:</td>
                                <td id="tahun_anggaran"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('jenis_keuangan') }}</td>
                                <td>:</td>
                                <td id="jenis_keuangan_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('nilai_anggaran') }}</td>
                                <td>:</td>
                                <td id="nilai_anggaran"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('nilai_realisasi') }}</td>
                                <td>:</td>
                                <td id="nilai_realisasi"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('keterangan') }}</td>
                                <td>:</td>
                                <td id="keterangan"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tanggal_kuitansi') }}</td>
                                <td>:</td>
                                <td id="tanggal_kuitansi"></td>
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
                $(modale).find('#tahun_anggaran').html(response.data.tahun_anggaran);
                $(modale).find('#jenis_keuangan_badge').html(response.data.jenis_keuangan_badge);
                $(modale).find('#nilai_anggaran').html(response.data.nilai_anggaran);
                $(modale).find('#nilai_realisasi').html(response.data.nilai_realisasi);
                $(modale).find('#keterangan').html(response.data.keterangan);
                $(modale).find('#tanggal_kuitansi').html(response.data.tanggal_kuitansi);
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