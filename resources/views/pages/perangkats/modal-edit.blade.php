
<div class="modal fade" id="modal_edit" tabindex="0" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.edit') }} {{ __('perangkat') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_edit">
                    <input type="hidden" id="id" value="">
                    <div class="row"><div class="col-6"><div class="form-group">
                    <label>{{ __('penduduk') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm col-6" id="penduduk_id" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-parse_search="penduduk_id" data-target="#modal_search_Penduduk"><i class="fas fa-search"></i> Find</button>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <table class="table table-sm table_detail_left table-striped scrolldown">
                        <tbody id="parse_search_penduduk_id"></tbody>
                    </table>
                    </div>
                <div class="form-group">
                    <label>{{ __('jabatan') }}</label>
                    <select name="jabatan_id" id="jabatan_id" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach ($dataJabatan as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach 
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nipd') }}</label>
                    <input type="text" name="nipd" id="nipd" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nip') }}</label>
                    <input type="text" name="nip" id="nip" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('pangkat_golongan') }}</label>
                    <input type="text" name="pangkat_golongan" id="pangkat_golongan" class="form-control" value="">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('no_keputusan_pengangkatan') }}</label>
                    <input type="text" name="no_keputusan_pengangkatan" id="no_keputusan_pengangkatan" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                </div><div class="col-6"><div class="form-group">
                    <label>{{ __('tanggal_keputusan_pengangkatan') }}</label>
                    <div class="input-group">
                        <input type="text" name="tanggal_keputusan_pengangkatan" id="tanggal_keputusan_pengangkatan" class="form-control col-6 date">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('no_keputusan_pemberhentian') }}</label>
                    <input type="text" name="no_keputusan_pemberhentian" id="no_keputusan_pemberhentian" class="form-control number text-right">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('tanggal_keputusan_pemberhentian') }}</label>
                    <div class="input-group">
                        <input type="text" name="tanggal_keputusan_pemberhentian" id="tanggal_keputusan_pemberhentian" class="form-control col-6 date">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('status_pejabat') }}</label>
                    <select name="status_pejabat" id="status_pejabat" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\StatusPejabatEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('masa_jabatan') }}</label>
                    <input type="text" name="masa_jabatan" id="masa_jabatan" class="form-control" value="">
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
                "penduduk_id": $(modale).find("#penduduk_id").val(),
                "jabatan_id": $(modale).find("#jabatan_id").val(),
                "nipd": $(modale).find("#nipd").val(),
                "nip": $(modale).find("#nip").val(),
                "pangkat_golongan": $(modale).find("#pangkat_golongan").val(),
                "no_keputusan_pengangkatan": $(modale).find("#no_keputusan_pengangkatan").val(),
                "tanggal_keputusan_pengangkatan": $(modale).find("#tanggal_keputusan_pengangkatan").val(),
                "no_keputusan_pemberhentian": $(modale).find("#no_keputusan_pemberhentian").val(),
                "tanggal_keputusan_pemberhentian": $(modale).find("#tanggal_keputusan_pemberhentian").val(),
                "status_pejabat": $(modale).find("#status_pejabat").val(),
                "masa_jabatan": $(modale).find("#masa_jabatan").val(),
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
                $(modale).find('#penduduk_id').val(response.data.penduduk_id);
                $(modale).find('#jabatan_id').val(response.data.jabatan_id);
                $(modale).find('#nipd').val(response.data.nipd);
                $(modale).find('#nip').val(response.data.nip);
                $(modale).find('#pangkat_golongan').val(response.data.pangkat_golongan);
                $(modale).find('#no_keputusan_pengangkatan').val(response.data.no_keputusan_pengangkatan);
                $(modale).find('#tanggal_keputusan_pengangkatan').val(response.data.tanggal_keputusan_pengangkatan_original);
                $(modale).find('#no_keputusan_pemberhentian').val(response.data.no_keputusan_pemberhentian);
                $(modale).find('#tanggal_keputusan_pemberhentian').val(response.data.tanggal_keputusan_pemberhentian_original);
                $(modale).find('#status_pejabat').val(response.data.status_pejabat);
                $(modale).find('#masa_jabatan').val(response.data.masa_jabatan);
                
                $(modale).find('#parse_search_penduduk_id').html(
                    '<tr><td>{{ __('nama') }}</td><td>:</td><td>'+response.data.penduduk.nama+'</td></tr>'+
                    '<tr><td>{{ __('nik') }}</td><td>:</td><td>'+response.data.penduduk.nik+'</td></tr>'
                );
            },
            error: function(response) {
                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.error(response.responseJSON.message);
            }
        });
    });
</script>
@endpush