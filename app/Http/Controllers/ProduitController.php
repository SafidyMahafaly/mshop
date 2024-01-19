<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Commande;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Commande_detail;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fourniseur = Fournisseur::all();
        $categorie = Categorie::all();
        return view('produits.index',compact('fourniseur','categorie'));
    }

    public function getProduit(){
        $user = Auth::user();
        $produits = Produit::with('categorie')
        ->when($user->hasRole('agent'), function ($query) {
            // Si l'utilisateur a le rôle 'agent', ajoutez la condition sur 'selling_price'
            $query->where('selling_price', '!=', null);
        })
        ->get();
        $produits->transform(function ($produit) use ($user) {
            // Si l'utilisateur a le rôle 'agent', définissez le prix d'achat sur 0
            if ($user->hasRole('agent')) {
                $produit->purchase_price = 0;
            }

            return $produit;
        });
        return response()->json($produits);
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
    public function store(StoreProduitRequest $request)
    {
        Produit::create($request->all());
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fourniseur = Fournisseur::all();
        $categorie = Categorie::all();
        $produit = Produit::find($id);
        return view('produits.edit',compact('produit','fourniseur','categorie'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduitRequest $request, $id)
    {
        $user = Auth::user();
        $produit = Produit::find($id);
        $produit->update($request->all());
        if($user->hasRole('Magasinier')){
            return redirect('/magasinier');
        }else{
            return redirect()->route('produit.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);
        $commande = Commande_detail::where('produit_id',$id)->first();
        if($commande){
            return back()->withErrors(['message' => 'Impossible de supprimer le produit car il est associé à une commande.']);
        }

        $produit->delete();
        Session::flash('success', 'Produit supprimé avec succès.');
        return back();
    }
}
