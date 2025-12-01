<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $visitas = $request->session()->get('visitas_produtos', 0);
        $request->session()->put('visitas_produtos', $visitas + 1);

        $categoriaSelecionada = Cookie::get('ultima_categoria');
        $categorias = Categoria::all();

        $query = Produto::with('categoria');
        if ($categoriaSelecionada) {
            $query->where('categoria_id', $categoriaSelecionada);
        }
        $produtos = $query->get();

        return view('produtos.index', compact('produtos', 'categorias', 'categoriaSelecionada', 'visitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagem' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $dados = $request->only(['nome', 'preco', 'categoria_id']);

        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads', $filename);
            $dados['imagem_path'] = str_replace('public/', '', $path);
        }

        Produto::create($dados);

        if (!empty($dados['categoria_id'])) {
            Cookie::queue('ultima_categoria', $dados['categoria_id'], 60 * 24 * 30);
        }

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        $categorias = Categoria::all();
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagem' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $dados = $request->only(['nome', 'preco', 'categoria_id']);

        if ($request->hasFile('imagem')) {
            if ($produto->imagem_path) {
                Storage::delete('public/' . $produto->imagem_path);
            }
            $file = $request->file('imagem');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads', $filename);
            $dados['imagem_path'] = str_replace('public/', '', $path);
        }

        $produto->update($dados);

        if (!empty($dados['categoria_id'])) {
            Cookie::queue('ultima_categoria', $dados['categoria_id'], 60 * 24 * 30);
        }

        return redirect('/produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->imagem_path) {
            Storage::delete('public/' . $produto->imagem_path);
        }
        $produto->delete();
        return redirect()->back()->with('success', 'Produto excluído com sucesso!');
    }
}