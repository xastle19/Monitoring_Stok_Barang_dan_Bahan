<?php

namespace App\Controllers;

use App\Models\PengajuanPembelianModel;

class Keuangan extends BaseController
{
    protected $pengajuanModel;
    protected $session;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanPembelianModel();
        $this->session = session();
    }
public function index()
{
    $user = $this->session->get('user');
    if (empty($user) || !isset($user['id'])) {
        return redirect()->to('/login')->with('error', 'Sesi tidak valid. Silakan login kembali.');
    }

    $data['pengajuan'] = $this->pengajuanModel
        ->where('status !=', 'ditolak')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    // Hitung jumlah status
    $data['jumlah_diproses'] = $this->pengajuanModel->where('status', 'diproses')->countAllResults();
    $data['jumlah_dibeli'] = $this->pengajuanModel->where('status', 'dibeli')->countAllResults();
    $data['jumlah_sampai'] = $this->pengajuanModel->where('status', 'telah sampai')->countAllResults();

    $data['user'] = $user;

    return view('dashboard_keuangan', $data);
}

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        if (in_array($status, ['diproses', 'dibeli', 'telah sampai'])) {
            $this->pengajuanModel->update($id, ['status' => $status]);
            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Status tidak valid.');
    }
}