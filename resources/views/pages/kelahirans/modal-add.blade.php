
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.add_new') }} {{ __('kelahiran') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_add">
                    <div class="row"><div class="col-6"><div class="form-group">
                    <label>{{ __('nama_anak') }}</label>
                    <input type="text" name="nama_anak" id="nama_anak" class="form-control" value="">
                    <div class="invalid-feedback"></div>
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
                    <label>{{ __('ayah') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm col-6" id="ayah_id" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-parse_search="ayah_id" data-target="#modal_search_Penduduk"><i class="fas fa-search"></i> Find</button>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <table class="table table-sm table_detail_left table-striped scrolldown">
                        <tbody id="parse_search_ayah_id"></tbody>
                    </table>
                    </div>
                <div class="form-group">
                    <label>{{ __('ibu') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm col-6" id="ibu_id" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-parse_search="ibu_id" data-target="#modal_search_Penduduk"><i class="fas fa-search"></i> Find</button>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <table class="table table-sm table_detail_left table-striped scrolldown">
                        <tbody id="parse_search_ibu_id"></tbody>
                    </table>
                    </div>
                <div class="form-group">
                    <label>{{ __('hari_lahir') }}</label>
                    <input type="text" name="hari_lahir" id="hari_lahir" class="form-control" value="">
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
                </div><div class="col-6"><div class="form-group">
                    <label>{{ __('jam_lahir') }}</label>
                    <div class="input-group">
                        <input type="text" name="jam_lahir" id="jam_lahir" class="form-control col-6 time">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('jenis_persalinan') }}</label>
                    <select name="jenis_persalinan_id" id="jenis_persalinan_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataJenisPersalinan as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('anak_ke') }}</label>
                    <input type="text" name="anak_ke" id="anak_ke" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('berat_bayi') }}</label>
                    <input type="text" name="berat_bayi" id="berat_bayi" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('panjang_bayi') }}</label>
                    <input type="text" name="panjang_bayi" id="panjang_bayi" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('tempat_dilahirkan') }}</label>
                    <select name="tempat_dilahirkan_id" id="tempat_dilahirkan_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataTempatDilahirkan as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('penolong_kelahiran') }}</label>
                    <select name="penolong_kelahiran_id" id="penolong_kelahiran_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataPenolongKelahiran as $key => $item)
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
            url: '{{ route('kelahirans.store') }}',
            type: "POST",
            data:{
                "nama_anak": $(modale).find("#nama_anak").val(),
                "jenis_kelamin": $(modale).find("#jenis_kelamin").val(),
                "ayah_id": $(modale).find("#ayah_id").val(),
                "ibu_id": $(modale).find("#ibu_id").val(),
                "hari_lahir": $(modale).find("#hari_lahir").val(),
                "tempat_lahir": $(modale).find("#tempat_lahir").val(),
                "tanggal_lahir": $(modale).find("#tanggal_lahir").val(),
                "jam_lahir": $(modale).find("#jam_lahir").val(),
                "jenis_persalinan_id": $(modale).find("#jenis_persalinan_id").val(),
                "anak_ke": $(modale).find("#anak_ke").val(),
                "berat_bayi": $(modale).find("#berat_bayi").val(),
                "panjang_bayi": $(modale).find("#panjang_bayi").val(),
                "tempat_dilahirkan_id": $(modale).find("#tempat_dilahirkan_id").val(),
                "penolong_kelahiran_id": $(modale).find("#penolong_kelahiran_id").val(),
            },
            beforeSend: function() {
                $(modale).find(':input').each(function() {
                    $(this).removeClass('is-invalid');
                })
            },
            success: function(response) {
                $(modale).find('form')[0].reset();
                $(modale).find("input:visible").first().focus();
                $('#modal_add').find("#parse_search_ayah_id").html('');
                $('#modal_add').find("#parse_search_ibu_id").html('');

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
        $('#modal_add').find("#parse_search_ayah_id").html('');
                $('#modal_add').find("#parse_search_ibu_id").html('');
        $(modale).find("input:text:visible").first().focus();
        $(modale).find('form')[0].reset();
        $(modale).find(':input').each(function() {
            $(this).removeClass('is-invalid');
        });
        $(modale).modal('show');
    });
</script>
@endpush