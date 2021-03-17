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
            array('nome' => 'Aventura'),
            array('nome' => 'Crime'),
            array('nome' => 'Comédia'),
            array('nome' => 'Melodrama'),
            array('nome' => 'Drama'),
        );
        foreach ($generos as $genero) {
            Genero::create($genero);
        }

    }
}
