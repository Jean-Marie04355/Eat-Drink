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
         User::create([
       'nom_entreprise' => 'Admin',
        'email' => 'admin@eatdrink.test',
        'password' => Hash::make('motdepassefort'),
        'role' => 'admin',
        'motif_rejet' => null, 
    ]);
    }
}
