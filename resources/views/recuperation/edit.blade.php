<x-app-layout>

    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <h3 class="card-title">Edit commande</h3>
                        </div>
                        <h5  style="float: right;margin-right:50px;margin-top:-40px" class="card-title btn btn-outline-primary">Total à payer :  <span class="somme_totale">{{$commande->total}} Ar</span></h5>
                        <hr>
                        <form action="{{route('commande.updateRecup',$commande->id)}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Info client</h4>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Nom du client</label>
                                    <input type="text"  value="{{$commande->client->name}}" class="form-control dt-full-name" id="name" placeholder="ex : Safidy Mahafaly " name="name_client" required/>
                                    <input type="hidden" value="{{$commande->client->id}}" name="client_id"/>
                                    <input type="hidden" name="somme" id="somme" value="{{$commande->total}}">
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <h4>Produit à commander</h4>
                                @foreach ($commande->details as $index => $detail)
                                    <div class="row contenue_produit_cmd">
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="basic-icon-default-fullname">Nom du produit</label>
                                            <input type="text" value="{{$detail->produit->name}}" class="form-control dt-full-name name_produit" autocomplete="off" id="name_produit" placeholder="ex : Coca cola" name="name_produit[]" required/>
                                            <input type="hidden" value="{{$detail->produit->id}}" id="id_produit" class="id_produit" name="id_produit[]">
                                            <div class="contenue">
                                                <div class="produit_suggerer"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="basic-icon-default-fullname">Reference</label>
                                            <input type="tel" value="{{$detail->produit->reference}}" class="form-control dt-full-name reference_produit" name="reference[]" id="basic-icon-default-fullname" placeholder="ex : CO-PM-01 " required/>
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="basic-icon-default-fullname">Prix</label>
                                            <input type="text" value="{{$detail->produit->selling_price}}" class="form-control dt-full-name prix_vente" name="prix_vente[]" id="basic-icon-default-fullname" placeholder="ex : 12 000 Ar "  required/>
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label class="form-label" for="basic-icon-default-fullname">Quatité</label>
                                            <input type="number" value="{{$detail->quantity}}" class="form-control dt-full-name" name="quantite[]" id="basic-icon-default-fullname" placeholder="quantity"  required/>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            @if ($index === 0)
                                                <button class="btn btn-primary add-card">Add</button>
                                            @else
                                                <button class="btn btn-danger remove-card">Del</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <div class="nex-prod"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/commande" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    @push('scripts-bottom')
        <script src="{{asset('app-assets/js/scripts/pages/app-edit-commande-recup.js')}}"></script>
    @endpush
</x-app-layout>

