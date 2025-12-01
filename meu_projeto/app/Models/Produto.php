<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'preco', 'categoria_id', 'imagem_path'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
