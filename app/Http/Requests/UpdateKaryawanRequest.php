<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryawanRequest extends FormRequest
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
            'nama' => 'sometimes|string|max:255',
            'role' => 'sometimes|string|max:100',
            'aktif' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama.max' => 'Nama karyawan tidak boleh lebih dari 255 karakter',
            'role.max' => 'Role tidak boleh lebih dari 100 karakter',
            'user_id.exists' => 'User tidak ditemukan',
        ];
    }
}
