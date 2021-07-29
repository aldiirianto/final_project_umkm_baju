@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('/')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali </a>
        </div>
        <div class="co-md-12 mt-2">
             <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $barangs->nama_barang }}</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                       <div class="row">
                            <div class="col-md-6">
                                <img src="{{ url('uploads') }}/{{ $barangs-> gambar}}" class="rounded mx-auto d-block"
                                 width="100%" alt="">
                            </div>
                            <div class="col-md-6">
                                <h2>{{ $barangs->nama_barang }}</h2>
                                     <table class="table">
                                        <tbody>
                                              <tr>
                                                <td>Harga</td>
                                                <td>:</td>
                                                <td>Rp. {{number_format($barangs->harga)}} </td>
                                              </tr>
                                              <tr>
                                                <td>Stok</td>
                                                <td>:</td>
                                                <td>{{number_format($barangs->stok)}} </td>
                                              </tr>
                                              <tr>
                                                <td>Keterangan</td>
                                                <td>:</td>
                                                <td>{{ $barangs->keterangan }} </td>
                                              </tr>
                                              
                                              <tr>
                                                <td>Jumlah Pesan</td>
                                                <td>:</td>
                                                <td>
                                                    <form action="{{ url('pesan') }}/{{ $barangs->id }}" method="post">
                                                    @csrf
                                                         <input type="text" name="jumlah_pesan" class="form-control"
                                                         required="">
                                                        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-shopping-cart"></i> Masukkan Keranjang </button>
                                                    </form>
                                                </td>
                                              </tr>
                                         </tbody>
                                     </table>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</div>
@endsection
