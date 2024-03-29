<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardControlleur extends Controller
{
    public function index()
    {
        // $commandes = Commande::whereDate('created_at', today())->get();

        // $beneficeJournalier = $commandes->sum(function ($commande) {
        //     return $commande->produits->sum('prix_vente') - $commande->produits->sum('prix_achat');
        // });
        // dd($beneficeJournalier);




        $aujourdHui1 = Carbon::now();
        // dd($aujourdHui->toDateTimeString());
        // Date d'il y a 7 jours
        $ilYa7Jours = $aujourdHui1->subDays(7);
        $mety =  Carbon::now();
        // Compter les commandes dans la plage de dates
        $nombreDeCommandes = Commande::whereBetween('created_at', [$ilYa7Jours, $mety])->count();
        $client = Client::count();
        $commande = Commande::whereDate('created_at', Carbon::tomorrow())->count();

        $commandesLivre = Commande::whereBetween('created_at', [$ilYa7Jours, $mety])
            ->where('status', 3) // Assurez-vous que 'status' est le bon nom de colonne
            ->count();
        $commandesEnAttente = Commande::whereBetween('created_at', [$ilYa7Jours, $mety])
            ->where('status', 1) // Assurez-vous que 'status' est le bon nom de colonne
            ->count();
        $commandesLivre = Commande::whereBetween('created_at', [$ilYa7Jours, $mety])
            ->where('status', 3) // Assurez-vous que 'status' est le bon nom de colonne
            ->count();
        $commandesAnnule = Commande::whereBetween('created_at', [$ilYa7Jours, $mety])
            ->where('status', 4) // Assurez-vous que 'status' est le bon nom de colonne
            ->count();
        // dd($nombreDeCommandes);
        if($nombreDeCommandes == 0){
            $div = 1;
        }else{
            $div = $nombreDeCommandes ;
        }
        // Calcul du pourcentage
        $pourcentageLivre = round(($commandesLivre / $div) * 100);
        $moisEnCours = Carbon::now()->month;

    // Récupérer les utilisateurs de type 'agent'
    $listeAgents = User::whereHas('roles', function($query) {
        $query->where('name', 'agent');
    })->withCount(['commandes' => function($query) use ($moisEnCours) {
        // Filtrer les commandes créées ce mois-ci avec le statut 3
        $query->whereMonth('created_at', $moisEnCours)
            ->where('status', 3);
    }])->get();
        // dd($listeAgents);

        return view('dashboard',compact('client','commande','nombreDeCommandes','pourcentageLivre','commandesEnAttente','commandesLivre','commandesAnnule','listeAgents'));
    }
}
