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
            'employee_id' => ['required','exists:employees,id'],
            'menu_id' => ['required','exists:menus,id'],
            'totalAmount' => ['required','numeric','min:1'],
            // 'transactionDate' => ['required','date','after:1 day ago'],
        ];
    }

    public function messages(){

        return[
            'customer_id.required' => 'Nama pelanggan harus diisi',
            'customer_id.exists' => 'Nama pelanggan tidak valid',
            'employee_id.required' => 'Nama Pegawai harus diisi',
            'employee_id.exists' => 'Nama Pegawai tidak valid',
            'menu_id.required' => 'Menu harus diisi',
            'menu_id.exists' => 'Menu tidak valid',
            'totalAmount.required' => 'Jumlah beli harus diisi',
            'totalAmount.numeric' => 'Jumlah beli harus berupa angka',
            'totalAmount.min' => 'Jumlah beli minimal adalah 1',
            // 'transactionDate.required' => 'Tanggal transaksi harus diisi',
            // 'transactionDate.date' => 'Tanggal transaksi tidak valid',
            // 'transactionDate.after' => 'Tanggal transaksi tidak boleh kurang dari hari ini',
        ];
    }
}
