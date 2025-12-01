<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>CRUD - Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        nav a { margin-right: 12px; }
        .error { color: #b00020; }
        .success { color: #087f23; }
        .card { border: 1px solid #ddd; padding: 12px; margin-bottom: 8px; }
        img.thumb { max-height: 80px; display:block; margin-top:6px; }
    </style>
</head>
<body>
<nav>
    <a href="/produtos">Produtos</a>
    <a href="/categorias">Categorias</a>
</nav>
<hr>
@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('content')
</body>
</html>