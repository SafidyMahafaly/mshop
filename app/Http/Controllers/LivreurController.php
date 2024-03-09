<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Client;
use App\Models\Livreur;
use App\Models\Commande;
use Barryvdh\DomPDF\PDF;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Carbon;
use App\Models\Livreur_commande;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreLivreurRequest;
use App\Http\Requests\UpdateLivreurRequest;
use App\Models\Produit;

class LivreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livreur.index');
    }

    public function getLivreur()
    {
        $livreur = Livreur::all();
        return response()->json($livreur);
    }

    public function voir_commande($id,$date = null)
    {
        $livreur = Livreur::findOrFail($id);
        if ($livreur) {
            $query = Livreur_commande::with('commande.details', 'commande.client', 'commande.user', 'commande.details.produit', 'commande.details.produit.categorie')
                    ->orderBy('id', 'desc')
                    ->where('livreur_id', $id);


            // Si une date est fournie, filtrer par cette date
            if ($date) {
                $query->whereDate('created_at', $date);
            } else {
                // Sinon, filtrer par la date d'aujourd'
                $aujourdhui = Carbon::tomorrow();

                // Vérifier si demain est un dimanche
                if ($aujourdhui->isSunday()) {
                    // Si demain est dimanche, ajoutez deux jours pour obtenir la date de lundi
                    $aujourdhui->addDays(1);
                }
                $query->whereDate('created_at', $aujourdhui);
            }
            $commandes = $query->get();
            $commandeIds = [];

            foreach ($commandes as $livreurCommande) {
                $commandeIds[] = $livreurCommande->commande_id;
            }
            $sommeCommandesStatut3 = Commande::whereIn('id', $commandeIds)
                                    ->where('status', 3)
                                    // ->where('payer', 1)
                                    ->where('mode_payement','espece')
                                    ->sum('total');


            if($date){
                $date = is_string($date) ? \Carbon\Carbon::parse($date) : $date;
            }else{
                $date = Carbon::tomorrow();
                // Vérifier si demain est un dimanche
                if ($date->isSunday()) {
                    // Si demain est dimanche, ajoutez deux jours pour obtenir la date de lundi
                    $date->addDays(1);
                }
            }
            $livreurs = Livreur::all();
            return view('livreur.list_cmd', compact('commandes', 'livreur','date','id','livreurs','sommeCommandesStatut3'));
        }
    }

    public function changeStatus(StoreLivreurRequest $request)
    {
        $commande = Commande::whereIn('id',$request->id)->get();
        foreach($commande as $com){
            Client::where('id',$com->client_id)->update(['remarque' => $request->remarque]);
        }
        Commande::whereIn('id',$request->id)->update([
            'status' => '3',
            'payer' => '1',
            'mode_payement' => $request->mode
        ]);
        return response()->json();
    }

    public function changeStatusLivreur(StoreLivreurRequest $request)
    {
        $commande = Commande::whereIn('id',$request->id)->get();
        foreach($commande as $com){
            Livreur_commande::where('commande_id',$com->id)->update([
                'livreur_id' => $request->livreur,
                'created_at' => $com->created_at,
            ]);
        }
        return response()->json();
    }

    public function changeStatusAnnuler(StoreLivreurRequest $request)
    {
        $commandes = Commande::whereIn('id', $request->id)->with('details.produit')->get();

        foreach ($commandes as $commande) {
            foreach ($commande->details as $detail) {
                // Mettre à jour l'unité du produit
                $nouvelleUnite = $detail->produit->unity + $detail->quantity;

                // Mettre à jour l'unité du produit dans la table des produits
                $detail->produit->update(['unity' => $nouvelleUnite]);
            }
        }

        // Mettre à jour le statut de la commande et le champ payer
        Commande::whereIn('id', $request->id)->update([
            'status' => '4',
            'payer' => '0'
        ]);
        // Mettre à jour la remarque du client
        Client::whereIn('id', $commandes->pluck('client_id'))->update(['remarque' => $request->remarque]);
        return response()->json();
    }


    public function changeStatusReporter(StoreLivreurRequest $request)
    {
        $commande = Commande::whereIn('id',$request->id)->get();
        foreach($commande as $com){
            Client::where('id',$com->client_id)->update(['remarque' => $request->remarque]);
        }
        Commande::whereIn('id',$request->id)->update([
            'status' => '5',
            'created_at' => $request->date,
            'heure' => $request->heure,
            'date_livraison' => $request->date
        ]);
        return response()->json();
    }


    public function genererPDF(StoreLivreurRequest $request){
         // Définir les options de Dompdf
         if (!is_array($request->commande)) {
            // Convertir en tableau si ce n'est pas déjà le cas
            $commandes = explode(',', $request->commande);
        } else {
            $commandes = $request->commande;
        }
        // dd($commandes)
         $options = new Options();
         $options->set('isHtml5ParserEnabled', true);

         // Créer une instance de Dompdf avec les options
         $dompdf = new Dompdf($options);

         // Récupérer les données nécessaires pour générer le PDF
        $commandes = Livreur_commande::with('commande.details', 'commande.client', 'commande.user', 'commande.details.produit', 'commande.details.produit.categorie')
             ->where('livreur_id', $request->livreur_id)
             ->whereIn('commande_id', $commandes)
             ->get()
             ->sortBy(function($livreur_commande) {
                return $livreur_commande->commande->details->count();
            });
        $livreur = Livreur::find($request->livreur_id);

         // Charger la vue PDF avec les données récupérées
         $pdf = app('dompdf.wrapper');
         $livraison_pdf = $pdf->loadView('livreur.pdf', compact('commandes','livreur'));

         // Récupérer les données binaires du PDF
         $pdfContent = $livraison_pdf->output();

         // Retourner les données binaires du PDF dans la réponse avec le bon type de contenu
         return Response::make($pdfContent, 200, [
             'Content-Type' => 'application/pdf',
             'Content-Disposition' => 'inline; filename="livreur.pdf"'
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLivreurRequest $request)
    {
        $livreur = Livreur::create($request->all());
        toastr('Création de livreur '.$request->name.' bien effectué.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Livreur $livreur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit ($id) //(Livreur $livreur)
    {
        try {
            $livreur = Livreur::findOrFail($id);
        } catch (\Throwable $th) {
            toastr()->error('Ce livreur n\'existe pas!');
            return back();
        }
        return view('livreur.edit', compact('livreur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, StoreLivreurRequest $request) //(UpdateLivreurRequest $request, Livreur $livreur)
    {
        try {
            $livreur = Livreur::findOrFail($id);
            $livreur->update($request->all());
            toastr('Modification de livreur '.$request->name.' bien effectué.');
        } catch (\Throwable $th) {
            toastr()->error('Ce livreur n\'existe pas!');
        }
        return redirect()->route('livreur.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) //(Livreur $livreur)
    {
        try {
            $livreur = Livreur::findOrFail($id);
            toastr('Suppression de livreur '.$livreur->name.' bien effectué.');
            $livreur->delete();
        } catch (\Throwable $th) {
            toastr()->error('Ce livreur n\'existe pas!');
        }
        return redirect()->route('livreur.index');
    }
}
