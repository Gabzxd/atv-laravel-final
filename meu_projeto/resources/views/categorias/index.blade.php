@extends('layouts.app')

@section('content')
<h1>Categorias</h1>
<p>Visitas nesta página: {{ $visitas }}</p>

<form action="{{ url('/categorias') }}" method="POST" class="card">
    @csrf
    <div>
        <label>Nome</label>
        <input type="text" name="nome" value="{{ old('nome') }}" required>
    </div>
    <button type="submit">Cadastrar</button>
</form>

<h2>Lista de Categorias</h2>
@foreach($categorias as $categoria)
    <div class="card">
        <strong>{{ $categoria->nome }}</strong>
        <div>Produtos: {{ $categoria->produtos_count }}</div>

        <div style="margin-top:8px;">
            <a href="{{ url('/categorias/' . $categoria->id . '/edit') }}">Editar</a>

            <form action="{{ url('/categorias/' . $categoria->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Excluir esta categoria?')">Excluir</button>
            </form>
        </div>
    </div>
@endforeach
@endsection
