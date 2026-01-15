<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        
        DB::table('roles')->insert([
            ['id' => 1, 'nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Mesero', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Cocinero', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Luis Arturo Arce Leyva',
            'email' => 'luisarce17124@gmail.com',
            'password' => Hash::make('admin12345'),
            'rol_id' => 1,
            'email_verified_at' => now(),
        ]);

        $this->call([
        MenuSeeder::class,
    ]);
    }
}
