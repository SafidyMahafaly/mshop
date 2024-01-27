<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">

                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste commande & Filter</h4>
                        <div class="col-2">
                            <input type="date" class="form-control" id="customDateInput">
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-commande-table table">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom du client</th>
                                    <th>Produit</th>
                                    <th>QT</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commandes as $commande)
                                    <tr>
                                        <td>{{$commande->client->name}}</td>
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
                                        <td>
                                            {{$commande->total}}&nbsp;Ar
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="/editionommandeRecup/{{$commande->id}}" class="dropdown-item">edit</a>
                                                    <a href="/deleteCommande/{{$commande->id}}" class="dropdown-item delete-record"> Delete</a>
                                                    <a href="/commande/facturation/{{$commande->id}}" class="dropdown-item delete-record">Facturation</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

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
        <script src="{{asset('app-assets/js/scripts/pages/app-recuperation-list.js')}}"></script>
    @endpush
</x-app-layout>
