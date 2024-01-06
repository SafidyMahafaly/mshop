<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Edit livreur {{$livreur->name}} </h4>
                        <form action="{{route('livreur.update',$livreur->id)}}" method="POST">
                            @csrf
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" value="{{$livreur->name}}" class="form-control dt-full-name" id="name" placeholder="ex : Informatique " name="name" required/>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="text" value="{{$livreur->phone}}" class="form-control dt-full-name" id="phone" placeholder="ex : 0347023257" name="phone" required/>
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