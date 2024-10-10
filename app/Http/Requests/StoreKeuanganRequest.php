<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\JenisKeuanganEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreKeuanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nilai_anggaran' => str_replace('.', '', $this->nilai_anggaran), // Remove dot from the currency format,
            'nilai_realisasi' => str_replace('.', '', $this->nilai_realisasi), // Remove dot from the currency format
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'keterangan'          => ['required'],
            'tanggal_kuitansi'    => ['required', 'date'],
            'nilai_anggaran'      => ['required', 'integer'],
            'nilai_realisasi'     => ['required', 'integer'],
            'tahun_anggaran'      => ['required', 'integer', 'min:1901', 'max:2155'],
            'jenis_keuangan'      => ['required', Rule::enum(JenisKeuanganEnum::class)],
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