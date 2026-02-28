<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailPesananRequest extends FormRequest
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
            'menu_id' => 'required|exists:menu,id',
            'qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'harga_saat_pesan' => 'required|numeric|min:0',
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
            'menu_id.required' => 'Menu harus dipilih',
            'menu_id.exists' => 'Menu tidak ditemukan',
            'qty.required' => 'Jumlah harus diisi',
            'qty.integer' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah harus minimal 1',
            'harga_saat_pesan.required' => 'Harga saat pesan harus diisi',
            'harga_saat_pesan.numeric' => 'Harga saat pesan harus berupa angka',
        ];
    }
}
