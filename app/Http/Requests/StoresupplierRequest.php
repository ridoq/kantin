<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoresupplierRequest extends FormRequest
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
                'unique:suppliers,tel,except,id'
            ],
            'address' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Kolom nama supplier harus diisi',
            'tel.required' => 'Kolom telepon harus diisi',
            'tel.unique' => 'data telepon sebelumnya sudah ada',
            'tel.numeric' => 'Kolom telepon harus berupa angka',
            'tel.min' => 'Kolom telepon tidak boleh minus',
            'tel.min_digits' => 'Digit minimal untuk nomor telepon adalah 4 digit',
            'tel.max_digits' => 'Digit maximal untuk nomor telepon adalah 13 digit',
            'address.required' => 'Kolom alamat harus diisi',
        ];
    }
}
