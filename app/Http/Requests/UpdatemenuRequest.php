<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatemenuRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('menus','name')->ignore($this->menu->id)
            ],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Kolom name harus diisi',
            'name.unique' => 'Data name telah ada sebelumnya',
            'price.required' => 'Kolom harga harus diisi',
            'price.numeric' => 'Kolom harga harus berupa angka',
            'price.min' => 'Minimal harga menu adalah 1',
        ];
    }
}
