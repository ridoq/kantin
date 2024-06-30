<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoremenuRequest extends FormRequest
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
            'menu'=>['required','unique:menus,menu,except,id'],
            'price'=>['required','numeric'],
        ];
    }
    public function messages()
    {
        return [
            'menu.required'=> 'Kolom menu harus diisi',
            'menu.unique'=> 'Data Menu telah ada sebelumnya',
            'price.required'=>'Kolom harga harus diisi',
            'price.numeric'=>'Kolom harga harus berupa angka',
        ];

    }
}
