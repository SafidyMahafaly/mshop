<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'unity' => $this->faker->randomNumber(),
            'purchase_price' => $this->faker->randomFloat(2, 1, 100),
            'selling_price' => $this->faker->randomFloat(2, 1, 200),
            'reference' => $this->faker->word,
            'description' => $this->faker->sentence,
            'categorie_id' => Categorie::factory(),
            'fournisseur_id' => Fournisseur::factory(),
        ];
    }
}
