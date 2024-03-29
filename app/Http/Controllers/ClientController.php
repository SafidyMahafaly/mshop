<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.index');
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
    public function store(Request $request) //(StoreClientRequest $request) tokony mampiasa an'io fa mahazo erreur 403 fona za ref mampiasa an'io
    {
        Client::create($request->all());
        toastr($request->name.' est bien ajouté dans notre client.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $client = Client::findOrFail($id);
        } catch (\Throwable $th) {
            toastr()->error('Ce client n\'existe pas!');
            return back();
        }
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->update($request->all());
            toastr('La modification du client '.$client->name.' est bien réussi.');
        } catch (\Throwable $th) {
            toastr()->error('Ce client n\'existe pas');
        }
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) //(Client $client)
    {
        $client = Client::findOrFail($id);
        $com = Commande::where('client_id',$client->id)->first();
        if($com){
            return back()->withErrors(['message' => 'Impossible de supprimer ce client car il est associé à une commande.']);
        }
        $client->delete();
        return redirect()->route('client.index');
    }

    /*** Get all client */
    public function getAllClient()
    {
        $clients = Client::all();
        return response()->json($clients);
    }
}
