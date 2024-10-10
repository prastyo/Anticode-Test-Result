<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphaNumericSpaceQuoteDotRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDataPenolongKelahiranRequest extends FormRequest
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
            'nama'    => ['required', 'string', 'min:2', 'max:255', new AlphaNumericSpaceQuoteDotRule],
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