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
                                    <th></th>
                                    <th></th>
                                    <th>Nom du client</th>
                                    <th>Téléphone</th>
                                    <th style="width: 200px">Produit</th>
                                    <th style="width: 20px">QT</th>
                                    <th>Prix unitaire</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Payé</th>
                                    <th>Crée par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

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
