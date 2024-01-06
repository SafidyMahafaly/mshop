<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">

                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste des clients</h4>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="client-list-table table">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>FB Name</th>
                                    <th>Phone</th>
                                    <th>Adress</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-client-in">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" action="{{route('client.store')}}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">Add client</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" class="form-control dt-full-name" id="name" placeholder="ex : Koto " name="name" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="fb_name">FB Name</label>
                                        <input type="text" class="form-control dt-full-name" id="fb_name" placeholder="ex : RK Koto " name="fb_name" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" class="form-control dt-full-name" id="phone" placeholder="ex : 0347023257 " name="phone" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="adress">Adress</label>
                                        <input type="text" class="form-control dt-full-name" id="adress" placeholder="ex : Ankadindramamy " name="adress" required/>
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
        <script src="{{asset('app-assets/js/scripts/pages/app-client-list.js')}}"></script>
    @endpush

</x-app-layout>
