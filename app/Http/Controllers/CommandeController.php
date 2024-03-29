<?php

namespace App\Http\Controllers;

use App\Events\commandeEvent;
use App\Models\Client;
use App\Models\Livreur;
use App\Models\Produit;
use Illuminate\Support\Facades\Redis;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Commande_detail;
use App\Models\Livreur_commande;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Models\User;
use Illuminate\Console\Command;
use Dompdf\Options;
use Dompdf\Dompdf;
use NumberToWords\NumberToWords;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($date = null)
    {
        if($date){
            $aujourdhui = is_string($date) ? \Carbon\Carbon::parse($date) : $date;
        }else{
            // $aujourdhui = Carbon::tomorrow()->toDateString();
            $aujourdhui = Carbon::tomorrow();

        // Vérifier si demain est un dimanche
            if ($aujourdhui->isSunday()) {
                // Si demain est dimanche, ajoutez deux jours pour obtenir la date de lundi
                $aujourdhui->addDays(1);
            }
        }
        $livreurs = Livreur::all();
        $commandes = Commande::orderBy('id', 'desc')->whereDate('created_at',$aujourdhui)->with('client','user','details','livreur')->get();
        // dd($commandes);
        return view('commandes.index',compact('livreurs','commandes','aujourdhui'));
    }
    public function colis($date = null)
    {
        if($date){
            $aujourdhui = is_string($date) ? \Carbon\Carbon::parse($date) : $date;
        }else{
            // $aujourdhui = Carbon::tomorrow()->toDateString();
            $aujourdhui = Carbon::tomorrow();

        // Vérifier si demain est un dimanche
            if ($aujourdhui->isSunday()) {
                // Si demain est dimanche, ajoutez deux jours pour obtenir la date de lundi
                $aujourdhui->addDays(1);
            }
        }
        $livreurs = Livreur::all();
        $commandes = Commande::orderBy('id', 'desc')->where('colis',1)->whereDate('created_at',$aujourdhui)->with('client','user','details','livreur')->get();
        // dd($commandes);
        return view('commandes.indexColis',compact('livreurs','commandes','aujourdhui'));
    }

    public function getCommande(Request $request)
    {
       // Récupérer l'utilisateur actuel
        // Récupérer l'utilisateur actuel
        $user = Auth::user();

        // Récupérer la date de la requête
        $date = $request->input('date');

        // Construire la requête en fonction de la date
        $query = Commande::with('client', 'user', 'details.produit')->where('status','!=','6');

        if ($user->hasRole('agent')) {
            // Si l'utilisateur a le rôle 'agent', filtrez les commandes par son ID d'utilisateur
            $query->where('user_id', $user->id);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        } else {
            // Si aucune date n'est spécifiée, afficher uniquement les commandes créées aujourd'hui
            $query->whereDate('created_at', Carbon::today());
            $query->where(function ($query) {
                $query->where('status', '=', '1')
                    ->orWhere('status', '=', '5');
            });
        }

        // Exécutez la requête et récupérez les commandes
        $commandes = $query->get();

        return response()->json($commandes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aujourdhui = Carbon::tomorrow();

        // Vérifier si demain est un dimanche
        if ($aujourdhui->isSunday()) {
            // Si demain est dimanche, ajoutez deux jours pour obtenir la date de lundi
            $aujourdhui->addDays(1);
        }
        return view('commandes.create',compact('aujourdhui'));
    }


    public function recuperation()
    {
        $commandes = Commande::where('status',6)->with('client', 'user', 'details.produit')->get();
        return view('recuperation.index',compact('commandes'));
    }

    public function create_recuperation()
    {
        return view('recuperation.create');
    }



    public function editRecup($id){
        $commande = Commande::with('client', 'user', 'details.produit')->findOrFail($id);
        return view('recuperation.edit',compact('commande'));
    }


    public function updateRecup(Request $request,$id){
        $commande = Commande::findOrFail($id);
        $client = Client::where('id',$request->client_id)->first();
        $client->update([
            'name'    => $request->name_client,
        ]);

        $commande->update([
            'total' => $request->somme,
        ]);
        Commande_detail::where('commande_id',$id)->delete();
        $produit = $request->id_produit;
        $quatite = $request->quantite;
        $prix    = $request->prix_vente;
        for($i = 0; $i < count($produit); $i++){
            Commande_detail::create([
                'commande_id' => $commande->id,
                'produit_id'  => $produit[$i],
                'quantity'    => $quatite[$i],
                'prix'        => $prix[$i]
            ]);
        }
        return redirect('/recupretion');
    }

    public function getClient(Request $request)
    {
        $mot_cle = $request->cle;
        $client = Client::where('phone', 'like','%'.$mot_cle.'%')->get();
        return response()->json($client);
    }

    public function getCommCliend(Request $request)
    {
        $id = $request->id;
        $commande = Commande::where('client_id',$id)->with('details.produit','user')->get();
        return response()->json($commande);
    }


    public function getProduitCom(Request $request)
    {
        $mot_cle = $request->cle;
        $produit = Produit::where('name','like','%'.$mot_cle.'%')->where('purchase_price','!=',null)->get();
        return response()->json($produit);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommandeRequest $request)
    {
        // DB::beginTransaction();
        // try {
            if($request->client_id){
                $client_id = $request->client_id;
            }else{
                if($request->name_client){
                    $nom = $request->name_client;
                }else{
                    $nom = $request->name_client;
                }
                $client = Client::create([
                    'name'    => $nom,
                    'fb_name' => $nom,
                    'phone' => $request->phone,
                    'adress' => $request->adress,
                ]);
                $client_id = $client->id;
            }
            if($request->date_livraison !== null){
                $date = $request->date_livraison;
            }else{
                $date =  Carbon::today();
            }
            if($request->lieux_livraison){
                $lieu = $request->lieux_livraison;
            }else{
                $lieu = $client->adress;
            }
            $commande = Commande::create([
                'user_id'         => Auth::id(),
                'client_id'       => $client_id,
                'total'           => $request->somme,
                'status'          => 1,
                'source'          => $request->source,
                'reference'        => $request->remarque,
                'lieu_livraison'  => $lieu,
                'date_livraison'  => $request->date_livraison,
                'heure'           => $request->heure_livraison,
                'frais_livraison' => $request->frais_livraison,
                'payer'           => $request->paye,
                'created_at'      => $date,
                'colis'           => $request->colis,
                'mode_payement'   => $request->modeP,
                'remarque'        => $request->note
            ]);

            $produit = $request->id_produit;
            $quatite = $request->quantite;
            $prix    = $request->prix_vente;
            for($i = 0; $i < count($produit); $i++){
                Commande_detail::create([
                    'commande_id' => $commande->id,
                    'produit_id'  => $produit[$i],
                    'quantity'    => $quatite[$i],
                    'prix'        => $prix[$i]
                ]);
                $prod = Produit::find($produit[$i]);
                $prod->update([
                    'unity' => $prod->unity -  $quatite[$i]
                ]);
            }
            // DB::commit();
            return redirect()->route('commande.index');
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return back();
        // }
    }

    public function store_recuperation(StoreCommandeRequest $request){
        DB::beginTransaction();
        try {
            $client = Client::create([
                'name'    => $request->name_client,
            ]);
            $payer = 1;
            $client_id = $client->id;
            $date =  Carbon::today();
            $commande = Commande::create([
                'user_id'         => Auth::id(),
                'client_id'       => $client_id,
                'total'           => $request->somme,
                'status'          => 6,
                'payer'           => $payer,
                'created_at'      => $date
            ]);
            // dd($commande);
            $produit = $request->id_produit;
            $quatite = $request->quantite;
            $prix    = $request->prix_vente;
            for($i = 0; $i < count($produit); $i++){
                Commande_detail::create([
                    'commande_id' => $commande->id,
                    'produit_id'  => $produit[$i],
                    'quantity'    => $quatite[$i],
                    'prix'        => $prix[$i]
                ]);
                $prod = Produit::find($produit[$i]);
                $prod->update([
                    'unity' => $prod->unity -  $quatite[$i]
                ]);
            }
            DB::commit();
            return redirect('/recupretion');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back();
        }
    }

    public function lireurCommande(StoreCommandeRequest $request)
    {
        $commande   = $request->commande;
        $livreur_id = $request->livreur_id;
        for($i = 0; $i < count($commande); $i++){
            $commande_livrai = Commande::where('id',$commande[$i])->first();
            $existe = Livreur_commande::where('commande_id',$commande[$i])->first();
            if($existe){
                if($existe->livreur_id !== $livreur_id){
                    Livreur_commande::where('commande_id',$commande[$i])->delete();
                    Livreur_commande::create([
                        'livreur_id'  => $livreur_id,
                        'commande_id' => $commande[$i],
                        'created_at'  => $commande_livrai->created_at,
                    ]);
                }else{
                    Livreur_commande::where('id',$commande[$i])->update([
                        'livreur_id'  => $request->livreur_id,
                        'created_at'  => $commande_livrai->created_at,
                    ]);
                }
            }else{
                Livreur_commande::create([
                    'livreur_id'  => $livreur_id,
                    'commande_id' => $commande[$i],
                    'created_at'  => $commande_livrai->created_at,
                ]);
            }
        }
        Commande::whereIn('id',$commande)->update(['status' => '2']);
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $commande = Commande::with('client', 'user', 'details.produit')->findOrFail($id);
        return view('commandes.edit',compact('commande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommandeRequest $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $client = Client::where('phone',$request->phone)->first();
        if($client){
            $client_id = $client->id;
        }else{
            $client = Client::create([
                'name'    => $request->name_client,
                'fb_name' => $request->fb_name,
                'phone' => $request->phone,
                'adress' => $request->adress,
            ]);
            $client_id = $client->id;
        }
        $commande->update([
            // 'user_id'         => Auth::id()
            'client_id'       => $client_id,
            'total'           => $request->somme,
            'source'          => $request->source,
            'reference'       => $request->remarque,
            'lieu_livraison'  => $request->lieux_livraison,
            'date_livraison'  => $request->date_livraison,
            'heure'           => $request->heure_livraison,
            'frais_livraison' => $request->frais_livraison,
            'payer'           => $request->paye,
            'created_at'      => $request->date_livraison,
            'colis'           => $request->colis,
            'mode_payement'   => $request->modeP

        ]);
        Livreur_commande::where('commande_id',$id)->update(['created_at' => $request->date_livraison]);
        Commande_detail::where('commande_id',$id)->delete();
        $produit = $request->id_produit;
        $quatite = $request->quantite;
        $prix    = $request->prix_vente;
        for($i = 0; $i < count($produit); $i++){
            Commande_detail::create([
                'commande_id' => $commande->id,
                'produit_id'  => $produit[$i],
                'quantity'    => $quatite[$i],
                'prix'        => $prix[$i]
            ]);
        }
        return redirect()->route('commande.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        Commande_detail::where('commande_id',$commande->id)->delete();
        Livreur_commande::where('commande_id',$commande->id)->delete();
        $commande->delete();
        return back();
    }

    public function facturation($id)
    {
        $commande = Commande::with('client', 'user', 'details.produit')->findOrFail($id);
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        // Définir la taille du papier A5
        $options->set('defaultPaperSize', 'a5');
        $numberToWords = NumberToWords::transformNumber('fr', $commande->total);
        $commande->numberToWords = $numberToWords;
        // dd($commande);

        // Créez une instance de Dompdf avec les options
        $dompdf = new Dompdf($options);

        $pdf = app('dompdf.wrapper');

        // Utilisez la méthode loadView sur l'instance de la classe PDF
        $livraison_pdf = $pdf->loadView('commandes.facturationPdf', compact('commande',));
        return $livraison_pdf->stream('commandes.facturationPdf');
    }

    public function commandeDejaLivre()
    {
        $listeAgents = User::whereHas('roles', function($query){
                                $query->where('name','agent');
                            })->get();
        $commandes = Commande::where('status',3)->with(['client','details.produit'])->get();

        return view('commandes.commandeDejaLivre', compact('listeAgents','commandes'));
    }

    public function getCommandeDejaLivre(Request $request)
    {
        // Récupérer le mois et l'année à partir de la valeur du champ du formulaire
        $moisSelectionne = $request->date;

        // Convertir le format "mois-année" en deux variables distinctes (mois et année)
        list($annee, $mois) = explode('-', $moisSelectionne);

        $commandes = Commande::where('user_id',$request->user_id)->where('status',3)->whereRaw("MONTH(updated_at) = $mois AND YEAR(updated_at) = $annee")->with(['client','details.produit'])->get();

        return redirect()->route('commande.deja_livre')->with('commandes', $commandes);
    }

    public function ticket(Request $request)
    {
        $commande = Commande::findOrFail($request->id);
        $commande->update([
            'ticket' => !$commande->ticket
        ]);
        return response()->json();
    }
}
