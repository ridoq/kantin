<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepaymentMethodRequest extends FormRequest
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
            'method'=>['required','string','unique:payment_methods,method,except,id']
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
