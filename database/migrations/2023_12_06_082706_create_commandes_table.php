<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Client::class);
            $table->decimal('total', 10, 2);
            $table->string('status');
            $table->string('source')->nullable();
            $table->string('remarque')->nullable();
            $table->string('lieu_livraison')->nullable();
            $table->date('date_livraison')->nullable();
            $table->time('heure')->nullable();
            $table->integer('payer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
