<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livreur_commande extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the commande that owns the Livreur_commande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
    public function livreur()
    {
        return $this->belongsTo(Livreur::class);
    }

}
