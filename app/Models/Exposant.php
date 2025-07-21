<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exposant extends Model
{
    use HasFactory;
        protected $table = 'exposants'; // si ta table s'appelle exposants
    protected $fillable = [
        'nom_entreprise',
        'email',
        'description',
        'statut',
        // autres champs
    ];
    // Facultatif : si la table n'est pas "exposants"
    // protected $table = 'nom_de_ta_table';
}
