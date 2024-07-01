<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatecustomerRequest extends FormRequest
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
            'name' => ['required'],
            'tel' =>
            [
                'required',
                'numeric',
                'min:0',
                'min_digits:4',
                'max_digits:13',
                Rule::unique('customers', 'tel')
                ->ignore($this->customer->id)
            ],
            'email' => ['required',
                        Rule::unique('customers', 'email')
                        ->ignore($this->customer->id)
                    ],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom nama ini harus diisi',
            'tel.required' => 'Kolom telefon ini harus diisi',
            'tel.unique' => 'Data telefon telah ada sebelumnya',
            'email.required' => 'Kolom email ini harus diisi',
            'email.unique' => 'Data email telah ada sebelumnya',
            'address.required' => 'Kolom alamat ini harus diisi',
        ];
    }
}
