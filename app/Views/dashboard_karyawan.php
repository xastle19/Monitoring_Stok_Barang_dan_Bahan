<!DOCTYPE html>
<html data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-text-color: #333;
            --secondary-text-color: #6c757d;
            --card-text-color-primary: #fff;
            --card-text-color-warning: #212529;
            --table-header-color-light: #495057;
            --table-header-bg-light: #e9ecef;
            --table-header-bg-dark: #343a40;
            --table-header-color-dark: #f8f9fa;
            --bs-body-bg-light: #f5f5f5;
            --bs-body-color-light: #333;
        }

        body {
            margin: 0;
            padding-left: var(--sidebar-width);
            transition: padding-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }

        [data-bs-theme="light"] {
            --bs-body-bg: var(--bs-body-bg-light);
            --bs-body-color: var(--bs-body-color-light);
            --bs-emphasis-color: #000;
            --bs-secondary-bg: #e9ecef;
            --bs-secondary-color: #6c757d;
            --bs-tertiary-bg: #dee2e6;
            --bs-tertiary-color: #495057;
            --bs-border-color: #adb5bd;
            --bs-link-color: #007bff;
            --bs-link-hover-color: #0056b3;
            --bs-light-rgb: 245,245,245;
            --primary-text-color: var(--bs-body-color-light);
            --secondary-text-color: var(--bs-secondary-color);
            --table-header-color-light: var(--bs-heading-color);
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #212529;
            --bs-body-color: #f8f9fa;
            --bs-emphasis-color: #f8f9fa;
            --bs-secondary-bg: #343a40;
            --bs-secondary-color: #ced4da;
            --bs-border-color: #495057;
            --bs-link-color: #8ab4f8;
            --bs-link-hover-color: #aecbfa;
            --bs-light-rgb: 52,58,64;
            --primary-text-color: var(--bs-body-color);
            --secondary-text-color: var(--bs-secondary-color);
            --table-header-color-light: var(--table-header-color-dark);
            --table-header-bg-light: var(--table-header-bg-dark);
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

        .card.text-bg-primary, .card.text-bg-success, .card.text-bg-danger, .card.text-bg-warning, .card.text-bg-info {
            color: var(--bs-emphasis-color) !important;
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

        .table {
            color: var(--primary-text-color);
        }
        .table thead th {
            background-color: var(--table-header-bg-light);
            color: var(--table-header-color-light);
            border-bottom: 2px solid var(--bs-primary);
            font-weight: 500;
        }
 
        [data-bs-theme="dark"] .table {
            color: var(--bs-body-color);
        }
        [data-bs-theme="dark"] .table thead th {
            background-color: var(--table-header-bg-dark);
            color: var(--table-header-color-dark);
        }
        [data-bs-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }
        [data-bs-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }

        .badge {
            padding: 0.5em 0.8em;
            border-radius: 0.375rem;
            font-weight: 500;
        }

        .footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--bs-border-color);
            color: var(--secondary-text-color);
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-body-tertiary">

<div class="header-bar d-flex justify-content-between align-items-center">
    <div>
        <button class="toggle-sidebar" id="toggleSidebarBtn" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <span class="h4 mb-0 d-none d-md-inline-block" id="currentSectionTitle">Dashboard Karyawan Kebun</span>
    </div>
    <button class="btn btn-outline-secondary" id="toggleModeBtn" aria-label="Toggle Light/Dark Mode">🌙</button>
</div>

<div class="sidebar" id="sidebar">
    <div class="profile-section">
        <?php
            $profilePicUrl = base_url('img/profiles/Kebun.png');
            $userName = 'Karyawan';
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
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a href="#" class="nav-link active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="formulir">
                <i class="fas fa-file-alt"></i> Form Permintaan
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="surat">
                <i class="fas fa-list-alt"></i> Daftar Permintaan
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
            <h1 class="mb-4">Dashboard Karyawan</h1>
            <p>Selamat datang, <strong><?= esc(session('user')['username'] ?? 'User') ?></strong></p>

            <div class="row g-4 mt-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-primary border-4">
                        <div class="card-body">
                            <h5>Total Permintaan Barang dan Bahan</h5>
                            <h2><?= esc($totalSurat ?? 0) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-success border-4">
                        <div class="card-body">
                            <h5>Disetujui</h5>
                            <h2><?= esc($totalDiterima ?? 0) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-danger border-4">
                        <div class="card-body">
                            <h5>Ditolak</h5>
                            <h2><?= esc($totalDitolak ?? 0) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-formulir" class="content-section" style="display: none;">
            <h1 class="mb-4">Form Pengajuan Barang dan Bahan</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= base_url('/karyawan/kirimSurat') ?>" method="post" class="mt-2">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" required value="<?= esc(session('user')['nama'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="divisi" class="form-label">Divisi</label>
                                <input type="text" id="divisi" name="divisi" class="form-control" required value="<?= esc(session('user')['divisi'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="barang" class="form-label">Nama Barang/Bahan</label>
                                <input type="text" id="barang" name="barang" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Surat</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="section-surat" class="content-section" style="display: none;">
            <h1 class="mb-4">Daftar Permintaan Barang dan Bahan</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form class="my-3" method="get">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama barang dan bahan..." value="<?= esc($_GET['search'] ?? '') ?>">
                            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Divisi</th>
                                    <th>Barang/Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
<tbody>
    <?php if (!empty($surat)): ?>
        <?php foreach ($surat as $s): ?>
            <tr>
                <td><?= esc($s['nama']) ?></td>
                <td><?= esc($s['divisi']) ?></td>
                <td><?= esc($s['barang']) ?></td>
                <td><?= esc($s['jumlah']) ?></td>
                <td>
                    <?php if ($s['status'] === 'diterima'): ?>
                        <span class="badge bg-success">Diterima</span>
                    <?php elseif ($s['status'] === 'ditolak'): ?>
                        <span class="badge bg-danger">Ditolak</span>
                    <?php elseif ($s['status'] === 'diambil'): ?>
                        <span class="badge bg-info text-dark">Diambil</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Menunggu</span>
                    <?php endif; ?>
                </td>
                <td><?= esc($s['keterangan'] ?? '-') ?></td>
                <td><?= date('d-m-Y H:i', strtotime($s['created_at'])) ?></td>
                <td>
                    <?php if ($s['status'] === 'diambil' && !empty($s['bukti_foto'])): ?>
                        <a href="<?= base_url('uploads/bukti_pengambilan/' . $s['bukti_foto']) ?>" target="_blank">
                            Lihat Bukti
                        </a>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="8" class="text-center">Belum ada surat.</td></tr>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleModeBtn = document.getElementById('toggleModeBtn');
    const htmlRoot = document.getElementById('htmlRoot');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const allNavLinks = document.querySelectorAll('.sidebar .nav-link');
    const currentSectionTitle = document.getElementById('currentSectionTitle');

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
    });

    toggleSidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        document.body.classList.toggle('sidebar-closed');
        const headerBar = document.querySelector('.header-bar');
        if (sidebar.classList.contains('closed')) {
            headerBar.style.left = '0';
        } else {
            headerBar.style.left = 'var(--sidebar-width)';
        }
    });

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
        }
    }

    allNavLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = e.currentTarget.dataset.section;
            showSection(sectionId);
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        showSection('dashboard');
    });
</script>

</body>
</html>