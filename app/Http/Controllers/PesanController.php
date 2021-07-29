<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang; //berelasi dengan database barang
use App\Models\Pesanan;  //berelasi dengan database pesanan
use App\Models\PesananDetail; //berelasi dengan database pesanan detail
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id) 
    {
        $barangs = Barang::where('id',$id)->first(); //cuman nampilin satu barang
        return view('pesan.index', compact('barangs')); //menampilkan barang ke halaman home
    }

    public function pesan(Request $request, $id) //berfungsi untuk mengoper data yang sudah diinput untuk kemudian diolah
    {
        $barangs = Barang::where('id', $id)->first();
        $tanggal = Carbon::now(); //fasilitas yang disediakan oleh laravel

        //validasi apakah melebihi stok
        if($request->jumlah_pesan > $barangs->stok)
        {
            return redirect ('pesan/'.$id);
        }

        //cek validasi
        $cek_pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

        //simpan ke database pesanan
        if(empty($cek_pesanans))
        {
            $pesanans = new Pesanan;
            $pesanans->user_id = Auth::user()->id; //mengambil id user yang sedang login
            $pesanans->tanggal = $tanggal; //mengambil tanggal saat user itu pesan
            $pesanans->status = 0; //masuk keranjang 0, setelah masuk keranjang checkout baru 1t
            $pesanans->kode = mt_rand(100,999);
            $pesanans->jumlah_harga = 0; 
            $pesanans->save();
        }

        //simpan ke database pesanan detail
        $pesanan_barus = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first(); //mengambil id pesanan yang sudah tersimpan oleh user 
       
        //cek pesanan detail
        $cek_pesanan_details = PesananDetail::where('barang_id', $barangs->id)->where('pesanan_id', $pesanan_barus->id)->first();
        if(empty($cek_pesanan_details))
        {
            $pesanan_details = new PesananDetail;
            $pesanan_details->barang_id = $barangs->id; //mengambil id barang yang dipesan
            $pesanan_details->pesanan_id = $pesanan_barus->id; //mengambil id pesanan yang sudah tersimpan
            $pesanan_details->jumlah = $request->jumlah_pesan;
            $pesanan_details->jumlah_harga = $barangs->harga*$request->jumlah_pesan; // harga barangnya x qty
            $pesanan_details->save();

        }else
            {
                $pesanan_details = PesananDetail::where('barang_id', $barangs->id)->where('pesanan_id', $pesanan_barus->id)->first();
                $pesanan_details->jumlah = $pesanan_details->jumlah+$request->jumlah_pesan; //jumlah qty barang yang dipesan kedua kali

                //harga sekarang
                $harga_pesanan_details_baru = $barangs->harga*$request->jumlah_pesan; // harga barangnya x qty
                $pesanan_details->jumlah_harga = $pesanan_details->jumlah_harga+$harga_pesanan_details_baru; //jumlah harga barang yang dipesan kedua kali
                $pesanan_details->update();

            }

            //jumlah total
            $pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
            $pesanans->jumlah_harga = $pesanans->jumlah_harga+$barangs->harga*$request->jumlah_pesan; // jumlah harga pesanan pertama + jumlah harga pesanan kedua
            $pesanans->update();

            
        Alert::success('Pesanan Sukses Masuk Keranjang', 'Success');
        return redirect('/');
    }

    public function check_out()
    {

        $pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

        $pesanan_details = null;
        if($pesanans !== null){
             $pesanan_details = PesananDetail::where('pesanan_id', $pesanans->id)->get();
        }

        return view('pesan.check_out', compact('pesanans', 'pesanan_details'));
    }

    public function delete($id)
    {
        $pesanan_details = PesananDetail::where('id', $id)->first();

        //menghapus pesanan yang di delete
        //mengurangi total harganya
        $pesanans = Pesanan::where('id', $pesanan_details->pesanan_id)->first();
        $pesanans->jumlah_harga = $pesanans->jumlah_harga-$pesanan_details->jumlah_harga;
        $pesanans->update();

        $pesanan_details->delete();
        
        Alert::error('Pesanan Sukses Dihapus', 'Hapus');
        return redirect('check_out');

    }

    public function konfirmasi()
    {
        //mewajibkan user mengisi identitas
        $user = User::where('id', Auth::user()->id)->first();

        if(empty($user->alamat)){
             Alert::error('Identitas Harap Dilengkapi', 'Eror');
             return redirect('profile');
        }

        if(empty($user->no_hp)){
             Alert::error('Identitas Harap Dilengkapi', 'Eror');
             return redirect('profile');
        }

        //akan mengubah status 0 menjadi 1
        $pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

        if($pesanans !== null){
            $pesanans->id;
            $pesanans->status = 1;
            $pesanans->update();
        }
 
          $pesanan_details = PesananDetail::all()->where('pesanan_id', $pesanans->id);
            foreach($pesanan_details as $pesanan_detail) {
               $barangs = Barang::where('id', $pesanan_detail->barang_id)->first();
                $barangs->stok = $barangs->stok-$pesanan_detail->jumlah;
                $barangs->update();
           }
        Alert::success('Pesanan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
        return redirect('history/'.$pesanans->id);
    }

}
