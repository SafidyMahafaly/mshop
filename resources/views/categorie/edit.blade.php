<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Edit categorie {{$categorie->name}} </h4>
                        <form action="{{route('produit.editC',$categorie->id)}}" method="POST">
                        @csrf
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                <input type="text" value="{{$categorie->name}}" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="ex : Informatique " name="name" required/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <a href="/categorie" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>

