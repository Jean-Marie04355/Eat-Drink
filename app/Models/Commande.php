<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'user_id',
        // autres champs si besoin
    ];

   public function user() {
    return $this->belongsTo(User::class);
}

public function produits()
{
    return $this->belongsToMany(Produit::class)->withPivot('quantite');
}


}
