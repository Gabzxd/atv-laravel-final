@extends('layouts.app')

@section('content')
<h1>Editar Categoria</h1>

<form action="{{ url('/categorias/' . $categoria->id) }}" method="POST" class="card">
    @csrf
    @method('PUT')

    <div>
        <label>Nome</label>
        <input type="text" name="nome" value="{{ old('nome', $categoria->nome) }}" required>
    </div>

    <button type="submit">Salvar</button>
    <a href="{{ url('/categorias') }}">Voltar</a>
</form>
@endsection