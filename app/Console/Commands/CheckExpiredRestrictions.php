<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restriction;
use Carbon\Carbon;

class CheckExpiredRestrictions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restrictions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier et nettoyer les restrictions expirées';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des restrictions expirées...');

        // Trouver les restrictions expirées
        $expiredRestrictions = Restriction::where('is_active', true)
            ->where('end_date', '<', now())
            ->with('entrepreneur')
            ->get();

        if ($expiredRestrictions->isEmpty()) {
            $this->info('Aucune restriction expirée trouvée.');
            return 0;
        }

        $this->info("Trouvé {$expiredRestrictions->count()} restriction(s) expirée(s).");

        $bar = $this->output->createProgressBar($expiredRestrictions->count());
        $bar->start();

        foreach ($expiredRestrictions as $restriction) {
            // Désactiver la restriction
            $restriction->update(['is_active' => false]);

            $this->line("\nRestriction désactivée pour: {$restriction->entrepreneur->email}");

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Toutes les restrictions expirées ont été désactivées.');

        return 0;
    }
} 