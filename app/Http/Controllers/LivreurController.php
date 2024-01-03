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
use App\Http\Requests\StoreLivreurRequest;
use App\Http\Requests\UpdateLivreurRequest;

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
                ->where('livreur_id', $id);

            // Si une date est fournie, filtrer par cette date
            if ($date) {
                $query->whereDate('created_at', $date);
            } else {
                // Sinon, filtrer par la date d'aujourd'hui
                $query->whereDate('created_at', Carbon::today());
            }

            $commandes = $query->get();

            return view('livreur.list_cmd', compact('commandes', 'livreur'));
        }
    }

    public function changeStatus(StoreLivreurRequest $request)
    {
        $commande = Commande::whereIn('id',$request->id)->get();
        foreach($commande as $com){
            Client::where('id',$com->client_id)->update(['remarque' => $request->remarque]);
        }
        Commande::whereIn('id',$request->id)->update(['status' => '3']);
        Commande::whereIn('id',$request->id)->update(['payer' => '1']);
        return response()->json();
    }

    public function changeStatusAnnuler(StoreLivreurRequest $request)
    {
        $commande = Commande::whereIn('id',$request->id)->get();
        foreach($commande as $com){
            Client::where('id',$com->client_id)->update(['remarque' => $request->remarque]);
        }
        Commande::whereIn('id',$request->id)->update([
            'status' => '4',
            'payer' => '0'
        ]);
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


    public function genererPDF(){
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Créez une instance de Dompdf avec les options
        $dompdf = new Dompdf($options);

        $commandes = Livreur_commande::with('commande.details', 'commande.client', 'commande.user','commande.details.produit','commande.details.produit.categorie')
            ->where('livreur_id', 7)
            ->get();


        // dd($commandes);
        // Utilisez l'injection de dépendances pour obtenir une instance de la classe PDF
        // return view('livreur.pdf', compact('commandes'));

        $pdf = app('dompdf.wrapper');

        // Utilisez la méthode loadView sur l'instance de la classe PDF
        $livraison_pdf = $pdf->loadView('livreur.pdf', compact('commandes'));

        return $livraison_pdf->stream('livreur.pdf');
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
    public function destroy(Livreur $livreur)
    {
        //
    }
}
