<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Edit produit {{$produit->name}}</h4>
                        <form action="{{route('produit.editP',$produit->id)}}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                    <input type="text" value="{{$produit->name}}" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="Coca " name="name" required/>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Reference</label>
                                    <input type="text" value="{{$produit->reference}}" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="CO-PM 02 " name="reference" required />
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">unité</label>
                                    <input type="number" value="{{$produit->unity}}" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="" name="unity" required />
                                </div>
                            </div>
                            @if(Auth::user()->hasRole('superadministrator'))
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-uname">Prix d'achat</label>
                                    <input type="number" value="{{$produit->purchase_price}}" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="12000 Ar" name="purchase_price"  required/>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-email">Prix de vente</label>
                                    <input type="number" value="{{$produit->selling_price}}" id="basic-icon-default-email" class="form-control dt-email" placeholder="20000 Ar" name="selling_price" required />
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-email">Déscription</label>
                                    <input type="text" value="{{$produit->description}}" id="basic-icon-default-email" class="form-control dt-email" placeholder="Coca cola petit" name="description"/>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label class="form-label" for="basic-icon-default-contact">Categorie</label>
                                    <select id="country" name="categorie_id" class=" form-select">
                                        @if(!$produit->categorie_id)
                                            <option value="" selected>Selectioner categorie</option>
                                        @endif
                                        {{-- <option value="" >Selectioner categorie</option> --}}
                                        @forelse ($categorie as $categ)
                                            <option value="{{$categ->id}}" @if($produit->categorie_id == $categ->id) selected @endif>{{$categ->name}}</option>
                                        @empty
                                            <p>pas de categorie</p>
                                        @endforelse

                                    </select>
                                </div>
                                <div class="col-md-4  mb-1">
                                    <label class="form-label" for="basic-icon-default-contact">Fournisseur</label>
                                    <select  name="fournisseur_id" class=" form-select">
                                        @if(!$produit->fournisseur_id)
                                            <option value="" selected>Selectioner fournisseur</option>
                                        @endif
                                        {{-- <option value="" >Selectioner fournisseur</option> --}}
                                        @forelse ($fourniseur as $fourniseu)
                                            <option value="{{$fourniseu->id}}"  @if($produit->fournisseur_id == $fourniseu->id) selected @endif>{{$fourniseu->name}}</option>
                                        @empty
                                            <p>pas de categorie</p>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <button class="btn btn-outline-secondary">Cancel</button>
                                    <button class="btn btn-primary">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
