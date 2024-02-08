<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">

                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Liste des utilisateur  & Roles</h4>
                        {{-- <div class="row">
                            <div class="col-md-4 user_role"></div>
                            <div class="col-md-4 user_plan"></div>
                            <div class="col-md-4 user_status"></div>
                        </div> --}}
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="user-utilisateur-table table">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                - {{$role->name}}
                                            @endforeach
                                        </td>
                                        <td>
                                            <a class="edit btn btn-info btn-sm "  data-bs-toggle="modal" data-bs-target="#modals-edit-in" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-role-id="{{$user->roles->first()->id}}"><i class="fa-solid fa-pen-to-square" ></i></a>
                                            <a href="/deleteUser/{{$user->id}}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal to add new user starts-->
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-fournisseur-in">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" action="{{route('utilisateur.store')}}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Add user</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="ex : Kanto " name="name" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Email</label>
                                        <input type="email" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="ex :  Kanto@gmail.com" name="email" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Password</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname"  name="password" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-contact">Role</label>
                                        <select id="country" name="role" class=" form-select" required>
                                            <option value="" selected hidden>Selectioner role</option>
                                            <option value="Admin" >Admin</option>
                                            <option value="Agent" >Agent</option>
                                            <option value="Magasinier">Magasinier</option>


                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal modal-slide-in new-user-modal fade" id="modals-edit-in">
                        <div class="modal-dialog">
                            <form class="modal-content pt-0" action="{{route('utilisateur.update')}}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                        <input type="text" class="form-control dt-full-name" id="name_u" placeholder="ex : Kanto " name="name" required/>
                                        <input type="hidden" id="id_u" name="id">
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Email</label>
                                        <input type="email" class="form-control dt-full-name" id="email_u" placeholder="ex :  Kanto@gmail.com" name="email" required/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">New password</label>
                                        <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname"  name="password" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-contact">Role</label>
                                        <select id="role_u" name="role" class="form-select" required>
                                            <option value="" selected hidden>Selectioner role</option>
                                            <option value="Admin" data-role-id="2">Admin</option>
                                            <option value="Agent" data-role-id="3">Agent</option>
                                            <option value="Magasinier" data-role-id="5">Magasinier</option>
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
    @push('scripts-bottom')
        <script src="{{asset('app-assets/js/scripts/pages/app-utilisateur-list.js')}}"></script>
    @endpush
</x-app-layout>
