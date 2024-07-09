<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorestockMenuRequest extends FormRequest
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
            'menu_id' => ['required','exists:menus,id'],
            'stock' => ['required','integer','min:0'],
        ];
    }

    public function messages()
    {
        return[
            'menu_id.required'=>'Kolom menu harus diisi',
            'menu_id.exists'=>'Kolom menu tidak valid',
            'stock.required'=>'Kolom stock harus diisi',
            'stock.integer'=>'Kolom stock harus berupa angka',
            'stock.min'=>'Stock minimal adalah 1',
        ];
    }
}
