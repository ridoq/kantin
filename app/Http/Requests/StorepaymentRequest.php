<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepaymentRequest extends FormRequest
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
            'paymentMethod_id'=>['required','exists:payment_methods,id'],
            'totalPayment'=>['required','numeric','min:1'],
        ];
    }

    public function messages()
    {
        return [
            'paymentMethod_id.required'=> 'Metode pembayaran harus diisi',
            'paymentMethod_id.exists'=> 'Metode pembayaran tidak valid',
            'totalPayment.required'=> 'Total pembayaran harus diisi',
            'totalPayment.numeric'=> 'Total pembayaran harus berupa angka',
            'totalPayment.min'=> 'Total pembayaran minimal adalah 1 rupiah',
        ];
    }
}
