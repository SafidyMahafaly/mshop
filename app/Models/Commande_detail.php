<?php

namespace App\Models;

use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande_detail extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the commande that owns the Commande_detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * Get the produit that owns the Commande_detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
