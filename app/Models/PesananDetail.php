<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    public function barang()
    {
      return $this->belongsTo('App\Models\Barang','barang_id', 'id'); //class pesanandetail belongsto"dapat terhubung dengan" barang
    }

    public function pesanan()
    {
      return $this->belongsTo('App\Models\Pesanan','pesanan_id', 'id'); //class pesanan belongsto"dapat terhubung dengan" user
    }
}
