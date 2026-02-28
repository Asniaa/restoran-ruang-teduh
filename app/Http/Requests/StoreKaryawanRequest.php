<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryawanRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'role' => 'required|in:owner,kasir,pelayan,dapur',
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
            'nama.required' => 'Nama karyawan harus diisi',
            'nama.max' => 'Nama karyawan tidak boleh lebih dari 255 karakter',
            'role.required' => 'Role karyawan harus diisi',
            'role.max' => 'Role tidak boleh lebih dari 100 karakter',
            'user_id.exists' => 'User tidak ditemukan',
        ];
    }
}
