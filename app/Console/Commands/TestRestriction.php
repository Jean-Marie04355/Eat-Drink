<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Restriction;
use Carbon\Carbon;

class TestRestriction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restriction:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste si un utilisateur a une restriction active';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("🔍 Vérification des restrictions pour: {$email}");
        
        // Trouver l'utilisateur
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("❌ Utilisateur non trouvé avec l'email: {$email}");
            return 1;
        }
        
        $this->info("✅ Utilisateur trouvé: {$user->name} (ID: {$user->id})");
        $this->info("📋 Rôle: {$user->role}");
        
        // Vérifier les restrictions actives
        $activeRestrictions = Restriction::where('entrepreneur_id', $user->id)
            ->where('is_active', true)
            ->where('end_date', '>', now())
            ->get();
            
        if ($activeRestrictions->isEmpty()) {
            $this->info("✅ Aucune restriction active trouvée");
            
            // Afficher toutes les restrictions (même inactives)
            $allRestrictions = Restriction::where('entrepreneur_id', $user->id)->get();
            
            if ($allRestrictions->isEmpty()) {
                $this->info("📝 Aucune restriction trouvée pour cet utilisateur");
            } else {
                $this->info("📝 Historique des restrictions:");
                foreach ($allRestrictions as $restriction) {
                    $status = $restriction->is_active ? '🔴 ACTIVE' : '⚪ INACTIVE';
                    $this->line("  - {$restriction->type} ({$status}) - {$restriction->motif}");
                }
            }
        } else {
            $this->error("🔴 Restrictions actives trouvées:");
            foreach ($activeRestrictions as $restriction) {
                $daysLeft = now()->diffInDays($restriction->end_date, false);
                $this->error("  - Type: {$restriction->type}");
                $this->error("  - Motif: {$restriction->motif}");
                $this->error("  - Fin: {$restriction->end_date}");
                $this->error("  - Jours restants: {$daysLeft}");
            }
        }
        
        // Vérifier si l'utilisateur peut se connecter
        if ($user->role === 'entrepreneur_approuve' && $activeRestrictions->isNotEmpty()) {
            $this->warn("⚠️  Cet utilisateur ne devrait PAS pouvoir se connecter");
            $this->warn("   Le middleware devrait le rediriger vers la page de restriction");
        } else {
            $this->info("✅ Cet utilisateur peut se connecter normalement");
        }
        
        return 0;
    }
} 