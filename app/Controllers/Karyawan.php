<?php

namespace App\Controllers;

use App\Models\SuratModel;

class Karyawan extends BaseController
{
    protected $suratModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->suratModel = new SuratModel();
        $this->session = session();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $user = $this->session->get('user');
        $builder = $this->suratModel->where('id_user', $user['id']);

        if ($search) {
            $builder = $builder->groupStart()
                ->like('barang', $search)
                ->orLike('status', $search)
                ->orLike('divisi', $search)
                ->groupEnd();
        }

        $surat = $builder
            ->select('*')
            ->orderBy('id', 'DESC')
            ->findAll();

        $totalSurat = $this->suratModel
            ->where('id_user', $user['id'])
            ->countAllResults();

        $totalDiterima = $this->suratModel
            ->where('id_user', $user['id'])
            ->where('status', 'diterima')
            ->countAllResults();

        $totalDitolak = $this->suratModel
            ->where('id_user', $user['id'])
            ->where('status', 'ditolak')
            ->countAllResults();

        return view('dashboard_karyawan', [
            'surat'         => $surat,
            'totalSurat'    => $totalSurat,
            'totalDiterima' => $totalDiterima,
            'totalDitolak'  => $totalDitolak,
        ]);
    }

    public function kirimSurat()
    {
        if (!$this->validate([
            'nama'   => 'required',
            'divisi' => 'required',
            'barang' => 'required',
            'jumlah' => 'required|integer|greater_than[0]',
        ])) {
            return redirect()->to('/karyawan')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $user = $this->session->get('user');

        $data = [
            'id_user'    => $user['id'] ?? null,
            'nama'       => $this->request->getPost('nama'),
            'divisi'     => $this->request->getPost('divisi'),
            'barang'     => $this->request->getPost('barang'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'status'     => 'menunggu',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->suratModel->insert($data);

        return redirect()->to('/karyawan')->with('success', 'Surat berhasil dikirim.');
    }
}
