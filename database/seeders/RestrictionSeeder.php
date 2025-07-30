<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restriction;
use App\Models\User;
use Carbon\Carbon;

class RestrictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Trouver un entrepreneur pour tester
        $entrepreneur = User::where('role', 'entrepreneur_approuve')->first();
        $admin = User::where('role', 'admin')->first();

        if (!$entrepreneur || !$admin) {
            $this->command->info('Aucun entrepreneur ou admin trouvé pour créer des restrictions de test.');
            return;
        }

        // Créer quelques restrictions de test
        $restrictions = [
            [
                'entrepreneur_id' => $entrepreneur->id,
                'admin_id' => $admin->id,
                'type' => 'temporaire',
                'duration' => 7,
                'start_date' => now(),
                'end_date' => now()->addDays(7),
                'motif' => 'Test de restriction temporaire - Comportement inapproprié',
                'is_active' => true,
            ],
            [
                'entrepreneur_id' => $entrepreneur->id,
                'admin_id' => $admin->id,
                'type' => 'avertissement',
                'duration' => 3,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(2),
                'motif' => 'Test d\'avertissement - Produits non conformes',
                'is_active' => false, // Déjà expirée
            ],
        ];

        foreach ($restrictions as $restrictionData) {
            Restriction::create($restrictionData);
        }

        $this->command->info('Restrictions de test créées avec succès !');
    }
} 