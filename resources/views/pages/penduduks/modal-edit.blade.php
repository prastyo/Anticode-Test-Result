
<div class="modal fade" id="modal_edit" tabindex="0" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.edit') }} {{ __('penduduk') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_edit">
                    <input type="hidden" id="id" value="">
                    <div class="row"><div class="col-6"><div class="form-group">
                    <label>{{ __('nama') }}</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nik') }}</label>
                    <input type="text" name="nik" id="nik" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('tempat_lahir') }}</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('tanggal_lahir') }}</label>
                    <div class="input-group">
                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control col-6 date">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('jenis_kelamin') }}</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\JenisKelaminEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('agama') }}</label>
                    <select name="agama_id" id="agama_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataAgama as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('telepon') }}</label>
                    <input type="text" name="telepon" id="telepon" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('email') }}</label>
                    <input type="text" name="email" id="email" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('identitas_elektronik') }}</label>
                    <select name="identitas_elektronik" id="identitas_elektronik" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\IdentitasElektronikEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('hubungan_keluarga') }}</label>
                    <select name="hubungan_keluarga_id" id="hubungan_keluarga_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataHubunganKeluarga as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('rt') }}</label>
                    <input type="text" name="rt" id="rt" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('rw') }}</label>
                    <input type="text" name="rw" id="rw" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('alamat') }}</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('kodepos') }}</label>
                    <input type="text" name="kodepos" id="kodepos" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('pendidikan') }}</label>
                    <select name="pendidikan_id" id="pendidikan_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataPendidikan as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nik_ayah') }}</label>
                    <input type="text" name="nik_ayah" id="nik_ayah" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nama_ayah') }}</label>
                    <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                </div><div class="col-6"><div class="form-group">
                    <label>{{ __('nik_ibu') }}</label>
                    <input type="text" name="nik_ibu" id="nik_ibu" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nama_ibu') }}</label>
                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('akte_kelahiran') }}</label>
                    <select name="akte_kelahiran" id="akte_kelahiran" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\AkteKelahiranEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('kawin') }}</label>
                    <select name="kawin_id" id="kawin_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataKawin as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('akseptor_kb') }}</label>
                    <select name="akseptor_kb_id" id="akseptor_kb_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataAkseptorKb as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('pekerjaan') }}</label>
                    <select name="pekerjaan_id" id="pekerjaan_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataPekerjaan as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('sakit_menahun') }}</label>
                    <select name="sakit_menahun_id" id="sakit_menahun_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataSakitMenahun as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('cacat') }}</label>
                    <select name="cacat_id" id="cacat_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataCacat as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('kelainan_fisik_mental') }}</label>
                    <select name="kelainan_fisik_mental" id="kelainan_fisik_mental" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\KelainanFisikMentalEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('golongan_darah') }}</label>
                    <select name="golongan_darah_id" id="golongan_darah_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataGolonganDarah as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('warganegara') }}</label>
                    <select name="warganegara_id" id="warganegara_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataWarganegara as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('asuransi') }}</label>
                    <select name="asuransi_id" id="asuransi_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataAsuransi as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('status_penduduk') }}</label>
                    <select name="status_penduduk" id="status_penduduk" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\StatusPendudukEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('status_dasar') }}</label>
                    <select name="status_dasar_id" id="status_dasar_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataStatusDasar as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('suku') }}</label>
                    <select name="suku_id" id="suku_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataSuku as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('kursus') }}</label>
                    <select name="kursus_id" id="kursus_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataKursu as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('bahasa') }}</label>
                    <select name="bahasa_id" id="bahasa_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataBahasa as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                </div></div>
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
                "nik": $(modale).find("#nik").val(),
                "tempat_lahir": $(modale).find("#tempat_lahir").val(),
                "tanggal_lahir": $(modale).find("#tanggal_lahir").val(),
                "jenis_kelamin": $(modale).find("#jenis_kelamin").val(),
                "agama_id": $(modale).find("#agama_id").val(),
                "telepon": $(modale).find("#telepon").val(),
                "email": $(modale).find("#email").val(),
                "identitas_elektronik": $(modale).find("#identitas_elektronik").val(),
                "hubungan_keluarga_id": $(modale).find("#hubungan_keluarga_id").val(),
                "rt": $(modale).find("#rt").val(),
                "rw": $(modale).find("#rw").val(),
                "alamat": $(modale).find("#alamat").val(),
                "kodepos": $(modale).find("#kodepos").val(),
                "pendidikan_id": $(modale).find("#pendidikan_id").val(),
                "nik_ayah": $(modale).find("#nik_ayah").val(),
                "nama_ayah": $(modale).find("#nama_ayah").val(),
                "nik_ibu": $(modale).find("#nik_ibu").val(),
                "nama_ibu": $(modale).find("#nama_ibu").val(),
                "akte_kelahiran": $(modale).find("#akte_kelahiran").val(),
                "kawin_id": $(modale).find("#kawin_id").val(),
                "akseptor_kb_id": $(modale).find("#akseptor_kb_id").val(),
                "pekerjaan_id": $(modale).find("#pekerjaan_id").val(),
                "sakit_menahun_id": $(modale).find("#sakit_menahun_id").val(),
                "cacat_id": $(modale).find("#cacat_id").val(),
                "kelainan_fisik_mental": $(modale).find("#kelainan_fisik_mental").val(),
                "golongan_darah_id": $(modale).find("#golongan_darah_id").val(),
                "warganegara_id": $(modale).find("#warganegara_id").val(),
                "asuransi_id": $(modale).find("#asuransi_id").val(),
                "status_penduduk": $(modale).find("#status_penduduk").val(),
                "status_dasar_id": $(modale).find("#status_dasar_id").val(),
                "suku_id": $(modale).find("#suku_id").val(),
                "kursus_id": $(modale).find("#kursus_id").val(),
                "bahasa_id": $(modale).find("#bahasa_id").val(),
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
                $(modale).find('#nik').val(response.data.nik);
                $(modale).find('#tempat_lahir').val(response.data.tempat_lahir);
                $(modale).find('#tanggal_lahir').val(response.data.tanggal_lahir_original);
                $(modale).find('#jenis_kelamin').val(response.data.jenis_kelamin);
                $(modale).find('#agama_id').val(response.data.agama_id);
                $(modale).find('#telepon').val(response.data.telepon);
                $(modale).find('#email').val(response.data.email);
                $(modale).find('#identitas_elektronik').val(response.data.identitas_elektronik);
                $(modale).find('#hubungan_keluarga_id').val(response.data.hubungan_keluarga_id);
                $(modale).find('#rt').val(response.data.rt);
                $(modale).find('#rw').val(response.data.rw);
                $(modale).find('#alamat').val(response.data.alamat);
                $(modale).find('#kodepos').val(response.data.kodepos);
                $(modale).find('#pendidikan_id').val(response.data.pendidikan_id);
                $(modale).find('#nik_ayah').val(response.data.nik_ayah);
                $(modale).find('#nama_ayah').val(response.data.nama_ayah);
                $(modale).find('#nik_ibu').val(response.data.nik_ibu);
                $(modale).find('#nama_ibu').val(response.data.nama_ibu);
                $(modale).find('#akte_kelahiran').val(response.data.akte_kelahiran);
                $(modale).find('#kawin_id').val(response.data.kawin_id);
                $(modale).find('#akseptor_kb_id').val(response.data.akseptor_kb_id);
                $(modale).find('#pekerjaan_id').val(response.data.pekerjaan_id);
                $(modale).find('#sakit_menahun_id').val(response.data.sakit_menahun_id);
                $(modale).find('#cacat_id').val(response.data.cacat_id);
                $(modale).find('#kelainan_fisik_mental').val(response.data.kelainan_fisik_mental);
                $(modale).find('#golongan_darah_id').val(response.data.golongan_darah_id);
                $(modale).find('#warganegara_id').val(response.data.warganegara_id);
                $(modale).find('#asuransi_id').val(response.data.asuransi_id);
                $(modale).find('#status_penduduk').val(response.data.status_penduduk);
                $(modale).find('#status_dasar_id').val(response.data.status_dasar_id);
                $(modale).find('#suku_id').val(response.data.suku_id);
                $(modale).find('#kursus_id').val(response.data.kursus_id);
                $(modale).find('#bahasa_id').val(response.data.bahasa_id);
                
            },
            error: function(response) {
                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.error(response.responseJSON.message);
            }
        });
    });
</script>
@endpush