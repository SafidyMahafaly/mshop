<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
@php
    $customStyles = file_get_contents(public_path('app-assets/css/stylePDF.css'));
@endphp
<style>
    {{ $customStyles }}
    .colonne-2{
        margin-left:390px;
        margin-top : -400px;
        width: 800px;
        border-right: none !important;
    }
    .col-6{
        width: 360px !important;
    }

</style>
{{--  --}}
<?php
  $imagePath = public_path('app-assets/images/logo_MG.jpg');

// Vérifier si le fichier existe
    if (file_exists($imagePath)) {
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageBase64 = 'data:image/jpg;base64,' . $imageData;
    } else {
        // Gérer le cas où le fichier n'existe pas
        $imageBase64 = ''; // ou une autre valeur par défaut
    }

?>
<body style=" margin-top: -2.6rem; margin-left: -2.5rem; margin-right: -2rem">
    @foreach ($commandes  as $index => $commande)
        @if($index > 0 && $index % 10 == 0)
            <!-- Ajouter une nouvelle page après chaque groupe de 8 éléments -->
            <div style="page-break-before: always;"></div>
        @endif

        <div class="col-6 @if($index % 2 == 1) colonne-2 @endif" style="border: 1px dashed  rgb(224, 147, 230);border-top:none;border-left:none;om: 10px;width:800px">
            <div class="row">
                {{-- <div class="col-5" style=""> --}}
                    <h6 class="mt-4" style="margin-left:20px;text-transform: uppercase;font-size:17px"><b><span style="margin-left: 25px">Merci pour</span> <br> votre commande</b></h6>
                {{-- </div> --}}
                {{-- <span>test</span> --}}
                <div class="col-4" style="margin-left: 220px;margin-top:-3rem">
                    <img src="{{ $imageBase64 }}" style="width: 100px;" alt="" srcset="">
                </div>
            </div>
            <div class="row" style="padding: 10px; margin-top: -4rem;font-size:15px">
                <i><u>Nom</u> : </i> {{ $commande->commande->client->name }} <br>
                <i><u>Contact</u> : </i>{{ $commande->commande->client->phone }}<br>
                <i><u>Lieux</u> : </i>{{ $commande->commande->lieu_livraison }}<br>
                <i><u>Produit</u> : </i>
                @php
                    $produits = '';
                @endphp
                @foreach ($commande->commande->details as $index => $detail)
                    @php
                        $produits .= $detail->produit->name . '(' . $detail->quantity . ')';
                        if ($index < count($commande->commande->details) - 1) {
                            $produits .= ', ';
                        }
                    @endphp
                @endforeach
                {{ $produits }}
                <br>
                <i><u>Prix avec livraison</u> : </i>{{ $commande->commande->total }} Ar<br>
                {{-- <i><u>Remarque  </u> : {{$commande->commande->remarque}}</i><br> --}}
                <i><u>Livreur</u> : </i>{{ $livreur->name }}<br>
                {{-- <i><u>Remarque</u> : </i>{{ $commande->commande->remarque }} <br> --}}

            </div>
        </div>
    @endforeach
</body>
</html>
