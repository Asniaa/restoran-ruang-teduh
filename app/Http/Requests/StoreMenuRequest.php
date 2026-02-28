<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'kategori_id' => 'required|exists:kategori_menu,id',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
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
            'kategori_id.required' => 'Kategori menu harus dipilih',
            'kategori_id.exists' => 'Kategori menu tidak ditemukan',
            'nama_menu.required' => 'Nama menu harus diisi',
            'nama_menu.max' => 'Nama menu tidak boleh lebih dari 255 karakter',
            'harga.required' => 'Harga menu harus diisi',
            'harga.numeric' => 'Harga menu harus berupa angka',
            'harga.min' => 'Harga menu tidak boleh kurang dari 0',
        ];
    }
}
