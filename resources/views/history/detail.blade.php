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
                    <li class="breadcrumb-item"><a href="{{url('history') }}">Riwayat Pemesanan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pemesanan</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3>Sukses Check Out</h3>
                    <h5>Pesanan anda sudah sukses di check out selanjutnya untuk pembayaran silahkan transfer <br> di rekening
                    <strong>Bank BRI Nomer Rekening : 3122-391201-123</strong>
                    dengan nominal : <strong>Rp. {{ number_format($pesanans->kode+$pesanans->jumlah_harga) }}</strong></h5>
                </div>
            </div>
        </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fa fa-shopping-cart"></i> Detail Pemesanan</h3>
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
                                        <td align="right">Rp. {{number_format($pesanan_detail->jumlah_harga) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" align="right"><strong>Total Harga : </strong></td>
                                
                                    <td align="right"><strong>Rp. {{ number_format($pesanans->jumlah_harga) }}</strong></td>
                                </tr>
                                 <tr>
                                    <td colspan="5" align="right"><strong>Kode Unik : </strong></td>
                                
                                    <td align="right"><strong>Rp. {{ number_format($pesanans->kode) }}</strong></td>
                                </tr>
                                 <tr>
                                    <td colspan="5" align="right"><strong>Total yang harus di transfer : </strong></td>
                                
                                    <td align="right"><strong>Rp. {{ number_format($pesanans->kode+$pesanans->jumlah_harga) }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                            <h3><a href="" class="btn btn-success mt-2" onclick="javascript:window.print()">
                                    <i class="fa fa-print"></i>
                                    Print Invoice
                                     </a></h3>
                            @endif
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
@endsection
