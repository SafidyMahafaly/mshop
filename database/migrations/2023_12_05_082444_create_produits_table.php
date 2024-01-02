<?php

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unity');
            $table->string('purchase_price');
            $table->string('selling_price');
            $table->string('reference');
            $table->string('description');
            $table->foreignIdFor(Categorie::class)->nullable();
            $table->foreignIdFor(Fournisseur::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
