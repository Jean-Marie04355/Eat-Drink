<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
         'nom_entreprise' => 'Eat & Code',
        'email' => 'admin@eatdrink.com',
        'password' => Hash::make('motdepassefort'),
        'role' => 'admin',
        'motif_rejet' => null, // si ta table users contient une colonne 'role'
    ]);
    }
}
