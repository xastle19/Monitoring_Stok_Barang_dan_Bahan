<?php

namespace App\Controllers;

use App\Models\PengajuanPembelianModel;
use App\Models\BarangModel;

class KepalaGudang extends BaseController
{
    protected $pengajuanModel;
    protected $barangModel;
    protected $session;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanPembelianModel();
        $this->barangModel = new BarangModel();
        $this->session = session();
    }

    public function dashboard()
    {
        $user = $this->session->get('user');

        if (empty($user) || !isset($user['id'])) {
            return redirect()->to('/login')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $data = [
            'user' => $user,
            'barang' => $this->barangModel->findAll(),
            'pengajuan' => $this->pengajuanModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('dashboard_manager', $data);
    }

    public function getPengajuan()
    {
        $pengajuan = $this->pengajuanModel->orderBy('created_at', 'DESC')->findAll();

        foreach ($pengajuan as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', strtotime($item['created_at']));
        }

        return $this->response->setJSON($pengajuan);
    }

    public function setujui($id)
    {
        $pengajuan = $this->pengajuanModel->find($id);
        if (!$pengajuan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }

        $this->pengajuanModel->update($id, ['status' => 'disetujui']);

        return $this->response->setJSON(['success' => true, 'message' => 'Pengajuan disetujui.']);
    }

    public function tolak($id)
    {
        $pengajuan = $this->pengajuanModel->find($id);
        if (!$pengajuan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }

        $this->pengajuanModel->update($id, ['status' => 'ditolak']);

        return $this->response->setJSON(['success' => true, 'message' => 'Pengajuan ditolak.']);
    }
}
