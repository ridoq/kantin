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
            'customer_id' => 'required|exists:customers,id',
            'menu_id' => 'required|exists:menus,id',
            'totalAmount' => 'required|numeric',
            'transactionDate' => 'required',
            'employee_id' => 'required|exists:employees,id',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Kolom pelanggan ini harus diisi',
            'customer_id.exists' => 'Customer yang anda pilih tidak valid',
            'menu_id.required' => 'Kolom menu ini harus diisi',
            'menu_id.exists' => 'Menu yang anda pilih tidak valid',
            'totalAmount.required' => 'Kolom  jumlah beli ini harus diisi',
            'totalAmount.numeric' => 'Kolom jumlah beli ini harus berupa angka',
            'transactionDate.required' => 'Kolom tanggal transaksi ini harus diisi',
            'employee_id.required' => 'Kolom pegawai ini harus diisi',
            'employee_id.exists' => 'Employee yang anda pilih tidak valid',
        ];
    }
}
