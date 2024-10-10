
<div class="modal fade" id="modal_edit" tabindex="0" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.edit') }} {{ __('keuangan') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_edit">
                    <input type="hidden" id="id" value="">
                    <div class="form-group">
                    <label>{{ __('tahun_anggaran') }}</label>
                    <div class="input-group">
                        <input type="text" name="tahun_anggaran" id="tahun_anggaran" class="form-control col-6 year">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('jenis_keuangan') }}</label>
                    <select name="jenis_keuangan" id="jenis_keuangan" class="form-control">
                        <option value="">{{ __('site.select_option') }}</option>
                        @foreach(\App\Enums\JenisKeuanganEnum::cases() as $option)
                        <option value="{{ $option->value }}">{{ __($option->value) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('nilai_anggaran') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" name="nilai_anggaran" id="nilai_anggaran" class="form-control money text-right">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('nilai_realisasi') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp</div>
                        </div>
                        <input type="text" name="nilai_realisasi" id="nilai_realisasi" class="form-control money text-right">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('keterangan') }}</label>
                    <textarea id="keterangan" name="keterangan" class="form-control summernote-simple"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('tanggal_kuitansi') }}</label>
                    <div class="input-group">
                        <input type="text" name="tanggal_kuitansi" id="tanggal_kuitansi" class="form-control col-6 date">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
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
                "tahun_anggaran": $(modale).find("#tahun_anggaran").val(),
                "jenis_keuangan": $(modale).find("#jenis_keuangan").val(),
                "nilai_anggaran": $(modale).find("#nilai_anggaran").val(),
                "nilai_realisasi": $(modale).find("#nilai_realisasi").val(),
                "keterangan": $(modale).find("#keterangan").val(),
                "tanggal_kuitansi": $(modale).find("#tanggal_kuitansi").val(),
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
                $(modale).find('#tahun_anggaran').val(response.data.tahun_anggaran);
                $(modale).find('#jenis_keuangan').val(response.data.jenis_keuangan);
                $(modale).find('#nilai_anggaran').val(response.data.nilai_anggaran);
                $(modale).find('#nilai_realisasi').val(response.data.nilai_realisasi);
                $(modale).find('#keterangan').summernote('code', response.data.keterangan);
                $(modale).find('#tanggal_kuitansi').val(response.data.tanggal_kuitansi_original);
                
            },
            error: function(response) {
                toastr.options = {"positionClass": "toast-bottom-right"}
                toastr.error(response.responseJSON.message);
            }
        });
    });
</script>
@endpush