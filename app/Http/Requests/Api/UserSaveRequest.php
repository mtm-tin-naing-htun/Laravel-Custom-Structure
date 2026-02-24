<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use App\Constants\GeneralConst;
use App\Traits\ApiResponseTrait;

class UserSaveRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id'); // Route parameter က 'id' ဆိုလျှင်

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => [
                Rule::requiredIf(!$userId),
                'nullable', // Update မှာ password မပါရင် skip ဖို့
                'string',
                'min:8',
                'confirmed'
            ],
            'password_confirmation' => [
                Rule::requiredIf(!$userId),
                'nullable',
                'string',
                'min:8'
            ],
            'role' => [
                'required',
                'in:' . implode(',', array_keys(GeneralConst::ROLES))
            ],
        ];
    }

    /**
     * failedValidation
     *
     * @param  mixed $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(
            $this->error($errors->toArray(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
