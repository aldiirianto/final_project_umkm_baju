<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang; //berelasi dengan database barang
use App\Models\Pesanan;  //berelasi dengan database pesanan
use App\Models\PesananDetail; //berelasi dengan database pesanan detail
use Auth;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=', 0)->get();

        return view('history.index', compact('pesanans'));
    }

    public function detail($id)
    {
         $pesanans = Pesanan::where('id', $id)->first();

        $pesanan_details = null;
        if($pesanans !== null){
             $pesanan_details = PesananDetail::where('pesanan_id', $pesanans->id)->get();
        }

        return view('history.detail', compact('pesanans', 'pesanan_details'));
    }

}
