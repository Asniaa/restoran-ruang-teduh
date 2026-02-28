<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'kategori_id' => 'sometimes|exists:kategori_menu,id',
            'nama_menu' => 'sometimes|string|max:255',
            'harga' => 'sometimes|numeric|min:0',
            'aktif' => 'nullable|boolean',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kategori_id.exists' => 'Kategori menu tidak ditemukan',
            'nama_menu.max' => 'Nama menu tidak boleh lebih dari 255 karakter',
            'harga.numeric' => 'Harga menu harus berupa angka',
            'harga.min' => 'Harga menu tidak boleh kurang dari 0',
        ];
    }
}
