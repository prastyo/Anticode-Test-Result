<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\StatusPejabatEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePerangkatRequest extends FormRequest
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
            'tanggal_keputusan_pengangkatan'     => ['nullable', 'date'],
            'tanggal_keputusan_pemberhentian'    => ['nullable', 'date'],
            'nipd'                               => ['nullable', 'integer'],
            'nip'                                => ['nullable', 'integer'],
            'no_keputusan_pengangkatan'          => ['nullable', 'integer'],
            'no_keputusan_pemberhentian'         => ['nullable', 'integer'],
            'pangkat_golongan'                   => ['nullable', 'string', 'min:2', 'max:255'],
            'masa_jabatan'                       => ['required', 'string', 'min:2', 'max:255'],
            'penduduk_id'                        => ['required', 'exists:App\Models\Penduduk,id'],
            'jabatan_id'                         => ['required', 'exists:App\Models\DataJabatan,id'],
            'status_pejabat'                     => ['required', Rule::enum(StatusPejabatEnum::class)],
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