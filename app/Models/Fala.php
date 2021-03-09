<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fala extends Model
{
    use HasFactory;

    protected $fillable = [
        'conteudo',
        'balao',
        'char_id',
        'pagina_id',
    ];

    public function char()
    {
        return $this->belongsTo(Char::class);
    }

    public function pagina()
    {
        return $this->belongsTo(Pagina::class);
    }
}
