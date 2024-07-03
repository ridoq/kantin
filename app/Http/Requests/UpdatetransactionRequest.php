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

            'totalAmount' => 'required|numeric',
            'transactionDate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'totalAmount.required' => 'Kolom jumlah beli ini harus diisi',
            'totalAmount.numeric' => 'Kolom jumlah beli harus berupa angka',
            'transactionDate.required' => 'Kolom tanggal transaksi harus diisi',
        ];
    }
}
