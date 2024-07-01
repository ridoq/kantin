<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatesupplierRequest extends FormRequest
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
            'tel' => [
                'required',
                'numeric',
                'min:0',
                'min_digits:4',
                'max_digits:13',
                Rule::unique('suppliers', 'tel')
                ->ignore($this->supplier->id)
            ],
            'address' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Kolom nama supplier harus diisi',
            'tel.required' => 'Kolom telepon harus diisi',
            'tel.unique' => 'data telepon sudah ada sebelumnya',
            'tel.numeric' => 'Kolom telepon harus berupa angka',
            'tel.min_digits' => 'Digit minimal untuk nomor telepon adalah 4 digit',
            'tel.max_digits' => 'Digit maximal untuk nomor telepon adalah 13 digit',
            'tel.min' => 'Kolom telepon tidak boleh minus',
            'address.required' => 'Kolom alamat harus diisi',
        ];
    }
}
