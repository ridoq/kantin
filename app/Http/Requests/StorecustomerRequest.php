<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorecustomerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'numeric', 'min:0', 'min_digits:4', 'max_digits:13', 'unique:customers,tel'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maximal 255 karakter',
            'tel.required' => 'Telepon harus diisi',
            'tel.numeric' => 'Telepon harus berupa angka',
            'tel.min' => 'Telepon tidak boleh minus',
            'tel.min_digits' => 'Telepon minimal adalah 4 digit',
            'tel.max_digits' => 'Telepon maximal adalah 13 digit',
            'tel.unique' => 'Telepon telah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email maximal 255 karakter',
            'email.unique' => 'Email telah terdaftar',
            'address.required' => 'Alamat harus diisi',
            'address.string' => 'Alamat harus berupa string',
            'address.max' => 'address maximal 255 karakter',
        ];
    }
}
