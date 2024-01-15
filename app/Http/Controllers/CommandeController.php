<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Livreur;
use App\Models\Produit;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Commande_detail;
use App\Models\Livreur_commande;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use Illuminate\Console\Command;
use Dompdf\Options;
use Dompdf\Dompdf;
use NumberToWords\NumberToWords;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livreurs = Livreur::all();
        // $commandes = Commande::with('client','user','details')->get();
        return view('commandes.index',compact('livreurs'));
    }

    public function getCommande(Request $request)
    {
       // Récupérer l'utilisateur actuel
        $user = Auth::user();

        // Récupérer la date de la requête
        $date = $request->input('date');

        // Construire la requête en fonction de la date
        $query = Commande::with('client', 'user', 'details.produit');

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

        return response($commandes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aujourdhui = Carbon::now()->toDateString();
        return view('commandes.create',compact('aujourdhui'));
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
        // dd($request->all());
        DB::beginTransaction();
        try {
            if($request->client_id){
                $client_id = $request->client_id;
            }else{
                $client = Client::create([
                    'name'    => $request->name_client,
                    'fb_name' => $request->fb_name,
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
            $commande = Commande::create([
                'user_id'         => Auth::id(),
                'client_id'       => $client_id,
                'total'           => $request->somme,
                'status'          => 1,
                'source'          => $request->source,
                'remarque'        => $request->remarque,
                'lieu_livraison'  => $request->lieux_livraison,
                'date_livraison'  => $request->date_livraison,
                'heure'           => $request->heure_livraison,
                'frais_livraison' => $request->frais_livraison,
                'payer'           => $request->paye,
                'created_at'      => $date
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
            DB::commit();
            return redirect()->route('commande.index');
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
            'user_id'         => Auth::id(),
            'client_id'       => $client_id,
            'total'           => $request->somme,
            // 'status'          => 1,
            'source'          => $request->source,
            'remarque'        => $request->remarque,
            'lieu_livraison'  => $request->lieux_livraison,
            'date_livraison'  => $request->date_livraison,
            'heure'           => $request->heure_livraison,
            'frais_livraison' => $request->frais_livraison,
            'payer'           => $request->paye,
            'created_at'      => $request->date_livraison
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
        // dd($commande);
        // foreach($commande->details as $d){
        //     dd($d);
        // }
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
}
