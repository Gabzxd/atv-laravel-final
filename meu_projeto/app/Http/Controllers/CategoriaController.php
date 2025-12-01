<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Cookie;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $visitas = $request->session()->get('visitas_categorias', 0);
        $request->session()->put('visitas_categorias', $visitas + 1);

        $categorias = Categoria::withCount('produtos')->get();

        return view('categorias.index', compact('categorias', 'visitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome',
        ]);

        $categoria = Categoria::create($request->only('nome'));

        Cookie::queue('ultima_categoria', $categoria->id, 60 * 24 * 30);

        return redirect()->back()->with('success', 'Categoria cadastrada com sucesso!');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome,' . $categoria->id,
        ]);

        $categoria->update($request->only('nome'));

        Cookie::queue('ultima_categoria', $categoria->id, 60 * 24 * 30);

        return redirect('/categorias')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->back()->with('success', 'Categoria excluída com sucesso!');
    }
}