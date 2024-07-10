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
            'customer_id' => ['required','exists:customers,id'],
            'transactionDate' => ['required','date','after:1 day ago'],
            'employee_id' => 'required|exists:employees,id',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Nama pelanggan harus diisi',
            'customer_id.exists' => 'Nama pelanggan tidak valid',
            'employee_id.required' => 'Nama pegawai harus diisi',
            'employee_id.exists' => 'Nama pegawai tidak valid',
            'transactionDate.required' => 'Tanggal transaksi harus diisi',
            'transactionDate.date' => 'Tanggal transaksi tidak valid',
            'transactionDate.after' => 'Tanggal transaksi tidak boleh kurang dari hari ini',
        ];
    }
}
