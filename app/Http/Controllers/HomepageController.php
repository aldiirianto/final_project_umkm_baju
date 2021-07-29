<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Alert;

class HomepageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $barangs = Barang::paginate(20); //membatasi jumlah barang yang akan ditampilkan
        return view('homepage.index', compact('barangs')); //menampilkan barang ke halaman home
    }

}
