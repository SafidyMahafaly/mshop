<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">

                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste commande & Filter</h4>
                        <div class="col-2">
                            <input type="date" class="form-control" value="{{$aujourdhui}}" id="teste_ma">
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-commande-table table">
                            <thead class="table-light">
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th  style="width: 150px">Lieux</th>
                                    <th>Nom du client</th>
                                    <th style="width: 150px">Produit</th>
                                    <th style="width: 10px">QT</th>
                                    {{-- <th style="dis">Prix unitaire</th> --}}
                                    <th>Total</th>
                                    <th style="width: 70px">Statut</th>
                                    <th>Payé</th>
                                    <th>Crée par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commandes as $commande)
                                    <tr>
                                        <td><input type="checkbox" data-id="{{$commande->id}}" class="select-commande"></td>
                                        <td>{{$commande->lieu_livraison}}</td>
                                        <td>{{$commande->client->name }}</td>
                                        <td>
                                            @foreach ($commande->details as $det)
                                            - {{$det->produit->name}} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($commande->details as $det)
                                            - {{$det->quantity}} <br>
                                            @endforeach
                                        </td>
                                        <td>{{$commande->total}} Ar</td>
                                        <td>
                                            @if($commande->status == 1)
                                                <span class="badge bg-warning">en attente</span>
                                            @elseif ($commande->status == 2)
                                                <span class="badge bg-info">Assigner  {{$commande->livreur->livreur->name}}</span>
                                            @elseif ($commande->status == 3)
                                                <span class="badge bg-success">Livré</span>
                                            @elseif ($commande->status == 4)
                                                <span class="badge bg-dark">Annuler</span>
                                            @elseif ($commande->status == 5)
                                                <span class="badge bg-secondary">Reporter</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($commande->payer == 1)
                                                <span class="badge bg-success">Payé</span>
                                            @else
                                                <span class="badge bg-danger">Non Payé</span>
                                            @endif
                                        </td>
                                        <td>{{$commande->user->name}}</td>
                                        <td>
                                            <a href="/editCommande/{{$commande->id}}" class="btn btn-info btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="/deleteCommande/{{$commande->id}}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                    <div class="row p-1" style="margin-top:-25px" id="exportButton">
                        <div class="col-2">
                            <label class="form-label" for="basic-icon-default-company">Livreur:</label>
                            <select  class="form-select" id="livreur">
                                <option value="null" selected hidden>selection livreur</option>
                                @foreach ($livreurs as $livreur)
                                    <option value="{{$livreur->id}}">{{$livreur->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <button id="" class="btn btn-primary mt-2 livraison" id="livraison"><i class="fa-solid fa-motorcycle"></i>&nbsp;Livraison</button>
                            {{-- <button id="" class="btn btn-danger mt-2"><i class="fa-solid fa-trash"></i>&nbsp;Supprimer</button>
                            <button id="" class="btn btn-success mt-2"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Payement</button> --}}
                        </div>
                    </div>

                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-categ-in">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" action="{{route('categorie.store')}}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Add categorie</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="ex : Informatique " name="name" required/>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to add new user Ends-->
                </div>
                <!-- list and filter end -->
            </section>
        </div>
    </div>
    @push('scripts-bottom')
        <script src="{{asset('app-assets/js/scripts/pages/app-commande-list.js')}}"></script>
    @endpush
</x-app-layout>
