<?php

namespace App\Models;

use CodeIgniter\Model;

class InformasiStokModel extends Model
{
    protected $table = 'informasi_stok';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_barang',
        'jumlah_stok',
        'rekomendasi_pembelian',
        'tanggal',
        'status',
        'created_at',
        'jenis_pemberitahuan',
        'tanggal_tiba_estimasi'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
}

