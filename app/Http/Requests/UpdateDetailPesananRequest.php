<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailPesananRequest extends FormRequest
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
            'qty' => 'sometimes|integer|min:1',
            'catatan' => 'nullable|string',
            'harga_saat_pesan' => 'sometimes|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'qty.integer' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah harus minimal 1',
            'harga_saat_pesan.numeric' => 'Harga saat pesan harus berupa angka',
        ];
    }
}
