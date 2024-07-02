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
            'name'=>['required','unique:menus,name,except,id'],
            'price'=>['required','numeric','min:1'],
            'category_id'=>['required','exists:categories,id']
        ];
    }
    public function messages()
    {
        return [
            'name.required'=> 'Kolom name harus diisi',
            'name.unique'=> 'Data name telah ada sebelumnya',
            'price.required'=>'Kolom harga harus diisi',
            'price.numeric'=>'Kolom harga harus berupa angka',
            'price.min'=>'minimal harga menu adalah 1',
            'category_id.required'=>'Kolom kategori harus diisi',
            'category_id.exists'=>'Kategori yang dipilih tidak valid',
        ];

    }
}
