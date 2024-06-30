<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorecategoryRequest extends FormRequest
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
            'name' => ['required','unique:categories,name,except,id']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Kolom nama kategori harus diisi',
            'name.unique' => 'Data telah ada sebelumnya'
        ];
    }
}
