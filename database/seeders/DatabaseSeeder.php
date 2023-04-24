<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategoriaSeeder::class);
        $this->call(ProductoSeeder::class);

        //php artisan migrate:refresh --seed        para agregar eliminar los productos y categorias ya existentes y en ese mismo comando hacer el nuevo seed y tener todo lo nuevo tambien. asi evitamos que se duplique informacion. 
    }
}
