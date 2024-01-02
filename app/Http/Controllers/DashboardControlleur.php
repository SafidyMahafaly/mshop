<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardControlleur extends Controller
{
    public function index()
    {
        $aujourdHui1 = Carbon::now();
        // dd($aujourdHui->toDateTimeString());
        // Date d'il y a 7 jours
        $ilYa7Jours = $aujourdHui1->subDays(7);
        $mety =  Carbon::now();
        // Compter les commandes dans la plage de dates
        $nombreDeCommandes = Commande::whereBetween('created_at', [$ilYa7Jours, $mety])->count();
        $client = Client::count();
        $commande = Commande::whereDate('created_at', Carbon::today())->count();

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
        $pourcentageLivre = ($commandesLivre / $div) * 100;

        return view('dashboard',compact('client','commande','nombreDeCommandes','pourcentageLivre','commandesEnAttente','commandesLivre','commandesAnnule'));
    }
}
