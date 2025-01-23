<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Osresquest extends FormRequest
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
            'endereco' => 'required',
            'data' => 'required',
            'hoInicio' => 'required',
            'hoFim' => 'required',
            'Prefixo' => 'required',
            'NumPrefixo' => 'required',
        ];
    }
        // public function messages(): array
        // {

        //      return  [
        //     'endereco' => 'Campo Nome e obrigatorio!',
        //     'data' => 'Campo data e obrigatorio!',
        //     'hoInicio' => 'Campo hoInicio e obrigatorio!',
        //     'hoFim' => 'Campo hoFim e obrigatorio!',
        //     'Prefixo' => 'Campo Prefixo e obrigatorio!',
        //     'NumPrefixo' => 'Campo NumPrefixo e obrigatorio!',

        //    ];
        // }
    }

