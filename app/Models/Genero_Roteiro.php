<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero_Roteiro extends Model
{
    use HasFactory;
    protected $table = 'genero_roteiro';

    protected $fillable = [
        'roteiro_id',
        'genero_id',
    ];
}
