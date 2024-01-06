<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MagasinerControlleur extends Controller
{
    public function index()
    {
        return view('magasinier.index');
    }
    public function detail($id)
    {
        return view('magasinier.detail');
    }
}
