<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">

                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste des fournisseur & Filter</h4>
                        {{-- <div class="row">
                            <div class="col-md-4 user_role"></div>
                            <div class="col-md-4 user_plan"></div>
                            <div class="col-md-4 user_status"></div>
                        </div> --}}
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-fournisseur-table table">
                            <thead class="table-light">
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Adresse</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-fournisseur-in">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" action="{{route('fournisseur.store')}}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Add fournisseur</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="ex : star " name="name" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Adresse</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="ex :  Andraharo" name="adress" required/>
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
