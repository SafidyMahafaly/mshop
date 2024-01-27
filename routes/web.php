<?php

use App\Models\Fournisseur;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControlleur;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LivreurController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardControlleur;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MagasinerControlleur;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardControlleur::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //route utilisateur
    Route::get('/utilisateur',[UserControlleur::class,'index'])->name('utilisateur.index');
    Route::get('/getUtilisateur',[UserControlleur::class,'getUtilisateur']);
    Route::post('/save_user',[UserControlleur::class,'store'])->name('utilisateur.store');
    //fin utilisateur


    //route produit
    Route::get('/produit',[ProduitController::class,'index'])->name('produit.index');
    Route::post('/produitSave',[ProduitController::class,'store'])->name('produit.store');
    Route::post('/produitUpdate/{id}',[ProduitController::class,'update'])->name('produit.editP');
    Route::get('/getProduit',[ProduitController::class,'getProduit']);
    Route::get('/deleteP/{id}',[ProduitController::class,'destroy']);
    Route::get('/editP/{id}',[ProduitController::class,'edit']);
    //fin produit


    //route  profil
    Route::get('/profile/{id?}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //fin profil

    //route categories
    Route::get('/categorie',[CategorieController::class,'index'])->name('categorie.index');
    Route::get('/getCategorie',[CategorieController::class,'getCategorie']);
    Route::post('/categorieSave/{id}',[CategorieController::class,'update'])->name('produit.editC');
    Route::post('/cateforieSave',[CategorieController::class,'store'])->name('categorie.store');
    Route::get('/editCategorie/{id}',[CategorieController::class,'edit']);
    Route::get('/deleteC/{id}',[CategorieController::class,'destroy']);
    //fin categorie

    //route fournisseur
    Route::get('/fournisseur',[FournisseurController::class,'index'])->name('fournisseur.index');
    Route::get('/getFournisseur',[FournisseurController::class,'getFournisseur'],'getFournisseur');
    Route::post('/fournisseurSave',[FournisseurController::class,'store'])->name('fournisseur.store');
    Route::post('/fournisseurUpdate/{id}',[FournisseurController::class,'update'])->name('fournisseur.editF');
    Route::get('/editFournisseur/{id}',[FournisseurController::class,'edit']);
    Route::get('/deleteF/{id}',[FournisseurController::class,'destroy']);
    //fin fournisseur


    //route commande
    Route::get('/commande/{date?}',[CommandeController::class,'index'])->name('commande.index');
    Route::get('/addCommande',[CommandeController::class,'create']);
    Route::get('/getClient',[CommandeController::class,'getClient']);
    Route::get('/getCommandeClient',[CommandeController::class,'getCommCliend']);
    Route::get('/getProduitCom',[CommandeController::class,'getProduitCom']);
    Route::post('/commandeSave',[CommandeController::class,'store'])->name('commande.store');
    Route::get('/getCommandes',[CommandeController::class,'getCommande']);
    Route::get('/livreur_commande',[CommandeController::class,'lireurCommande']);
    Route::get('/editCommande/{id}',[CommandeController::class,'edit']);
    Route::post('/updateCommande/{id}',[CommandeController::class,'update'])->name('commande.update');
    Route::get('/deleteCommande/{id}',[CommandeController::class,'destroy']);
    Route::get('/commande/facturation/{id}',[CommandeController::class,'facturation']);
    Route::get('/liste-commande-livre-agent',[CommandeController::class,'commandeDejaLivre'])->name('commande.deja_livre');
    Route::post('/get-commande-livre-agent',[CommandeController::class,'getCommandeDejaLivre'])->name('commande.get_cmd_livre');
    //fin commande


    //route livreur
    Route::get('/livreur',[LivreurController::class,'index'])->name('livreur.index');
    Route::get('/getLivreur',[LivreurController::class,'getLivreur']);
    Route::post('/livreurSave',[LivreurController::class,'store'])->name('livreur.store');
    Route::get('/voirCommande/{id}/{date?}',[LivreurController::class,'voir_commande']);
    Route::get('/genererPDF/{id}/{date}',[LivreurController::class,'genererPDF']);
    Route::get('/changeStatusLivre',[LivreurController::class,'changeStatus']);
    Route::get('/changeStatusLivreur',[LivreurController::class,'changeStatusLivreur']);
    Route::get('/changeStatusAnnuler',[LivreurController::class,'changeStatusAnnuler']);
    Route::get('/changeStatusReporter',[LivreurController::class,'changeStatusReporter']);
    Route::get('/editLivreur/{id}', [LivreurController::class,'edit'])->name('livreur.edit');
    Route::post('/updateLivreur/{id}', [LivreurController::class,'update'])->name('livreur.update');
    Route::get('/deleteLivreur/{id}', [LivreurController::class,'destroy'])->name('livreur.destroy');
    //fin livreur

    /*** route client */
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::post('/saveclient',[ ClientController::class, 'store'])->name('client.store');
    Route::post('/updateclient/{id}',[ ClientController::class, 'update'])->name('client.update');
    Route::get('/getAllClient', [ClientController::class, 'getAllClient']);
    Route::get('/client/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::get('/destroyClient/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
    /*** fin route client */


    //Route magasinier
    Route::get('/magasinier',[MagasinerControlleur::class,'index'])->name('magasinier.index');
    Route::get('/detail_produit/{id}',[MagasinerControlleur::class,'detail']);
    Route::post('/magasinier_entre/{id}',[MagasinerControlleur::class,'entre'])->name('magasinier.entre');
    Route::post('/magasinier_sortie/{id}',[MagasinerControlleur::class,'sortie'])->name('magasinier.sortie');
    //fin route magasinier

});

require __DIR__.'/auth.php';
