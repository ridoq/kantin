<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateingredientRequest extends FormRequest
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
            'name'=>['required'],
            'stock'=>['required','integer','min:0'],
            'supplier_id'=>['required'],
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'Kolom nama harus diisi',
            'stock.required'=>'Kolom stok harus diisi',
            'stock.integer'=>'Kolom stok harus berupa bilangan bulat',
            'stock.min'=>'stok tidak boleh minus',
            'supplier_id.required'=>'Kolom nama supplier tidak boleh kosong',
        ];
    }
}
