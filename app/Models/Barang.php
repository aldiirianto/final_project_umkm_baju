<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public function pesanan_detail()
    {
      return $this->hasMany('App\PesananDetail','barang_id', 'id'); //class barang hasMany (dapat memiliki banyak pesanan detail
    }
}
