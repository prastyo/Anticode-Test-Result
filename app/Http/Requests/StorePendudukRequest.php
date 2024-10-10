<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\JenisKelaminEnum;
use App\Enums\AkteKelahiranEnum;
use App\Enums\StatusPendudukEnum;
use App\Enums\IdentitasElektronikEnum;
use App\Enums\KelainanFisikMentalEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphaNumericSpaceQuoteDotRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePendudukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tanggal_lahir'            => ['required', 'date'],
            'rt'                       => ['required', 'integer'],
            'rw'                       => ['required', 'integer'],
            'kodepos'                  => ['nullable', 'integer'],
            'nik_ayah'                 => ['nullable', 'integer'],
            'nik_ibu'                  => ['nullable', 'integer'],
            'tempat_lahir'             => ['required', 'string', 'min:2', 'max:25'],
            'telepon'                  => ['nullable', 'string', 'min:2', 'max:20'],
            'alamat'                   => ['required', 'string', 'min:2', 'max:255'],
            'suku_id'                  => ['nullable', 'exists:App\Models\DataSuku,id'],
            'agama_id'                 => ['required', 'exists:App\Models\DataAgama,id'],
            'kawin_id'                 => ['required', 'exists:App\Models\DataKawin,id'],
            'cacat_id'                 => ['required', 'exists:App\Models\DataCacat,id'],
            'kursus_id'                => ['nullable', 'exists:App\Models\DataKursu,id'],
            'bahasa_id'                => ['nullable', 'exists:App\Models\DataBahasa,id'],
            'jenis_kelamin'            => ['required', Rule::enum(JenisKelaminEnum::class)],
            'asuransi_id'              => ['required', 'exists:App\Models\DataAsuransi,id'],
            'akte_kelahiran'           => ['required', Rule::enum(AkteKelahiranEnum::class)],
            'pekerjaan_id'             => ['required', 'exists:App\Models\DataPekerjaan,id'],
            'pendidikan_id'            => ['required', 'exists:App\Models\DataPendidikan,id'],
            'akseptor_kb_id'           => ['required', 'exists:App\Models\DataAkseptorKb,id'],
            'status_penduduk'          => ['required', Rule::enum(StatusPendudukEnum::class)],
            'warganegara_id'           => ['required', 'exists:App\Models\DataWarganegara,id'],
            'status_dasar_id'          => ['required', 'exists:App\Models\DataStatusDasar,id'],
            'sakit_menahun_id'         => ['required', 'exists:App\Models\DataSakitMenahun,id'],
            'golongan_darah_id'        => ['required', 'exists:App\Models\DataGolonganDarah,id'],
            'identitas_elektronik'     => ['required', Rule::enum(IdentitasElektronikEnum::class)],
            'kelainan_fisik_mental'    => ['required', Rule::enum(KelainanFisikMentalEnum::class)],
            'hubungan_keluarga_id'     => ['required', 'exists:App\Models\DataHubunganKeluarga,id'],
            'email'                    => ['nullable', 'email', Rule::unique('penduduk')->ignore($this->id)],
            'nik'                      => ['required', 'integer', Rule::unique('penduduk')->ignore($this->id)],
            'nama'                     => ['required', 'string', 'min:2', 'max:255', new AlphaNumericSpaceQuoteDotRule],
            'nama_ayah'                => ['nullable', 'string', 'min:2', 'max:255', new AlphaNumericSpaceQuoteDotRule],
            'nama_ibu'                 => ['nullable', 'string', 'min:2', 'max:255', new AlphaNumericSpaceQuoteDotRule],
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response([
            'alert'    => 'danger',
            'message'  => __('site.something_wrong'),
            'errors'   => $validator->getMessageBag()
        ],400));
    }
}