<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MagasinerControlleur extends Controller
{
    public function index()
    {
        return view('magasinier.index');
    }
    public function detail($id)
    {
        $aujourdhui = Carbon::now()->toDateString();
        $produit = Produit::findOrFail($id);
        $historique = Historique::where('produit_id',$id)->get();
        $dateCreation = $produit->created_at;
        $maintenant = Carbon::now();

        // Calcul de la différence en jours, heures et minutes
        $diffEnJours = $maintenant->diffInDays($dateCreation);
        $diffEnHeures = $maintenant->diffInHours($dateCreation);
        $diffEnMinutes = $maintenant->diffInMinutes($dateCreation);

        // Condition pour déterminer le format d'affichage
        if ($diffEnJours > 0) {
            $message = "{$diffEnJours} jour(s).";
        } elseif ($diffEnHeures > 0) {
            $message = " {$diffEnHeures} heure(s).";
        } else {
            $message = " {$diffEnMinutes} minute(s).";
        }
        return view('magasinier.detail',compact('produit','message','historique','aujourdhui'));
    }
    public function entre(Request $request,$id)
    {
        $produit = Produit::findOrFail($id);
        $actuele = $produit->unity;
        $entre   = $request->unite;
        $sum     = $actuele + $entre;
        $produit->update([
            'unity' => $sum
        ]);
        Historique::create([
            'unite' => $request->unite,
            'produit_id' => $id,
            'type' => 'entre',
            'user_id' => Auth::user()->id
        ]);
        return back();
    }
    public function sortie(Request $request,$id)
    {
        $produit = Produit::findOrFail($id);
        $actuele = $produit->unity;
        $sortie   = $request->unite;
        $sum     = $actuele - $sortie;
        $produit->update([
            'unity' => $sum
        ]);
        Historique::create([
            'unite' => $request->unite,
            'produit_id' => $id,
            'type' => 'sortie',
            'user_id' => Auth::user()->id,
            'description' => $request->description
        ]);
        return back();

    }
}
