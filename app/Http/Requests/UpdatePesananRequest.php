<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePesananRequest extends FormRequest
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
            'meja_id' => 'sometimes|exists:meja,id',
            'jenis_pesanan' => 'sometimes|in:dine_in,take_away',
            'status' => 'sometimes|in:open,paid,cancelled',
            'ditangani_oleh' => 'sometimes|exists:karyawan,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'meja_id.exists' => 'Meja tidak ditemukan',
            'jenis_pesanan.in' => 'Jenis pesanan tidak valid',
            'status.in' => 'Status pesanan tidak valid',
            'ditangani_oleh.exists' => 'Karyawan tidak ditemukan',
        ];
    }
}
