<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatepaymentMethodRequest extends FormRequest
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
            'method'=>['required','string',Rule::unique('payment_methods','method')->ignore($this->paymentMethod->id)]
        ];
    }
    public function messages()
    {
        return[
            'method.required'=>'Metode pembayaran harus diisi',
            'method.string'=>'Metode pembayaran harus berupa string',
            'method.unique'=>'Metode pembayaran telah terdaftar',
        ];
    }
}
