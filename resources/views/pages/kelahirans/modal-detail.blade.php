
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('kelahiran') }}</h5>
<!--
                <button type="button" class="btn btn-info" onClick="window.print();">Print</button>
-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                @can('trash_kelahiran')
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
                                <td class="font-weight-bold">{{ __('nama_anak') }}</td>
                                <td>:</td>
                                <td id="nama_anak"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('jenis_kelamin') }}</td>
                                <td>:</td>
                                <td id="jenis_kelamin_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('ayah_nama') }}</td>
                                <td>:</td>
                                <td id="ayah_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('ayah_nik') }}</td>
                                <td>:</td>
                                <td id="ayah_nik"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('ibu_nama') }}</td>
                                <td>:</td>
                                <td id="ibu_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('ibu_nik') }}</td>
                                <td>:</td>
                                <td id="ibu_nik"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('hari_lahir') }}</td>
                                <td>:</td>
                                <td id="hari_lahir"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tempat_lahir') }}</td>
                                <td>:</td>
                                <td id="tempat_lahir"></td>
                            </tr>
</tbody></table></div><div class="col-6"><table class="table table-sm table_detail_left table-striped"><tbody>                            <tr>
                                <td class="font-weight-bold">{{ __('tanggal_lahir') }}</td>
                                <td>:</td>
                                <td id="tanggal_lahir"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('jam_lahir') }}</td>
                                <td>:</td>
                                <td id="jam_lahir"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('jenis_persalinan') }}</td>
                                <td>:</td>
                                <td id="jenis_persalinan_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('anak_ke') }}</td>
                                <td>:</td>
                                <td id="anak_ke"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('berat_bayi') }}</td>
                                <td>:</td>
                                <td id="berat_bayi"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('panjang_bayi') }}</td>
                                <td>:</td>
                                <td id="panjang_bayi"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tempat_dilahirkan') }}</td>
                                <td>:</td>
                                <td id="tempat_dilahirkan_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('penolong_kelahiran') }}</td>
                                <td>:</td>
                                <td id="penolong_kelahiran_nama"></td>
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
                $(modale).find('#nama_anak').html(response.data.nama_anak);
                $(modale).find('#jenis_kelamin_badge').html(response.data.jenis_kelamin_badge);
                $(modale).find('#ayah_nama').html(response.data.ayah?.nama);
                $(modale).find('#ayah_nik').html(response.data.ayah?.nik);
                $(modale).find('#ibu_nama').html(response.data.ibu?.nama);
                $(modale).find('#ibu_nik').html(response.data.ibu?.nik);
                $(modale).find('#hari_lahir').html(response.data.hari_lahir);
                $(modale).find('#tempat_lahir').html(response.data.tempat_lahir);
                $(modale).find('#tanggal_lahir').html(response.data.tanggal_lahir);
                $(modale).find('#jam_lahir').html(response.data.jam_lahir);
                $(modale).find('#jenis_persalinan_nama').html(response.data.jenis_persalinan?.nama);
                $(modale).find('#anak_ke').html(response.data.anak_ke);
                $(modale).find('#berat_bayi').html(response.data.berat_bayi);
                $(modale).find('#panjang_bayi').html(response.data.panjang_bayi);
                $(modale).find('#tempat_dilahirkan_nama').html(response.data.tempat_dilahirkan?.nama);
                $(modale).find('#penolong_kelahiran_nama').html(response.data.penolong_kelahiran?.nama);
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