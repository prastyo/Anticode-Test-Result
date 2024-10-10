
<div class="modal fade" id="modal_detail" tabindex="0" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.detail') }} {{ __('penduduk') }}</h5>
<!--
                <button type="button" class="btn btn-info" onClick="window.print();">Print</button>
-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                @can('trash_penduduk')
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
                                <td class="font-weight-bold">{{ __('nama') }}</td>
                                <td>:</td>
                                <td id="nama"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('nik') }}</td>
                                <td>:</td>
                                <td id="nik"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tempat_lahir') }}</td>
                                <td>:</td>
                                <td id="tempat_lahir"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('tanggal_lahir') }}</td>
                                <td>:</td>
                                <td id="tanggal_lahir"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('jenis_kelamin') }}</td>
                                <td>:</td>
                                <td id="jenis_kelamin_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('agama') }}</td>
                                <td>:</td>
                                <td id="agama_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('telepon') }}</td>
                                <td>:</td>
                                <td id="telepon"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('email') }}</td>
                                <td>:</td>
                                <td id="email"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('identitas_elektronik') }}</td>
                                <td>:</td>
                                <td id="identitas_elektronik_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('hubungan_keluarga') }}</td>
                                <td>:</td>
                                <td id="hubungan_keluarga_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('rt') }}</td>
                                <td>:</td>
                                <td id="rt"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('rw') }}</td>
                                <td>:</td>
                                <td id="rw"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('alamat') }}</td>
                                <td>:</td>
                                <td id="alamat"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('kodepos') }}</td>
                                <td>:</td>
                                <td id="kodepos"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('pendidikan') }}</td>
                                <td>:</td>
                                <td id="pendidikan_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('nik_ayah') }}</td>
                                <td>:</td>
                                <td id="nik_ayah"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('nama_ayah') }}</td>
                                <td>:</td>
                                <td id="nama_ayah"></td>
                            </tr>
</tbody></table></div><div class="col-6"><table class="table table-sm table_detail_left table-striped"><tbody>                            <tr>
                                <td class="font-weight-bold">{{ __('nik_ibu') }}</td>
                                <td>:</td>
                                <td id="nik_ibu"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('nama_ibu') }}</td>
                                <td>:</td>
                                <td id="nama_ibu"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('akte_kelahiran') }}</td>
                                <td>:</td>
                                <td id="akte_kelahiran_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('kawin') }}</td>
                                <td>:</td>
                                <td id="kawin_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('akseptor_kb') }}</td>
                                <td>:</td>
                                <td id="akseptor_kb_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('pekerjaan') }}</td>
                                <td>:</td>
                                <td id="pekerjaan_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('sakit_menahun') }}</td>
                                <td>:</td>
                                <td id="sakit_menahun_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('cacat') }}</td>
                                <td>:</td>
                                <td id="cacat_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('kelainan_fisik_mental') }}</td>
                                <td>:</td>
                                <td id="kelainan_fisik_mental_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('golongan_darah') }}</td>
                                <td>:</td>
                                <td id="golongan_darah_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('warganegara') }}</td>
                                <td>:</td>
                                <td id="warganegara_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('asuransi') }}</td>
                                <td>:</td>
                                <td id="asuransi_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('status_penduduk') }}</td>
                                <td>:</td>
                                <td id="status_penduduk_badge"></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('status_dasar') }}</td>
                                <td>:</td>
                                <td id="status_dasar_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('suku') }}</td>
                                <td>:</td>
                                <td id="suku_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('kursus') }}</td>
                                <td>:</td>
                                <td id="kursus_nama"></td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('bahasa') }}</td>
                                <td>:</td>
                                <td id="bahasa_nama"></td>
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
                $(modale).find('#nama').html(response.data.nama);
                $(modale).find('#nik').html(response.data.nik);
                $(modale).find('#tempat_lahir').html(response.data.tempat_lahir);
                $(modale).find('#tanggal_lahir').html(response.data.tanggal_lahir);
                $(modale).find('#jenis_kelamin_badge').html(response.data.jenis_kelamin_badge);
                $(modale).find('#agama_nama').html(response.data.agama?.nama);
                $(modale).find('#telepon').html(response.data.telepon);
                $(modale).find('#email').html(response.data.email);
                $(modale).find('#identitas_elektronik_badge').html(response.data.identitas_elektronik_badge);
                $(modale).find('#hubungan_keluarga_nama').html(response.data.hubungan_keluarga?.nama);
                $(modale).find('#rt').html(response.data.rt);
                $(modale).find('#rw').html(response.data.rw);
                $(modale).find('#alamat').html(response.data.alamat);
                $(modale).find('#kodepos').html(response.data.kodepos);
                $(modale).find('#pendidikan_nama').html(response.data.pendidikan?.nama);
                $(modale).find('#nik_ayah').html(response.data.nik_ayah);
                $(modale).find('#nama_ayah').html(response.data.nama_ayah);
                $(modale).find('#nik_ibu').html(response.data.nik_ibu);
                $(modale).find('#nama_ibu').html(response.data.nama_ibu);
                $(modale).find('#akte_kelahiran_badge').html(response.data.akte_kelahiran_badge);
                $(modale).find('#kawin_nama').html(response.data.kawin?.nama);
                $(modale).find('#akseptor_kb_nama').html(response.data.akseptor_kb?.nama);
                $(modale).find('#pekerjaan_nama').html(response.data.pekerjaan?.nama);
                $(modale).find('#sakit_menahun_nama').html(response.data.sakit_menahun?.nama);
                $(modale).find('#cacat_nama').html(response.data.cacat?.nama);
                $(modale).find('#kelainan_fisik_mental_badge').html(response.data.kelainan_fisik_mental_badge);
                $(modale).find('#golongan_darah_nama').html(response.data.golongan_darah?.nama);
                $(modale).find('#warganegara_nama').html(response.data.warganegara?.nama);
                $(modale).find('#asuransi_nama').html(response.data.asuransi?.nama);
                $(modale).find('#status_penduduk_badge').html(response.data.status_penduduk_badge);
                $(modale).find('#status_dasar_nama').html(response.data.status_dasar?.nama);
                $(modale).find('#suku_nama').html(response.data.suku?.nama);
                $(modale).find('#kursus_nama').html(response.data.kursus?.nama);
                $(modale).find('#bahasa_nama').html(response.data.bahasa?.nama);
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