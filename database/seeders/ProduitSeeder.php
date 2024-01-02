<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Créer 10 catégories
         \App\Models\Categorie::factory(10)->create();

         // Créer 10 fournisseurs
         \App\Models\Fournisseur::factory(10)->create();

         // Créer 50 produits avec des catégories et des fournisseurs liés
         Produit::factory(1000)->create();
    }
}
