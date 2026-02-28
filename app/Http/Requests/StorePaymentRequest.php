<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'pesanan_id' => 'required|exists:pesanan,id',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'metode_pembayaran' => 'required|in:cash,qris',
            'total_bayar' => 'required|numeric|min:0',
            'waktu_bayar' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'pesanan_id.required' => 'Pesanan harus dipilih',
            'pesanan_id.exists' => 'Pesanan tidak ditemukan',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih',
            'metode_pembayaran.in' => 'Metode pembayaran harus salah satu dari: cash atau qris',
            'total_bayar.required' => 'Total bayar harus diisi',
            'total_bayar.numeric' => 'Total bayar harus berupa angka',
            'total_bayar.min' => 'Total bayar tidak boleh kurang dari 0',
        ];
    }
}
