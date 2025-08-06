<?php

namespace App\Controllers;

use App\Models\SuratModel;
use App\Models\BarangModel;
use App\Models\RiwayatTransaksiModel;
use App\Models\InformasiStokModel;
use App\Models\PengajuanPembelianModel;


class StafGudang extends BaseController
{
    protected $suratModel;
    protected $barangModel;
    protected $riwayatModel;
    protected $informasiStokModel;
    protected $pengajuanPembelianModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->suratModel = new SuratModel();
        $this->barangModel = new BarangModel();
        $this->riwayatModel = new RiwayatTransaksiModel();
        $this->informasiStokModel = new InformasiStokModel();
        $this->pengajuanPembelianModel = new PengajuanPembelianModel();
        $this->session = session();
    }

 public function index()
{
    $pengajuanTerakhir = $this->pengajuanPembelianModel->orderBy('created_at', 'DESC')->findAll();

    $totalSuratMasuk = $this->suratModel->where('status', 'menunggu')->countAllResults();

    $stokBarang = $this->barangModel->findAll();

    $totalStokGudang = 0;
    foreach ($stokBarang as $b) {
        $totalStokGudang += (int)$b['stok'];
    }

    $suratMasuk = $this->suratModel->where('status', 'menunggu')->orderBy('id', 'DESC')->findAll();
    $statusSurat = $this->suratModel->where('status !=', 'menunggu')->orderBy('id', 'DESC')->findAll();

    $stokMinimum = $this->barangModel->where('stok < minimum_stok')->findAll();

    $db = \Config\Database::connect();

    $bulanSurat = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS bulan FROM surat GROUP BY bulan ORDER BY bulan ASC")->getResultArray();
    $bulanKeluar = $db->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan FROM riwayat_transaksi WHERE aksi = 'disetujui' GROUP BY bulan ORDER BY bulan ASC")->getResultArray();

    $allBulan = array_unique(array_merge(
        array_column($bulanSurat, 'bulan'),
        array_column($bulanKeluar, 'bulan')
    ));
    sort($allBulan);

    $suratPerBulanRaw = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS bulan, COUNT(*) AS jumlah FROM surat GROUP BY bulan")->getResultArray();
    $suratPerBulan = [];
    foreach ($suratPerBulanRaw as $row) {
        $suratPerBulan[$row['bulan']] = (int)$row['jumlah'];
    }

    $keluarPerBulanRaw = $db->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, COUNT(*) AS jumlah FROM riwayat_transaksi WHERE aksi = 'disetujui' GROUP BY bulan")->getResultArray();
    $keluarPerBulan = [];
    foreach ($keluarPerBulanRaw as $row) {
        $keluarPerBulan[$row['bulan']] = (int)$row['jumlah'];
    }

    $dataBarangMasuk = [];
    $dataBarangKeluar = [];
    foreach ($allBulan as $bulan) {
        $dataBarangMasuk[] = $suratPerBulan[$bulan] ?? 0;
        $dataBarangKeluar[] = $keluarPerBulan[$bulan] ?? 0;
    }

    $data = [
        'title' => 'Dashboard Staf Gudang',
        'user' => $this->session->get('user'),
        'pengajuan_terakhir' => $pengajuanTerakhir,
        'suratMasuk' => $suratMasuk,
        'statusSurat' => $statusSurat,
        'stokBarang' => $stokBarang,
        'stokMinimum' => $stokMinimum,
        'totalSuratMasuk' => $totalSuratMasuk,
        'totalStokGudang' => $totalStokGudang,
        'labelsMasukKeluar' => $allBulan,
        'dataBarangMasuk' => $dataBarangMasuk,
        'dataBarangKeluar' => $dataBarangKeluar,
    ];

    return view('dashboard_staf', $data);
}


    public function laporanStok()
    {
        $data = [
            'stokBarang' => $this->barangModel->findAll(),
            'user' => $this->session->get('user'),
        ];

        return view('laporan_stok', $data);
    }

    public function tambahBarang()
    {
        $validation = \Config\Services::validation();

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'stok' => $this->request->getPost('stok'),
            'minimum_stok' => $this->request->getPost('minimum_stok'),
        ];

        $rules = [
            'nama_barang' => 'required|min_length[3]|max_length[255]',
            'stok' => 'required|integer|greater_than_equal_to[0]',
            'minimum_stok' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (!$validation->setRules($rules)->run($data)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->barangModel->insert($data);

        return redirect()->to('/stafgudang/laporanStok')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function tambahBarangKeluar()
    {
        $validation = \Config\Services::validation();

        $data = [
            'barang_id' => $this->request->getPost('barang_id'),
            'jumlah_keluar' => $this->request->getPost('jumlah_keluar'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $rules = [
            'barang_id' => 'required|integer|is_not_unique[barang.id]',
            'jumlah_keluar' => 'required|integer|greater_than[0]',
        ];

        if (!$validation->setRules($rules)->run($data)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $barang = $this->barangModel->find($data['barang_id']);
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        if ($barang['stok'] < $data['jumlah_keluar']) {
            return redirect()->back()->with('error', 'Stok barang tidak cukup.');
        }

        $this->barangModel->update($data['barang_id'], [
            'stok' => $barang['stok'] - $data['jumlah_keluar']
        ]);

        $this->riwayatModel->insert([
            'surat_id' => null,
            'aksi' => 'barang_keluar',
            'keterangan' => $data['keterangan'] ?? '',
            'tanggal' => date('Y-m-d H:i:s'),
            'barang_id' => $data['barang_id'],
            'jumlah' => $data['jumlah_keluar'],
        ]);

        return redirect()->to('/stafgudang/laporanStok')->with('success', 'Barang keluar berhasil dicatat dan stok diperbarui.');
    }

    public function editBarang()
    {
        $validation = \Config\Services::validation();
        $id = $this->request->getPost('id');

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'stok' => $this->request->getPost('stok'),
            'minimum_stok' => $this->request->getPost('minimum_stok'),
        ];

        $rules = [
            'nama_barang' => 'required|min_length[3]|max_length[255]',
            'stok' => 'required|integer|greater_than_equal_to[0]',
            'minimum_stok' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (!$validation->setRules($rules)->run($data)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->barangModel->update($id, $data);

        return redirect()->to('/stafgudang/laporanStok')->with('success', 'Barang berhasil diperbarui.');
    }

    public function hapusBarang($id)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/stafgudang/laporanStok')->with('success', 'Barang berhasil dihapus.');
    }

public function updateStatus($id)
{
    $status = $this->request->getPost('status');
    $keterangan = $this->request->getPost('keterangan') ?? '';
    $validation = \Config\Services::validation();

    $rules = [
        'status' => 'required|in_list[diterima,ditolak,diambil]',
    ];

    if (!$validation->setRules($rules)->run(['status' => $status])) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    $surat = $this->suratModel->find($id);
    if (!$surat) {
        return redirect()->back()->with('error', 'Surat tidak ditemukan.');
    }

    $updateData = [
        'status' => $status,
        'keterangan' => $keterangan,
    ];

    if ($status === 'diambil' && $this->request->getFile('bukti_foto')->isValid()) {
        $file = $this->request->getFile('bukti_foto');
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/bukti_pengambilan/', $newName);
        $updateData['bukti_foto'] = $newName;
    }

    $this->suratModel->update($id, $updateData);

    if ($status === 'diterima' || $status === 'diambil') {
        $barang_nama = $surat['barang'];
        $jumlah_diminta = (int)$surat['jumlah'];
        $barang_detail = $this->barangModel->where('nama_barang', $barang_nama)->first();

        if ($barang_detail) {
            if ($barang_detail['stok'] >= $jumlah_diminta) {
                $new_stok = $barang_detail['stok'] - $jumlah_diminta;
                $this->barangModel->update($barang_detail['id'], ['stok' => $new_stok]);

                $this->riwayatModel->insert([
                    'surat_id' => $id,
                    'aksi' => 'barang_keluar',
                    'keterangan' => 'Permintaan ' . $status . ': ' . $keterangan,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'barang_id' => $barang_detail['id'],
                    'jumlah' => $jumlah_diminta,
                ]);
            } else {
                return redirect()->back()->with('error', 'Stok tidak cukup.');
            }
        }
    }

    if ($status === 'ditolak') {
        $this->riwayatModel->insert([
            'surat_id' => $id,
            'aksi' => 'ditolak',
            'keterangan' => $keterangan,
            'tanggal' => date('Y-m-d H:i:s'),
            'barang_id' => null,
            'jumlah' => 0,
        ]);
    }

    return redirect()->to('/stafgudang')->with('success', 'Status surat berhasil diperbarui.');
}


public function statusSurat()
{
    $suratDiproses = $this->suratModel
        ->whereIn('status', ['diterima', 'ditolak', 'diambil'])
        ->orderBy('id', 'DESC')
        ->findAll();

    return view('status_surat', [
        'user' => $this->session->get('user'),
        'suratDiproses' => $suratDiproses
    ]);
}

public function updateStatusSurat($id)
{
    $status = $this->request->getPost('status');
    $keterangan = $this->request->getPost('keterangan') ?? '';
    $validation = \Config\Services::validation();

    $rules = ['status' => 'required|in_list[diterima,ditolak,diambil]'];

    if (!$validation->setRules($rules)->run(['status' => $status])) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    $updateData = [
        'status' => $status,
        'keterangan' => $keterangan
    ];

    if ($status === 'diambil' && $this->request->getFile('bukti_foto')->isValid()) {
        $file = $this->request->getFile('bukti_foto');
        $newName = $file->getRandomName();
        $file->move('public/uploads/bukti_pengambilan/', $newName);
        $updateData['bukti_foto'] = $newName;
    }

    $this->suratModel->update($id, $updateData);

    return redirect()->to('/stafgudang')->with('success', 'Status surat berhasil diperbarui.');
}



    public function kirimInformasi()
    {
        $model = $this->informasiStokModel;

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah_stok' => $this->request->getPost('jumlah_stok'),
            'rekomendasi_pembelian' => $this->request->getPost('rekomendasi_pembelian'),
            'tanggal' => date('Y-m-d'),
            'status' => 'terkirim',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        return redirect()->to('/stafgudang')->with('success_info', 'Informasi berhasil dikirim.');
    }

    public function grafikStok()
    {
        $barang = $this->barangModel->findAll();

        $namaBarang = [];
        $stokBarang = [];

        foreach ($barang as $b) {
            $namaBarang[] = $b['nama_barang'];
            $stokBarang[] = (int) $b['stok'];
        }

        return $this->response->setJSON([
            'namaBarang' => $namaBarang,
            'stokBarang' => $stokBarang,
        ]);
    }

    public function ajukanPembelian()
    {
        $validation = \Config\Services::validation();
        $model = $this->pengajuanPembelianModel;

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tanggal' => date('Y-m-d'),
            'status' => 'diajukan',
            'catatan' => $this->request->getPost('catatan'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $rules = [
            'nama_barang' => 'required|min_length[2]',
            'jumlah' => 'required|integer|greater_than[0]'
        ];

        if (!$validation->setRules($rules)->run($data)) {
            return redirect()->to('/stafgudang')->withInput()->with('errors', $validation->getErrors());
        }

        $model->insert($data);
        return redirect()->to('/stafgudang')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function grafikStokView()
    {
        return view('grafik_stok', ['user' => $this->session->get('user')]);
    }
}
