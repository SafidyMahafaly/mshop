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
                        <form action="{{route('commande.update',$commande->id)}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Info client</h4>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Phone</label>
                                    <input type="tel" value="{{$commande->client->phone}}" class="form-control dt-full-name" autocomplete="off" placeholder="0345092565" id="phone" name="phone" required/>
                                    <input type="hidden"  name="client_id" id="client_id" value="{{$commande->client->id}}" class="client_id">
                                    <input type="hidden" name="somme" id="somme" value="{{$commande->total}}">
                                    <div id="client_suggerer"></div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Nom du client</label>
                                    <input type="text"  value="{{$commande->client->name}}" class="form-control dt-full-name" id="name" placeholder="ex : Safidy Mahafaly " name="name_client" required/>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Nom fb</label>
                                    <input type="text" value="{{$commande->client->fb_name}}" class="form-control dt-full-name" id="fb_name" placeholder="ex : Safidy Mahafaly " name="fb_name" />
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Adresse</label>
                                    <input type="tel" value="{{$commande->client->adress}}" class="form-control dt-full-name" id="adress" placeholder="ex : Ikinaja Ambohimangakely " name="adress" required/>
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
                            <hr>
                            <div class="row">
                                <h4>Autre info</h4>
                                <div class="col-md-3 mb-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-contact">Source</label>
                                        <select id="country" name="source" class="form-select">
                                            <option value="{{$commande->source}}" selected hidden>{{$commande->source}}</option>
                                            <option value="SMS" >SMS</option>
                                            <option value="Facebook" >Facebook</option>
                                            <option value="TikTOk" >TikTOk</option>
                                            <option value="Appel" >Appel</option>
                                            <option value="Recuperation" >Recuperation</option>
                                            <option value="whatsap" >whatsap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Remarque</label>
                                    <input type="text" value="{{$commande->remarque}}"  name="remarque" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="Aterina eo am arret fin 194"  />
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label"  for="basic-icon-default-fullname">Statue du Payement</label>
                                    <select id="country" name="paye" class="form-select">
                                        <option value="0" @if($commande->payer == '0') selected @endif>Non payé</option>
                                        <option value="1" @if($commande->payer == '1') selected @endif>Payé</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label"  for="basic-icon-default-fullname">A livrer</label>
                                    <select id="country" class="form-select a_livrer">
                                        <option value="0" @if(!$commande->lieu_livraison) selected @endif>Non</option>
                                        <option value="1" @if($commande->lieu_livraison) selected @endif>Oui</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row " id="livrer">
                                <h4>Livraison</h4>
                                <div class="row">
                                    <div class="col-md-3 mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Lieux</label>
                                        <input type="text" value="{{$commande->lieu_livraison}}" class="form-control dt-full-name" id="lieu_livraison" placeholder="ex : Anosy" name="lieux_livraison" />
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Frais</label>
                                        <input type="number" value="{{$commande->frais_livraison}}" class="form-control dt-full-name" id="frais_livraison" placeholder="3000 aR" name="frais_livraison" />
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">date</label>
                                        <input type="date" value="{{ $commande->created_at ? $commande->created_at->format('Y-m-d') : '' }}" class="form-control dt-full-name"  id="date_livraison"  name="date_livraison" />
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Heure</label>
                                        <input type="time" value="{{$commande->heure}}" class="form-control dt-full-name" id="heure_livraison"  name="heure_livraison" />
                                    </div>
                                </div>
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
    <script>
        var myData = {!! json_encode($commande) !!};
    </script>
    @push('scripts-bottom')
        <script src="{{asset('app-assets/js/scripts/pages/app-edit-commande-list.js')}}"></script>
    @endpush
</x-app-layout>

