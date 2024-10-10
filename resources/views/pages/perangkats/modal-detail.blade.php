
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('perangkat') }}</h5>
<!--
                <button type="button" class="btn btn-info" onClick="window.print();">Print</button>
-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                @can('trash_perangkat')
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
                    <div class="col-6"><table class="table table-sm table_detail_left table-striped"><tbody>                            <tr>
                                <td class="font-weight-bold">{{ __('penduduk_nama') }}</td>
                                <td>:</td>
                                <td id="penduduk_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('penduduk_nik') }}</td>
                                <td>:</td>
                                <td id="penduduk_nik"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('jabatan') }}</td>
                                <td>:</td>
                                <td id="jabatan_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('nipd') }}</td>
                                <td>:</td>
                                <td id="nipd"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('nip') }}</td>
                                <td>:</td>
                                <td id="nip"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('pangkat_golongan') }}</td>
                                <td>:</td>
                                <td id="pangkat_golongan"></td>
                            </tr>
</tbody></table></div><div class="col-6"><table class="table table-sm table_detail_left table-striped"><tbody>                            <tr>
                                <td class="font-weight-bold">{{ __('no_keputusan_pengangkatan') }}</td>
                                <td>:</td>
                                <td id="no_keputusan_pengangkatan"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tanggal_keputusan_pengangkatan') }}</td>
                                <td>:</td>
                                <td id="tanggal_keputusan_pengangkatan"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('no_keputusan_pemberhentian') }}</td>
                                <td>:</td>
                                <td id="no_keputusan_pemberhentian"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tanggal_keputusan_pemberhentian') }}</td>
                                <td>:</td>
                                <td id="tanggal_keputusan_pemberhentian"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('status_pejabat') }}</td>
                                <td>:</td>
                                <td id="status_pejabat_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('masa_jabatan') }}</td>
                                <td>:</td>
                                <td id="masa_jabatan"></td>
                            </tr>
</tbody></table></div>
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
                $(modale).find('#penduduk_nama').html(response.data.penduduk?.nama);
                $(modale).find('#penduduk_nik').html(response.data.penduduk?.nik);
                $(modale).find('#jabatan_nama').html(response.data.jabatan?.nama);
                $(modale).find('#nipd').html(response.data.nipd);
                $(modale).find('#nip').html(response.data.nip);
                $(modale).find('#pangkat_golongan').html(response.data.pangkat_golongan);
                $(modale).find('#no_keputusan_pengangkatan').html(response.data.no_keputusan_pengangkatan);
                $(modale).find('#tanggal_keputusan_pengangkatan').html(response.data.tanggal_keputusan_pengangkatan);
                $(modale).find('#no_keputusan_pemberhentian').html(response.data.no_keputusan_pemberhentian);
                $(modale).find('#tanggal_keputusan_pemberhentian').html(response.data.tanggal_keputusan_pemberhentian);
                $(modale).find('#status_pejabat_badge').html(response.data.status_pejabat_badge);
                $(modale).find('#masa_jabatan').html(response.data.masa_jabatan);
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