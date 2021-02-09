<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generos = array(
            array('nome' => 'Ação'),
            array('nome' => 'Aventura'),
            array('nome' => 'Comédia'),
            array('nome' => 'Ficção Científica'),
            array('nome' => 'Suspense'),
            array('nome' => 'Terror'),
            array('nome' => 'Infantil'),
            array('nome' => 'Romance'),
            array('nome' => 'Nacional'),
            array('nome' => 'Internacional'),
        );
        foreach ($generos as $genero) {
            Genero::create($genero);
        }

    }
}
