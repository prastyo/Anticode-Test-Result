
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">{{ __('site.add_new') }} {{ __('keuangan') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="form_add">
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
            url: '{{ route('keuangans.store') }}',
            type: "POST",
            data:{
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
                $(modale).find('form')[0].reset();
                $(modale).find("input:visible").first().focus();
                $(modale).find('#keterangan').summernote('code', '');

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
        $(modale).find('#keterangan').summernote('code', '');
        $(modale).find("input:text:visible").first().focus();
        $(modale).find('form')[0].reset();
        $(modale).find(':input').each(function() {
            $(this).removeClass('is-invalid');
        });
        $(modale).modal('show');
    });
</script>
@endpush