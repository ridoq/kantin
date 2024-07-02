<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreemployeeRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom nama ini harus diisi',
            'tel.required' => 'Kolom telepon ini harus diisi',
            'tel.min' => 'Kolom telepon tidak boleh minus',
            'tel.min_digits' => 'Nomor telepon minimal harus 4 digit',
            'tel.max_digits' => 'Nomor telepon maximal harus 13 digit',
            'tel.unique' => 'Data telepon telah ada sebelumnya',
            'email.required' => 'Kolom email ini harus diisi',
            'email.unique' => 'Data email telah ada sebelumnya',
            'address.required' => 'Kolom alamat ini harus diisi',
        ];
    }
}
