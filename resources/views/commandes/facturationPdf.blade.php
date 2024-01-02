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

    body {
        margin-top: -2rem;
        margin-left: -1.5rem;
        margin-right: -2rem;
        font-family: Arial, Helvetica, sans-serif;
        padding: 40px;
    }

    .container {
        width: 100%;
    }

    .flex-container {
        display: flex;
        justify-content: space-between;
    }

    .box-1 {
        display: inline-block;
        width: 65%;
        margin-top: 5%;
        box-sizing: border-box;
        align-items: center;
    }

    .box-2 {
        display: inline-block;
        width: 30%;
        margin-top: 30px;
        box-sizing: border-box;
        padding: 10px;
        position: absolute;
        font-size: 85%;
    }

    .box-img {
        margin-top: -30px;
        display: inline-block;
        width: 20%;
        box-sizing: border-box;
    }

    .box-next-img {
        display: inline-block;
        width: 73%;
        box-sizing: border-box;
        margin-top: 5%;
        font-size: 80%;
    }

    .centered-content {
        text-align: center;
    }

    .font-size-name{
        font-size: 100%;
    }

    .doit{
        display: inline-block;
        width: 70%;
        margin-left: 10%;
        box-sizing: border-box;
        border: 1px solid #1d1c1c;
        border-radius: 2%;
        padding: 10px;
        padding-bottom: 13px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse; /* Pour fusionner les bordures des cellules */
    }

    .custom-table th, .custom-table td {
        padding: 10px;
        text-align: center; /* Aligner le texte au centre pour les colonnes PU et Montant */
        border: 1px solid #1d1c1c;
    }

    .custom-table th:nth-child(2),
    .custom-table td:nth-child(2) {
        text-align: center; /* Aligner à gauche pour la colonne Désignation */
        width: 50%;
    }

    .custom-table th:nth-child(3),
    .custom-table td:nth-child(3) {
        text-align: center; /* Aligner à gauche pour la colonne Désignation */
        width: 20%;
    }
    .custom-table td{
        /* border-bottom: white 1px solid; */
    }
    .custom-table tr {
        border-bottom: 1px solid #1d1c1c; /* Ajouter une bordure en bas de chaque ligne */
    }

    
</style>

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
    $now = date('d-m-Y')
    ?>
    <body>
        <div class="flex-container">
            <div class="box-1">
                <div class="flex-container">
                    <div>
                        <h6>VENTES DIVERS ET ACCESSOIRES QUOTIDIENS</h6>
                    </div>
                    <div class="box-img">
                        <img src="{{ $imageBase64 }}" style="width: 100px;" alt="" srcset="">
                    </div>
                    <div class="box-next-img">
                        NIF: 7018078831 <br>
                        STAT : 47521 11 2023 0 05044 <br>
                        Tél : 034 64 467 54 - 034 64 467 55 <br>
                        mshopgadget00@gmail.com <br>
                        Adresse : II H 34 Bis L Ankadindramamy Ankerana <br>
                        ANTANANARIVO
                    </div>
                </div>
            </div>
            <div class="box-2 centered-content">
                <!-- Contenu de la deuxième boîte -->
                Antananarivo, le {{ $now }} <br><br>
                <span class="font-size-name">FACTURE N° ..........</span> 
            </div>
            <div class="doit">
                <span style="font-size: 14px;"><i><u>Doit</u>:</i></span> <span class="font-size-name"> {{ $commande->client->name }}</span>
            </div>
            <div style="margin-top: 3%">
                <table class="custom-table" style="border-bottom: none;font-size: 13px;">
                    <thead>
                        <tr >
                            <th>Qté</th>
                            <th>Désignation</th>
                            <th>PU (Ar)</th>
                            <th>Montant (Ar)</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($commande->details as $detail)
                            <tr>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->produit->name }}</td>
                                <td>{{ $detail->prix }}</td>
                                <td>{{ $detail->quantity * $detail->prix }}</td>
                            </tr>
                        @endforeach
                        @if ($commande->lieu_livraison)
                            <tr>
                                <td>01</td>
                                <td>Livraison</td>
                                <td>{{ $commande->frais_livraison }}</td>
                                <td>{{ $commande->frais_livraison }}</td>
                            </tr>
                        @endif
                        <tr> 
                            <td colspan="3"  style="border-top: #1d1c1c solid 1px">TOTAL</td>
                            <td style="border: 1px solid #1d1c1c">{{ $commande->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 3%">
                <span style="font-size: 14px;"><i>Arrêter la présente facture à la somme de:</i></span> {{ $commande->numberToWords }} Ariary
            </div>
            <div style="width: 200px;margin-top:60px">
               <span><u>Le client</u></span>
            </div>
            <div style="margin-left:500px;margin-top:-23px">
                <span><u>Le Fournisseur</u></span>
            </div>
        </div>
    </body>
</html>
