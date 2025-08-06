<!DOCTYPE html>
<html data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staf Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-text-color: var(--bs-body-color);
            --secondary-text-color: var(--bs-secondary-color);
            --card-text-color-primary: #fff;
            --card-text-color-warning: #212529;
            --table-header-color-light: var(--bs-heading-color);
            --table-header-bg-dark: #343a40;
            --table-header-color-dark: #f8f9fa;
        }

        body {
            margin: 0;
            padding-left: var(--sidebar-width);
            transition: padding-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--primary-text-color);
        }


        [data-bs-theme="dark"] {
            --primary-text-color: var(--bs-body-color);
            --secondary-text-color: var(--bs-secondary-color);
            --card-text-color-primary: #fff;
            --card-text-color-warning: #212529;
            --bs-body-bg: #212529;
            --bs-body-color: #f8f9fa;
            --bs-secondary-bg: #343a40;
            --bs-border-color: #495057;
            --bs-link-color: #8ab4f8;
            --bs-link-hover-color: #aecbfa;
            --bs-light-rgb: 52,58,64;
            --table-header-bg-light: #495057;
            --table-header-color-light: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--bs-body-bg);
            border-right: 1px solid var(--bs-border-color);
            transition: transform 0.3s ease;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            padding-top: var(--header-height);
            overflow-y: auto;
        }
        .sidebar.closed {
            transform: translateX(-100%);
        }

        .header-bar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background-color: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
            z-index: 1020;
            display: flex;
            align-items: center;
            padding: 0 20px;
            transition: left 0.3s ease;
        }
        body.sidebar-closed .header-bar {
            left: 0;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            transition: padding-left 0.3s ease;
            margin-top: var(--header-height);
        }
        body.sidebar-closed {
            padding-left: 0;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--primary-text-color);
            margin-right: 15px;
        }
        .toggle-sidebar:hover {
            color: var(--bs-primary);
        }

        .sidebar .profile-section {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid var(--bs-border-color);
            margin-bottom: 20px;
        }
        .sidebar .profile-section h5 {
            margin-top: 10px;
            margin-bottom: 5px;
            color: var(--bs-primary);
        }
        .sidebar .profile-section p {
            font-size: 0.9rem;
            color: var(--secondary-text-color);
        }
        .nav-link {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            color: var(--primary-text-color);
            display: flex;
            align-items: center;
        }
        .nav-link.active, .nav-link:hover {
            background-color: var(--bs-primary-bg-subtle);
            color: var(--bs-primary) !important;
        }
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .card {
            margin-bottom: 1.5rem;
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            background-color: var(--bs-card-bg);
            color: var(--primary-text-color);
        }
        .card.border-primary, .card.border-success, .card.border-danger, .card.border-info, .card.border-warning {
            color: var(--primary-text-color);
        }
        .card-body h5 {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }
        .card-body h2 {
            font-size: 2.2rem;
            font-weight: 700;
        }
        [data-bs-theme="dark"] .card.border-warning {
             color: var(--card-text-color-warning);
        }
        .table {
            color: var(--primary-text-color);
        }
        .table thead th {
            background-color: var(--table-header-bg-light);
            color: var(--table-header-color-light);
            border-bottom: 2px solid var(--bs-primary);
            font-weight: 500;
        }
        [data-bs-theme="dark"] .table thead th {
            background-color: var(--table-header-bg-dark);
            color: var(--table-header-color-dark);
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: var(--bs-table-striped-bg);
        }
        .table-hover tbody tr:hover {
            background-color: var(--bs-table-hover-bg);
        }
        .badge {
            padding: 0.5em 0.8em;
            border-radius: 0.375rem;
            font-weight: 500;
        }

        /* Form Controls */
        .form-control, .form-select, .input-group-text {
            background-color: var(--bs-form-control-bg);
            color: var(--bs-form-control-color);
            border-color: var(--bs-border-color);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Chart Containers */
        .chart-container {
            position: relative;
            height: 100%;
            min-height: 200px;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--bs-border-color);
            color: var(--secondary-text-color);
            margin-top: auto;
        }
        @media (max-width: 768px) {
            body {
                padding-left: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                padding-top: 0;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .header-bar {
                left: 0;
                width: 100%;
                justify-content: flex-start;
            }

            .toggle-sidebar {
                position: static;
                margin-left: 0;
            }
            body.sidebar-open .main-content::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1020;
            }
        }
    </style>
</head>
<body class="bg-body-tertiary">

<div class="header-bar d-flex align-items-center">
    <button class="toggle-sidebar" id="toggleSidebarBtn" aria-label="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <span class="h4 mb-0 d-none d-md-inline-block" id="currentSectionTitle">Dashboard Staf Gudang</span>
    <button class="btn btn-outline-secondary ms-auto" id="toggleModeBtn" aria-label="Toggle Light/Dark Mode">🌙</button>
</div>

<div class="sidebar" id="sidebar">
    <div class="profile-section">
        <?php

            $profilePicUrl = base_url('img/profiles/Kebun.png');
            $userName = 'Staf Gudang';
            $userEmail = 'pt.ctmukut@gmail.com';

            if (session('user')) {
                if (!empty(session('user')['profile_picture'])) {
                    $profilePicUrl = base_url('uploads/profile_pics/' . session('user')['profile_picture']);
                }
                if (!empty(session('user')['username'])) {
                    $userName = esc(session('user')['username']);
                }
                if (!empty(session('user')['email'])) {
                    $userEmail = esc(session('user')['email']);
                }
            }
        ?>
        <img src="<?= $profilePicUrl ?>" alt="Profile Picture" class="rounded-circle mb-2" width="80" height="80">
        <h5><?= $userName ?></h5>
        <p class="text-muted"><?= $userEmail ?></p>
    </div>
    <ul class="nav flex-column px-3 flex-grow-1">
        <li class="nav-item">
            <a href="#" class="nav-link active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="surat">
                <i class="fas fa-envelope-open-text"></i> Daftar Permintaan Barang dan Bahan
            </a>
        </li>
            <li class="nav-item">
            <a href="#" class="nav-link" data-section="status-surat">
                <i class="fas fa-clipboard-list"></i> Status Permintaan Barang dan Bahan
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="stok">
                <i class="fas fa-boxes"></i> Ringkasan Stok
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="grafik">
                <i class="fas fa-chart-bar"></i> Grafik Stok
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="informasi">
                <i class="fas fa-file-invoice"></i> Pengajuan Pembelian
            </a>
        </li>
        <li class="nav-item mt-auto py-3"> <a href="<?= base_url('/login/logout') ?>" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div class="main-content" id="mainContent">
    <div class="container-fluid"> <div id="section-dashboard" class="content-section">
            <h1 class="mb-4">Dashboard Staf Gudang</h1>
            <p class="mb-4">Selamat datang, <strong><?= esc(session('user')['username'] ?? 'User') ?></strong></p>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-primary border-4 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title">Permintaan Barang dan Bahan</h5>
                            <h2 class="display-4"><?= esc($totalSuratMasuk ?? 0) ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-success border-4 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title">Total Stok Gudang</h5>
                            <h2 class="display-4"><?= esc($totalStokGudang ?? 0) ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-warning border-4 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title">Grafik Stok Barang</h5>
                            <div class="chart-container" style="height: 150px;">
                                <canvas id="dashboardStokChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-start border-info border-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Grafik Barang Masuk vs Keluar</h5>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="dashboardMasukKeluarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div id="section-surat" class="content-section" style="display: none;">
    <h1 class="mb-4">Daftar Permintaan Barang dan Bahan</h1>
    
    <?php if (session()->getFlashdata('success') && !session()->getFlashdata('success_info')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Dikirim Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($suratMasuk)): ?>
                        <?php foreach ($suratMasuk as $surat): ?>
                            <tr>
                                <td><?= esc($surat['nama']) ?></td>
                                <td><?= esc($surat['divisi']) ?></td>
                                <td><?= esc($surat['barang']) ?></td>
                                <td><?= esc($surat['jumlah']) ?></td>
                                <td><span class="badge bg-secondary">Menunggu</span></td>
                                <td><?= date('d-m-Y H:i', strtotime($surat['created_at'])) ?></td>
                                <td>
                                    <form action="<?= base_url('stafgudang/updateStatus/' . $surat['id']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <select name="status" class="form-select" required>
                                                <option value="diterima">Setujui</option>
                                                <option value="ditolak">Tolak</option>
                                            </select>
                                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan (opsional)">
                                            <button type="submit" class="btn btn-primary">Proses</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Tidak ada surat masuk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


 <div id="section-status-surat" class="content-section" style="display: none;">
    <h1 class="mb-4">Status Permintaan Barang dan Bahan</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Upload Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($statusSurat)): ?>
                        <?php foreach ($statusSurat as $s): ?>
                            <tr>
                                <td><?= esc($s['nama']) ?></td>
                                <td><?= esc($s['divisi']) ?></td>
                                <td><?= esc($s['barang']) ?></td>
                                <td><?= esc($s['jumlah']) ?></td>
                                <td>
                                    <span class="badge bg-<?=
                                        $s['status'] === 'diterima' ? 'success' : (
                                        $s['status'] === 'ditolak' ? 'danger' : (
                                        $s['status'] === 'diambil' ? 'primary' : 'secondary')) ?>">
                                        <?= ucfirst($s['status']) ?>
                                    </span>
                                </td>
                                <td><?= esc($s['keterangan'] ?? '-') ?></td>
                                <td>
                                    <?php if (!empty($s['bukti_foto'])): ?>
                                        <a href="<?= base_url('uploads/bukti_pengambilan/' . $s['bukti_foto']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?= base_url('stafgudang/updateStatus/' . $s['id']) ?>" method="post" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <select name="status" class="form-select" required>
                                                <option value="diterima" <?= $s['status'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                                                <option value="ditolak" <?= $s['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                                <option value="diambil" <?= $s['status'] == 'diambil' ? 'selected' : '' ?>>Diambil</option>
                                            </select>
                                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan (opsional)" value="<?= esc($s['keterangan']) ?>">
                                            <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">Belum ada surat yang diproses.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



        <div id="section-stok" class="content-section" style="display: none;">
            <h1 class="mb-4">Ringkasan Stok Barang</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Minimum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($stokBarang)): ?>
                                    <?php foreach ($stokBarang as $b): ?>
                                        <tr class="<?= ($b['stok'] < ($b['minimum_stok'] ?? 0)) ? 'table-danger' : '' ?>">
                                            <td><?= esc($b['nama_barang']) ?></td>
                                            <td><?= esc($b['stok']) ?></td>
                                            <td><?= esc($b['minimum_stok'] ?? 'N/A') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center">Data stok barang kosong.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($stokMinimum)): ?>
                        <div class="alert alert-warning mt-3">
                            ⚠ Beberapa barang memiliki stok di bawah minimum!
                        </div>
                    <?php endif; ?>
                    <div class="mt-4 d-flex gap-3">
                        <a href="<?= base_url('/stafgudang/laporanStok') ?>" class="btn btn-primary"><i class="fas fa-file-pdf me-2"></i>Laporan Stok</a>
                        <button id="btnShowGrafik" class="btn btn-success"><i class="fas fa-chart-pie me-2"></i>Tampilkan Grafik Stok</button>
                    </div>
                    <div class="mt-4">
                        <canvas id="stokChart" style="max-width: 700px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-grafik" class="content-section" style="display: none;">
            <h1 class="mb-4">Grafik Stok Barang</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="chart-container" style="height: 400px;">
                        <canvas id="grafikStokChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-informasi" class="content-section" style="display: none;">
            <h1 class="mb-4">Pengajuan Pembelian Stok</h1>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5>Form Pengajuan Pembelian Stok</h5>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('stafgudang/ajukanpembelian') ?>" method="post" class="row g-3">
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <label for="nama_barang_pengajuan" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang_pengajuan" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="jumlah_pengajuan" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah_pengajuan" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="catatan_pengajuan" class="form-label">Catatan (opsional)</label>
                            <textarea name="catatan" id="catatan_pengajuan" class="form-control"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan</button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <h5>Riwayat Pengajuan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($pengajuan_terakhir)): ?>
                                <?php foreach ($pengajuan_terakhir as $item): ?>
                                    <tr>
                                        <td><?= esc($item['nama_barang']) ?></td>
                                        <td><?= esc($item['jumlah']) ?></td>
                                        <td><?= esc($item['tanggal']) ?></td>
                                        <td>
                                            <?php if ($item['status'] == 'diajukan') : ?>
                                                <span class="badge bg-warning text-dark">Diajukan</span>
                                            <?php elseif ($item['status'] == 'diproses') : ?>
                                                <span class="badge bg-info text-dark">Diproses</span>
                                            <?php elseif ($item['status'] == 'dibeli') : ?>
                                                <span class="badge bg-success">Dibeli</span>
                                            <?php elseif ($item['status'] == 'telah sampai') : ?>
                                                <span class="badge bg-primary">Telah Sampai</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center">Tidak ada riwayat pengajuan.</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <div class="footer">
        &copy; <?= date('Y') ?> Monitoring Barang dan Bahan.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleModeBtn = document.getElementById('toggleModeBtn');
    const htmlRoot = document.getElementById('htmlRoot');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const allNavLinks = document.querySelectorAll('.sidebar .nav-link');
    const currentSectionTitle = document.getElementById('currentSectionTitle');

    // Theme Toggle Logic
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        htmlRoot.setAttribute('data-bs-theme', 'dark');
        toggleModeBtn.innerHTML = '☀️';
    }

    toggleModeBtn.addEventListener('click', () => {
        const theme = htmlRoot.getAttribute('data-bs-theme');
        const newTheme = theme === 'light' ? 'dark' : 'light';
        htmlRoot.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        toggleModeBtn.innerHTML = newTheme === 'dark' ? '☀️' : '🌙';
        renderAllCharts();
    });

    function openSidebar() {
        sidebar.classList.remove('closed');
        document.body.classList.remove('sidebar-closed');
        document.body.classList.remove('sidebar-open-mobile');
        localStorage.setItem('sidebarState', 'opened');
        toggleSidebarBtn.innerHTML = '<i class="fas fa-bars"></i>';
        if (window.innerWidth <= 768) {
            document.body.classList.add('sidebar-open-mobile');
        }
    }

    function closeSidebar() {
        sidebar.classList.add('closed');
        document.body.classList.add('sidebar-closed');
        document.body.classList.remove('sidebar-open-mobile');
        localStorage.setItem('sidebarState', 'closed');
        toggleSidebarBtn.innerHTML = '<i class="fas fa-bars"></i>';
    }

    toggleSidebarBtn.addEventListener('click', () => {
        if (sidebar.classList.contains('closed')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    });

    function handleMobileView() {
        if (window.innerWidth <= 768) {
            closeSidebar();
            mainContent.addEventListener('click', closeSidebarOnClickOutside);
        } else {
            if (localStorage.getItem('sidebarState') === 'closed') {
                closeSidebar();
            } else {
                openSidebar();
            }
            mainContent.removeEventListener('click', closeSidebarOnClickOutside);
        }
    }

    function closeSidebarOnClickOutside(event) {
        if (!sidebar.contains(event.target) && !toggleSidebarBtn.contains(event.target) && window.innerWidth <= 768) {
            closeSidebar();
        }
    }

    handleMobileView();
    window.addEventListener('resize', handleMobileView);

    function showSection(id) {
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.display = 'none';
        });
        const sectionToShow = document.getElementById('section-' + id);
        if (sectionToShow) {
            sectionToShow.style.display = 'block';

            allNavLinks.forEach(link => link.classList.remove('active'));
            const activeLink = document.querySelector(`.nav-link[data-section="${id}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
                currentSectionTitle.textContent = activeLink.textContent.trim();
            }
            renderAllCharts(id);
        }

        if (window.innerWidth <= 768) {
            closeSidebar();
        }
    }

    allNavLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = e.currentTarget.dataset.section;
            showSection(sectionId);
        });
    });

    function renderDashboardStokChart() {
        const dashboardStokChartCtx = document.getElementById('dashboardStokChart');
        if (!dashboardStokChartCtx) return;

        const existingChart = Chart.getChart('dashboardStokChart');
        if (existingChart) {
            existingChart.destroy();
        }

        new Chart(dashboardStokChartCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($stokBarang ?? [], 'nama_barang')) ?>,
                datasets: [{
                    label: 'Stok Barang',
                    data: <?= json_encode(array_column($stokBarang ?? [], 'stok')) ?>,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function renderDashboardMasukKeluarChart() {
        const dashboardMasukKeluarChartCtx = document.getElementById('dashboardMasukKeluarChart');
        if (!dashboardMasukKeluarChartCtx) return;

        const existingChart = Chart.getChart('dashboardMasukKeluarChart');
        if (existingChart) {
            existingChart.destroy();
        }

        new Chart(dashboardMasukKeluarChartCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labelsMasukKeluar ?? []) ?>,
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: <?= json_encode($dataBarangMasuk ?? []) ?>,
                        borderColor: 'rgba(0, 123, 255, 0.8)',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(0, 123, 255, 1)'
                    },
                    {
                        label: 'Barang Keluar',
                        data: <?= json_encode($dataBarangKeluar ?? []) ?>,
                        borderColor: 'rgba(220, 53, 69, 0.8)',
                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(220, 53, 69, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(220, 53, 69, 1)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            }
        });
    }

    // Grafik Stok Barang di Halaman Grafik Stok (Section 'grafik')
    function renderGrafikStokChart() {
        const grafikStokCtx = document.getElementById('grafikStokChart');
        if (!grafikStokCtx) return;

        const existingChart = Chart.getChart('grafikStokChart');
        if (existingChart) {
            existingChart.destroy();
        }

        new Chart(grafikStokCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($stokBarang ?? [], 'nama_barang')) ?>,
                datasets: [{
                    label: 'Stok Barang',
                    data: <?= json_encode(array_column($stokBarang ?? [], 'stok')) ?>,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    }

    let stokChartInstance = null;

    document.getElementById('btnShowGrafik').addEventListener('click', () => {
        fetch('<?= base_url('/stafgudang/grafikStok') ?>')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const ctx = document.getElementById('stokChart');
            if (!ctx) return;

            if (stokChartInstance) {
                stokChartInstance.destroy();
            }

            stokChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.namaBarang,
                    datasets: [{
                        label: 'Stok Barang',
                        data: data.stokBarang,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })
        .catch(err => {
            alert('Gagal memuat data grafik stok.');
            console.error(err);
        });
    });

    function renderAllCharts(activeSectionId) {
        if (activeSectionId === 'dashboard') {
            renderDashboardStokChart();
            renderDashboardMasukKeluarChart();
        } else if (activeSectionId === 'grafik') {
            renderGrafikStokChart();
        }

    }

    document.addEventListener('DOMContentLoaded', () => {
        showSection('dashboard');
        renderAllCharts('dashboard');
    });
</script>
<!-- Script Toggle Input Foto -->
<script>
    function toggleFotoInput(selectElem, id) {
        const fotoInput = document.getElementById('fotoInput' + id);
        if (selectElem.value === 'diambil') {
            fotoInput.style.display = 'block';
        } else {
            fotoInput.style.display = 'none';
        }
    }
</script>
</body>
</html>