<?php
namespace App\Controllers;

use App\Models\SuratModel;

class Surat extends BaseController
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
        $user = $this->session->get('user');
        $keyword = $this->request->getGet('keyword');
        $builder = $this->suratModel->where('id_user', $user['id']);
        
        if ($keyword) {
            $builder = $builder->groupStart()
                ->like('barang', $keyword)
                ->orLike('divisi', $keyword)
                ->orLike('status', $keyword)
                ->groupEnd();
        }
        
        $data['surats'] = $builder->orderBy('created_at', 'DESC')->findAll();
        $data['keyword'] = $keyword;
        $data['user'] = $user;

        return view('surat/index', $data);
    }

    // Simpan surat baru
    public function save()
    {
        if (!$this->validate([
            'nama' => 'required',
            'divisi' => 'required',
            'barang' => 'required',
            'jumlah' => 'required|integer|greater_than[0]',
        ])) {
            return redirect()->to('/surat')->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->session->get('user');

        $this->suratModel->save([
            'id_user' => $user['id'],
            'nama' => $this->request->getPost('nama'),
            'divisi' => $this->request->getPost('divisi'),
            'barang' => $this->request->getPost('barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            'status' => 'menunggu',
            'keterangan' => $this->request->getPost('keterangan') ?? null,
        ]);

        return redirect()->to('/surat')->with('success', 'Surat permintaan berhasil dikirim.');
    }
}
