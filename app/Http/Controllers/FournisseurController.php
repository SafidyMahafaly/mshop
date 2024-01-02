<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFournisseurRequest;
use App\Http\Requests\UpdateFournisseurRequest;
use App\Models\Fournisseur;
use App\Models\Produit;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fournisseur.index');
    }

    public function getFournisseur()
    {
        $fournisseur = Fournisseur::all();
        return response()->json($fournisseur);
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
    public function store(StoreFournisseurRequest $request)
    {
        Fournisseur::create($request->all());
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('fournisseur.edit',compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFournisseurRequest $request,$id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($request->all());
        return redirect()->route('fournisseur.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        Produit::where('fournisseur_id',$id)->update(['fournisseur_id' => null]);
        $fournisseur->delete();
        return back();
    }
}
