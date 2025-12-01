@extends('layouts.app')

@section('content')
<h1>Editar Produto</h1>

<form action="{{ url('/produtos/' . $produto->id) }}" method="POST" enctype="multipart/form-data" class="card">
    @csrf
    @method('PUT')

    <div>
        <label>Nome</label>
        <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" required>
    </div>
    <div>
        <label>Preço</label>
        <input type="number" step="0.01" name="preco" value="{{ old('preco', $produto->preco) }}" required>
    </div>
    <div>
        <label>Categoria</label>
        <select name="categoria_id">
            <option value="">Sem categoria</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" @if(old('categoria_id', $produto->categoria_id) == $cat->id) selected @endif>
                    {{ $cat->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Imagem (PNG/JPG)</label>
        @if($produto->imagem_path)
            <img class="thumb" src="{{ asset('storage/' . $produto->imagem_path) }}" alt="Imagem atual">
        @endif
        <input type="file" name="imagem" accept="image/png, image/jpeg">
    </div>
    <button type="submit">Salvar</button>
    <a href="{{ url('/produtos') }}">Voltar</a>
</form>
@endsection