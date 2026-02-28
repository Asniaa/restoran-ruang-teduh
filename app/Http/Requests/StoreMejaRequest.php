<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMejaRequest extends FormRequest
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
            'nomor_meja' => 'required|string|max:50|unique:meja,nomor_meja',
            'status' => 'required|in:available,booked,occupied',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nomor_meja.required' => 'Nomor meja harus diisi',
            'nomor_meja.unique' => 'Nomor meja sudah ada',
            'nomor_meja.max' => 'Nomor meja tidak boleh lebih dari 50 karakter',
            'status.required' => 'Status meja harus dipilih',
            'status.in' => 'Status meja tidak valid',
        ];
    }
}
