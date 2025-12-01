@extends('layouts.app')

@section('content')
<h1>Produtos</h1>
<p>Visitas nesta página: {{ $visitas }}</p>

<form action="{{ url('/produtos') }}" method="POST" enctype="multipart/form-data" class="card">
    @csrf
    <div>
        <label>Nome</label>
        <input type="text" name="nome" value="{{ old('nome') }}" required>
    </div>
    <div>
        <label>Preço</label>
        <input type="number" step="0.01" name="preco" value="{{ old('preco') }}" required>
    </div>
    <div>
        <label>Categoria</label>
        <select name="categoria_id">
            <option value="">Sem categoria</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" @if($categoriaSelecionada == $cat->id) selected @endif>
                    {{ $cat->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Imagem (PNG/JPG)</label>
        <input type="file" name="imagem" accept="image/png, image/jpeg">
    </div>
    <button type="submit">Cadastrar</button>
</form>

<h2>Lista de Produtos</h2>
@foreach($produtos as $produto)
    <div class="card">
        <strong>{{ $produto->nome }}</strong>
        <div>Preço: R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
        <div>Categoria: {{ $produto->categoria?->nome ?? '—' }}</div>
        @if($produto->imagem_path)
            <img class="thumb" src="{{ asset('storage/' . $produto->imagem_path) }}" alt="Imagem do produto">
        @endif

        <div style="margin-top:8px;">
            <a href="{{ url('/produtos/' . $produto->id . '/edit') }}">Editar</a>

            <form action="{{ url('/produtos/' . $produto->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Excluir este produto?')">Excluir</button>
            </form>
        </div>
    </div>
@endforeach
@endsection