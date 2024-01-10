<?php

namespace App\Models;

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;
    protected $guarded = [];



    public static function boot()
    {
        parent::boot();

        // Événement lors de la création d'un produit
        self::creating(function ($product) {
            $product->generateReference();
        });
    }

    // Méthode pour générer la référence
    public function generateReference()
    {
        $name = $this->name;

         // Utiliser les deux premières lettres du nom du produit
         $productCode = strtoupper(substr($name, 0, 2));
        // Générer une référence unique basée sur le nom du produit
        $reference = 'MS-' . $productCode . '-' . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);

        $this->reference = $reference;
    }

    /**
     * Get the categorie that owns the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Get the fournisseur that owns the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
}
