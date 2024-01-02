<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                {{-- <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">21,459</h3>
                                    <span>Total Users</span>
                                </div>
                                <div class="avatar bg-light-primary p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">4,567</h3>
                                    <span>Paid Users</span>
                                </div>
                                <div class="avatar bg-light-danger p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user-plus" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">19,860</h3>
                                    <span>Active Users</span>
                                </div>
                                <div class="avatar bg-light-success p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user-check" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">237</h3>
                                    <span>Pending Users</span>
                                </div>
                                <div class="avatar bg-light-warning p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user-x" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste produit & Filter</h4>
                        {{-- <div class="row">
                            <div class="col-md-4 user_role"></div>
                            <div class="col-md-4 user_plan"></div>
                            <div class="col-md-4 user_status"></div>
                        </div> --}}
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-list-table table">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Reference</th>
                                    <th>Unite</th>
                                    <th>Prix d'achat</th>
                                    <th>Prix de vente</th>
                                    <th>categorie</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" action="{{route('produit.store')}}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Add produit</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="Coca " name="name" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Reference</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="CO-PM 02 " name="reference" required />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">unité</label>
                                        <input type="number" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="" name="unity" required />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-uname">Prix d'achat</label>
                                        <input type="number" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="12000 Ar" name="purchase_price"  required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Prix de vente</label>
                                        <input type="number" id="basic-icon-default-email" class="form-control dt-email" placeholder="20000 Ar" name="selling_price" required />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Déscription</label>
                                        <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="Coca cola petit" name="description"/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-contact">Categorie</label>
                                        <select id="country" name="categorie_id" class="select2 form-select">
                                            <option value="" selected hidden>Selectioner categorie</option>
                                            @forelse ($categorie as $categ)
                                                <option value="{{$categ->id}}">{{$categ->name}}</option>
                                            @empty
                                                <p>pas de categorie</p>
                                            @endforelse

                                        </select>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-contact">Fournisseur</label>
                                        <select id="country" name="fournisseur_id" class="select2 form-select">
                                            <option value="" selected hidden>Selectioner fournisseur</option>
                                            @forelse ($fourniseur as $fourniseu)
                                                <option value="{{$fourniseu->id}}">{{$fourniseu->name}}</option>
                                            @empty
                                                <p>pas de categorie</p>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="mb-1 d-none">
                                        <label class="form-label" for="basic-icon-default-company">Categorie</label>
                                        <select id="country" class="select2 form-select">
                                            <option value="Australia">USA</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Brazil">Brazil</option>
                                        </select>
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

</x-app-layout>
