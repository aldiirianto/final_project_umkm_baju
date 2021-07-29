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
                    <li class="breadcrumb-item active" aria-current="page">Check Out</li>
                </ol>
            </nav>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3><i class="fa fa-shopping-cart"></i> Check Out</h3>
                    @if($pesanans !== null)
                    <p align="right"><strong>Tanggal Pesan : {{ $pesanans->tanggal }} </strong></p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach($pesanan_details as $pesanan_detail)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <img src="{{ url('uploads') }}/{{ $pesanan_detail->barang->gambar}}" width="150" alt="">
                                    </td>
                                    <td>{{ $pesanan_detail->barang->nama_barang }}</td>
                                    <td>{{ $pesanan_detail->jumlah }} kain</td>
                                    <td align="left">Rp. {{number_format($pesanan_detail->barang->harga) }}</td>
                                    <td align="left">Rp. {{number_format($pesanan_detail->jumlah_harga) }}</td>
                                    <td>
                                        <form action="{{ url('check_out') }}/{{ $pesanan_detail->id }}" method="post">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm ('Anda yakin akan menghapus data ini?');"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" align="right"><strong>Total Harga : </strong></td>
                                
                                <td align="left"><strong>Rp. {{ number_format($pesanans->jumlah_harga) }}</strong></td>
                               
                                <td> 
                                    <a href=" {{ url ('konfirmasi_check_out') }}" class="btn btn-success" onclick="return confirm ('Anda yakin akan check out?');">
                                        <i class="fa fa-shopping-cart"></i> Check Out
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @endif
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
