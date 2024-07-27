<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors(),
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        # recuperar o parametro da rota
        $userId = $this->route('user');

        return [
            'name' => 'required_if:name,!=,null|min:3',
            'email' => 'required_if:email,!=,null|email|unique:users,email,' . ($userId ? $userId->id : null),
            'password' => 'required_if:password,!=,null|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required_if' => 'O campo nome é obrigatório',
            'name.min' => 'O campo nome deve ter no mínimo :min caracteres',
            'email.required_if' => 'O campo email é obrigatório',
            'email.email' => 'O email não é válido',
            'email.unique' => 'O email já está cadastrado',
            'password.required_if' => 'O campo senha é obrigatório',
            'password.min' => 'O campo senha deve ter no mínimo :min caracteres',
        ];
    }
}
