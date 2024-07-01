<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoretransactionRequest extends FormRequest
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
            'customer_id' => 'required',
            'menu_id' => 'required',
            'totalAmount' => 'required|numeric',
            'transactionDate' => 'required',
            'employee_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Kolom pelanggan ini harus diisi',
            'menu_id.required' => 'Kolom menu ini harus diisi',
            'totalAmount.required' => 'Kolom  jumlah beli ini harus diisi',
            'totalAmount.numeric' => 'Kolom jumlah beli ini harus berupa angka',
            'transactionDate.required' => 'Kolom tanggal transaksi ini harus diisi',
            'employee_id.required' => 'Kolom pegawai ini harus diisi',
        ];
    }
}
