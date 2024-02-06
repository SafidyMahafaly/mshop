<x-app-layout>
    <div class="py-12">
        <div class="">
            <section class="app-user-list">
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <h3 class="card-title">Liste des commades déjà livré</h3>
                        </div>
                        <form action="{{ route('commande.get_cmd_livre') }}" id="form_agent" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-2">
                                    <label class="form-label">Mois:</label>
                                    <input type="month" class="form-control" name="date" required>
                                </div>
                                <div class="col-2">
                                    <label class="form-label">Agent:</label>
                                    <select  class="form-select" name="user_id" required>
                                        @if($listeAgents)
                                            <option value="" selected hidden>selectionner un agent</option>
                                            @foreach ($listeAgents as $agent)
                                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected hidden>il n'y a pas d'agent pour l'instant</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 1.6rem;">Valider</button>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-2">
                            <table class="commande-deja-livre table table-hover">
                                <thead>
                                  <tr>
                                    <th  >Lieux</th>
                                    <th>Nom du client</th>
                                    <th >Produit</th>
                                    <th style="width: 10px">QT</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if (session('commandes'))
                                        @foreach (session('commandes') as $commande)
                                            <tr>
                                                <th scope="row">{{ $commande->lieu_livraison }}</th>
                                                <td>{{ $commande->client->name }}</td>
                                                <td>
                                                    @foreach ( $commande->details as $detail )
                                                        -{{ $detail->produit->name }} <br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ( $commande->details as $detail )
                                                        {{ $detail->quantity }} <br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $commande->total }} Ar</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ( $commandes as $commande)
                                            <tr>
                                                <th scope="row">{{ $commande->lieu_livraison }}</th>
                                                <td>{{ $commande->client->name }}</td>
                                                <td>
                                                    @foreach ( $commande->details as $detail )
                                                        -{{ $detail->produit->name }} <br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ( $commande->details as $detail )
                                                        {{ $detail->quantity }} <br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $commande->total }} Ar</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('scripts-bottom')
        <script src="{{asset('app-assets/js/scripts/pages/app-livrer.js')}}"></script>
    @endpush
</x-app-layout>

