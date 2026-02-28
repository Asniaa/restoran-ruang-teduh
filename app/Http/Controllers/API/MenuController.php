<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // GET /api/menus - Tampil semua menu
    public function index()
    {
        $menus = Menu::all();
        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    // POST /api/menus - Tambah menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|integer',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'aktif' => 'required|boolean'
        ]);

        $menu = Menu::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan',
            'data' => $menu
        ], 201);
    }

    // GET /api/menus/{id} - Tampil detail menu
    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    // PUT/PATCH /api/menus/{id} - Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'kategori_id' => 'sometimes|integer',
            'nama_menu' => 'sometimes|string|max:255',
            'harga' => 'sometimes|numeric',
            'aktif' => 'sometimes|boolean'
        ]);

        $menu->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diupdate',
            'data' => $menu
        ]);
    }

    // DELETE /api/menus/{id} - Hapus menu
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus'
        ]);
    }
}