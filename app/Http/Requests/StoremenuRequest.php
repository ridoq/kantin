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
            'category_id'=>['required','exists:categories,id'],
            'gambar'=>['image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }
    public function messages()
    {
        return [
            'name.required'=> 'Menu harus diisi',
            'name.unique'=> 'Menu telah terdaftar',
            'price.required'=>'Harga harus diisi',
            'price.numeric'=>'Harga harus berupa angka',
            'price.min'=> 'Harga minimal adalah 1 rupiah',
            'category_id.required'=>'Kategori harus diisi',
            'category_id.exists'=>'Kategori yang dipilih tidak valid',
            'gambar.image'=>'Gambar menu harus berupa gambar',
            'gambar.mimes'=>'Gambar menu harus berformat png,jpg,jpeg',
            'gambar.max'=>'Gambar menu maksimal 2 MB',
        ];

    }
}
