<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Produit;

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
        $produits = Produit::with('categorie')->get();
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
        $produit = Produit::find($id);
        $produit->update($request->all());
        return redirect()->route('produit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);
        $produit->delete();
        return back();
    }
}
