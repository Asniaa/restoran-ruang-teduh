<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'metode_pembayaran' => 'sometimes|in:cash,qris',
            'total_bayar' => 'sometimes|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'metode_pembayaran.in' => 'Metode pembayaran harus salah satu dari: cash atau qris',
            'total_bayar.numeric' => 'Total bayar harus berupa angka',
            'total_bayar.min' => 'Total bayar tidak boleh kurang dari 0',
        ];
    }
}
