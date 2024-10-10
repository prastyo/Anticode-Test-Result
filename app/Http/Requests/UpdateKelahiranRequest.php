<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\JenisKelaminEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphaNumericSpaceQuoteDotRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateKelahiranRequest extends FormRequest
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
            'jam_lahir'                => ['required'],
            'tanggal_lahir'            => ['required', 'date'],
            'anak_ke'                  => ['required', 'integer'],
            'berat_bayi'               => ['required', 'integer'],
            'panjang_bayi'             => ['required', 'integer'],
            'hari_lahir'               => ['required', 'string', 'min:2', 'max:25'],
            'tempat_lahir'             => ['required', 'string', 'min:2', 'max:255'],
            'ayah_id'                  => ['nullable', 'exists:App\Models\Penduduk,id'],
            'ibu_id'                   => ['nullable', 'exists:App\Models\Penduduk,id'],
            'jenis_kelamin'            => ['required', Rule::enum(JenisKelaminEnum::class)],
            'jenis_persalinan_id'      => ['required', 'exists:App\Models\DataJenisPersalinan,id'],
            'tempat_dilahirkan_id'     => ['required', 'exists:App\Models\DataTempatDilahirkan,id'],
            'penolong_kelahiran_id'    => ['required', 'exists:App\Models\DataPenolongKelahiran,id'],
            'nama_anak'                => ['required', 'string', 'min:2', 'max:255', new AlphaNumericSpaceQuoteDotRule],
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