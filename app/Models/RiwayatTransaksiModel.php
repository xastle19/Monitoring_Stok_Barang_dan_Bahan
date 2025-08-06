<?php
namespace App\Models;

use CodeIgniter\Model;

class RiwayatTransaksiModel extends Model
{
    protected $table = 'riwayat_transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['surat_id', 'aksi', 'keterangan', 'tanggal'];
    protected $useTimestamps = false;
}
