<?php

use Illuminate\Database\Seeder;
use App\Modelos\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Producto::class,10)->create();
    }
}
