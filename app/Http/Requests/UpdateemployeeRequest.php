<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateemployeeRequest extends FormRequest
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
                Rule::unique('employees', 'tel')
                ->ignore($this->employee->id)
            ],
            'email' => ['required',
                        Rule::unique('employees', 'email')
                        ->ignore($this->employee->id)
                    ],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom nama harus diisi',
            'name.unique' => 'Data telah ada sebelumnya',
            'tel.required' => 'Kolom telepon harus diisi',
            'email.required' => 'Kolom email harus diisi',
            'address.required' => 'Kolom alamat harus diisi',
        ];
    }
}
