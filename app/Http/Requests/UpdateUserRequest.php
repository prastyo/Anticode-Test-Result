<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphaNumericSpaceQuoteDotRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'bio'         => ['nullable', 'string', 'min:2', 'max:255'],
            'password'    => ['nullable', 'confirmed', Password::min(8)],
            'email'       => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'name'        => ['required', 'string', 'min:2', 'max:255', new AlphaNumericSpaceQuoteDotRule],
            'username'    => ['nullable', 'string', 'min:2', 'max:50', Rule::unique('users')->ignore($this->id)],
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