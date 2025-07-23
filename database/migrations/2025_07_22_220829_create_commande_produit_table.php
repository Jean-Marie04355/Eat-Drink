<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::create('commande_produit', function (Blueprint $table) {
        $table->id();
        $table->foreignId('commande_id')->constrained()->onDelete('cascade');
        $table->foreignId('produit_id')->constrained()->onDelete('cascade');
        $table->integer('quantite');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_produit');
    }
};
