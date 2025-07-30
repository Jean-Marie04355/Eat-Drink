<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester la configuration email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        $this->info("Test d'envoi d'email vers : {$email}");
        
        try {
            Mail::raw('Test email EatDrink - ' . now(), function($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email EatDrink')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            $this->info('✅ Email envoyé avec succès !');
            $this->info('Configuration email : ' . config('mail.default'));
            
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi : ' . $e->getMessage());
            $this->warn('💡 Conseil : Vérifiez votre configuration SMTP ou utilisez le driver "log" pour les tests');
        }
    }
} 