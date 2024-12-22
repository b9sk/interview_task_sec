<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Т.к. форма не большая, размещаем валидацию тут.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        if ($this->isMethod('post')) {
            return [
                'email' => 'required|email|unique:users',
                'name' => 'required|string',
                'password' => 'required',
                'ip' => 'ip',
                'comment' => 'max:255',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                // если пользователь отправит свой email, то получит ошибку "The email has already been taken."
                'email' => 'sometimes|email|unique:users,email,' . $this->user,
                'name' => 'sometimes|string',
                'password' => 'sometimes',
                'ip' => 'ip',
                'comment' => 'max:255',
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->has('password')) {
            $this->merge([
                'password' => bcrypt($this->input('password')),
            ]);
        }
    }
}
