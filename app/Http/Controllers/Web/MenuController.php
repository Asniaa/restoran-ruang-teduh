<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\KategoriMenu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->orderBy('nama_menu')->paginate(10);
        return view('manage.menus.index', ['menus' => $menus]);
    }

    public function create()
    {
        $categories = KategoriMenu::orderBy('nama_kategori')->get();
        return view('manage.menus.create', ['categories' => $categories]);
    }

    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();
        $data['aktif'] = $request->has('aktif'); // boolean checkbox

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('menus', 'public');
            $data['foto_url'] = $path;
        }

        Menu::create($data);

        return redirect()->route('manage.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = KategoriMenu::orderBy('nama_kategori')->get();
        return view('manage.menus.edit', ['menu' => $menu, 'categories' => $categories]);
    }

    public function update(UpdateMenuRequest $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $data = $request->validated();
        $data['aktif'] = $request->has('aktif');

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($menu->foto_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto_url)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->foto_url);
            }

            $path = $request->file('foto')->store('menus', 'public');
            $data['foto_url'] = $path;
        }

        $menu->update($data);

        return redirect()->route('manage.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->foto_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto_url)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->foto_url);
        }

        $menu->delete();
        return redirect()->route('manage.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
