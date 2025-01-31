<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormularioResquest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required',
            'login' => 'required',
            'senha' => 'required',
            'selecionar' => 'required',
            'email' => 'required',

        ];
    }
        public function messages() :array {
            return [
                'nome.required' => 'O campo :Nome é obrigatório.',
                'login.required' => 'O campo :Login dé obrigatório.',
                'senha.required' => 'O campo :Senha ré obrigatório..',
                'selecionar.required' => 'O campo :Seleciona obrigatório.',
                'email.required' => 'O campo :Email é obrigatório.'
            ];
        }
    }

