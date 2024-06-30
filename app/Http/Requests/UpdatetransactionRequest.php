<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatetransactionRequest extends FormRequest
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
            'totalamount' => 'required|numeric',
            'priceTotal' => 'required|numeric',
            'transactiondate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'totalamount.required' => 'Kolom ini harus diisi',
            'totalamount.numeric' => 'Kolom ini harus berupa angka',
            'priceTotal.required' => 'Kolom ini harus diisi',
            'priceTotal.numeric' => 'Kolom ini harus berupa angka',
            'transactiondate.required' => 'Kolom ini harus diisi',
        ];
    }
}
