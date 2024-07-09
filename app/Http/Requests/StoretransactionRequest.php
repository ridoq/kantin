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
            'transactionDate' => 'required',
            'employee_id' => 'required|exists:employees,id',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Kolom pelanggan ini harus diisi',
            'customer_id.exists' => 'Customer yang anda pilih tidak valid',
            'transactionDate.required' => 'Kolom tanggal transaksi ini harus diisi',
            'employee_id.required' => 'Kolom pegawai ini harus diisi',
            'employee_id.exists' => 'Employee yang anda pilih tidak valid',
        ];
    }
}
