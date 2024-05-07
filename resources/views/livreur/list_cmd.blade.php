<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste livraison  {{$livreur->name}}</h4>
                        <h4 class="card-title">Compte : {{$sommeCommandesStatut3}} Ar</h4>
                        <input type="hidden" value="{{$livreur->name}}" id="name_liv">
                        <input type="hidden" value="{{count($commandes)}}" id="compteur">
                    </div>
                    <div class="col-md-3 p-2 d-flex">
                        <input type="hidden" id="livreur_id" value="{{$livreur->id}}" >
                        <button class="btn btn-primary">{{count($commandes)}}</button>
                        <input type="date" style="margin-left: 20px" class="form-control" id="filter_date" name="filter_date" value="{{ $date ? $date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="card-datatable table-responsive pt-0 p-1">
                        <table class="user-cmd-table table">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Lieu</th>
                                    <th>Nom du client</th>
                                    <th>Téléphone</th>
                                    <th>Produit</th>
                                    <th style="display: none">Produit</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Cree par</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commandes as $com)
                                    <tr>
                                        <td>
                                            <input type="checkbox" data-id="{{$com->commande->id}}" class="select-commande">
                                        </td>
                                        <td>{{$com->commande->lieu_livraison}}</td>
                                        <td>{{$com->commande->client->name}}</td>
                                        <td>{{$com->commande->client->phone}}</td>
                                        <td>
                                            @foreach ($com->commande->details as $det)
                                                - {{$det->produit->name}} <br>
                                            @endforeach
                                        </td>
                                        <td style="display: none">
                                            @php
                                                $produitNames = [];
                                            @endphp

                                            @foreach ($com->commande->details as $det)
                                                @php
                                                    $produitNames[] = $det->produit->name . '(' . $det->quantity . ')';
                                                @endphp
                                            @endforeach

                                            {{ implode(' + ', $produitNames ) }}
                                        </td>
                                        <td>
                                            @if($com->commande->payer == 1)
                                                - Payer ({{$com->commande->total}} Ar)
                                            @else
                                                - {{$com->commande->total}} Ar
                                            @endif
                                        </td>
                                        <td>
                                            @if($com->commande->status == '2')
                                                <span class="badge bg-info">à livre</span>
                                            @elseif ($com->commande->status == '3')
                                                <span class="badge bg-success">livré</span>
                                            @elseif ($com->commande->status == '4')
                                                <span class="badge bg-dark">Annuler</span>
                                            @elseif ($com->commande->status == '5')
                                                <span class="badge bg-secondary">Reporter</span>
                                            @endif
                                        </td>
                                        <td>{{$com->commande->user->name}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row p-1" style="margin-top:-25px" id="exportButton">
                        <div class="col-6" style="margin-left: 10px">
                            <button  data-bs-toggle="modal" data-bs-target="#livraisonLivre"  class="btn btn-primary  mt-2 livraison" ><i class="fa-solid fa-motorcycle"></i>&nbsp;Livré</button>
                            <button id="" data-bs-toggle="modal" data-bs-target="#livraisonAnnule" class="btn btn-dark mt-2  livraison"><i class="fa-solid fa-ban"></i>&nbsp;Annuler</button>
                            <button id="" data-bs-toggle="modal" data-bs-target="#livraisonReporter" class="btn btn-info mt-2  livraison" id="livraison"><i class="fa-regular fa-calendar-check"></i>&nbsp;Reporter</button>
                            <button id="" data-bs-toggle="modal" data-bs-target="#changement" class="btn btn-secondary mt-2 livraison "  id="livraison"><i class="fa-regular fa-calendar-check"></i>&nbsp;Livreur</button>
                            <button  class="btn btn-warning mt-2 pdf"  id="livraison"><i class="fa-regular fa-calendar-check"></i>&nbsp;PDF</button>
                            {{-- <button id="" class="btn btn-danger mt-2"><i class="fa-solid fa-trash"></i>&nbsp;Supprimer</button>
                            <button id="" class="btn btn-success mt-2"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Payement</button> --}}
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="livraisonLivre" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <h1 class="text-center mb-1" id="addNewCardTitle">Livraison livré</h1>
                                <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                    <div class="col-md-12">
                                        <label class="form-label" for="modalAddCardName"> Mode de mayement</label>
                                        <select id="mode_payement" name="mode_payement" class="form-select" required>
                                            <option value="" selected hidden>Selectioner la mode de payement</option>
                                            <option value="Mobil Money" >Mobil Money</option>
                                            <option value="Espece" >Espece</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="modalAddCardName">Remarque sur le client</label>
                                        <input type="text" id="remarque_livre"  class="form-control" placeholder="Masostay eee na we manja be" />
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" id="livree" class="btn btn-primary me-1 mt-1">Valider</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="livraisonAnnule" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <h1 class="text-center mb-1" id="addNewCardTitle">Livraison annulé</h1>
                                <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                    <div class="col-md-12">
                                        <label class="form-label" for="modalAddCardName">Remarque sur le client</label>
                                        <input type="text" id="modalAddCardName" class="form-control" placeholder="Masostay eee na we manja be" />
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" id="annule" class="btn btn-primary me-1 mt-1">Valider</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="livraisonReporter" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <h1 class="text-center mb-1" id="addNewCardTitle">Livraison reporter</h1>
                                <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                                    <div class="col-md-6">
                                        <label class="form-label" for="modalAddCardName">Date report</label>
                                        <input type="date" id="date_report" class="form-control"  placeholder="Masostay eee na we manja be" required/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="modalAddCardName">Heure report</label>
                                        <input type="time" id="heure_report" class="form-control" placeholder="Masostay eee na we manja be" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="modalAddCardName">Remarque sur le client</label>
                                        <input type="text" id="modalAddCardName" class="form-control" placeholder="Masostay eee na we manja be" />
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" id="reporter" class="btn btn-primary me-1 mt-1">Valider</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="changement" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <h1 class="text-center mb-1" id="addNewCardTitle">Changement livreur</h1>
                                <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                    <div class="col-md-12">
                                        <label class="form-label" for="modalAddCardName">Selectioner livreur</label>
                                        <select id="liv_id" name="liv_id" class=" form-select" required>
                                            <option value="" selected hidden>Selectioner livreur</option>
                                            @foreach ($livreurs as $liv)
                                                <option value="{{$liv->id}}" >{{$liv->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" id="changementLiv" class="btn btn-primary me-1 mt-1">Valider</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
