<?php

use Illuminate\Database\Seeder;
use App\Modelos\Comentario;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comentario::class,10)->create();
    }
}
