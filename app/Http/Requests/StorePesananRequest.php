<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesananRequest extends FormRequest
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
            'operational_day_id' => 'required|exists:operational_days,id',
            'meja_id' => 'required|exists:meja,id',
            'jenis_pesanan' => 'required|in:dine_in,take_away',
            'status' => 'required|in:open,paid,cancelled',
            'ditangani_oleh' => 'required|exists:karyawan,id',
            'waktu_pesan' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'operational_day_id.required' => 'Hari operasional harus dipilih',
            'operational_day_id.exists' => 'Hari operasional tidak ditemukan',
            'meja_id.required' => 'Meja harus dipilih',
            'meja_id.exists' => 'Meja tidak ditemukan',
            'jenis_pesanan.required' => 'Jenis pesanan harus dipilih',
            'jenis_pesanan.in' => 'Jenis pesanan tidak valid',
            'status.required' => 'Status pesanan harus dipilih',
            'status.in' => 'Status pesanan tidak valid',
            'ditangani_oleh.exists' => 'Karyawan tidak ditemukan',
        ];
    }
}
