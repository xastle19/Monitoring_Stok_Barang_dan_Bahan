<!DOCTYPE html>
<html data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-text-color: #333;
            --secondary-text-color: #6c757d;
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
        <span class="h4 mb-0 d-none d-md-inline-block" id="currentSectionTitle">Dashboard Keuangan</span>
    </div>
    <button class="btn btn-outline-secondary" id="toggleModeBtn" aria-label="Toggle Light/Dark Mode">🌙</button>
</div>

<div class="sidebar" id="sidebar">
    <div class="profile-section">
        <?php
            $profilePicUrl = base_url('img/profiles/Kebun.png');
            $userName = 'User Keuangan';
            $userEmail = 'keuangan@example.com';

            // Sesuaikan ini dengan struktur sesi Anda yang sebenarnya
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
        <h5>Halo, Keuangan</h5>
        <p class="text-muted"><?= $userEmail ?></p>
    </div>
    <ul class="nav flex-column px-3 flex-grow-1">
        <li class="nav-item">
            <a href="#" class="nav-link active" data-section="dashboardSection">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="pembelianSection">
                <i class="fas fa-box"></i> Pembelian Stok
            </a>
        </li>
        <li class="nav-item mt-auto py-3">
            <a href="<?= base_url('/login/logout') ?>" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div class="main-content" id="mainContent">
    <div class="container-fluid">
        <div id="dashboardSection" class="content-section">
            <h1 class="mb-4">Dashboard Keuangan</h1>
            <div class="row mb-4 g-4">
                <div class="col-md-4">
                    <div class="card border-warning shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning"><i class="fas fa-hourglass-half me-2"></i>Diproses</h5>
                            <h2><?= $jumlah_diproses ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-info"><i class="fas fa-shopping-cart me-2"></i>Dibeli</h5>
                            <h2><?= $jumlah_dibeli ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success"><i class="fas fa-check-circle me-2"></i>Telah Sampai</h5>
                            <h2><?= $jumlah_sampai ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="pembelianSection" class="content-section" style="display:none;">
            <h1 class="mb-4">Daftar Pengajuan Pembelian Barang</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Pengajuan Pembelian Barang</h5>
                </div>
                <div class="card-body table-responsive">
                    <?php if (!empty($pengajuan)) : ?>
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Ubah Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengajuan as $i => $p) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($p['nama_barang']) ?></td>
                                        <td><?= esc($p['jumlah']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $p['status'] == 'diproses' ? 'warning' : ($p['status'] == 'dibeli' ? 'info' : 'success') ?>">
                                                <?= esc(ucwords($p['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form action="<?= base_url('keuangan/updateStatus/' . $p['id']) ?>" method="post" class="d-flex gap-2">
                                                <select name="status" class="form-select form-select-sm" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="diproses" <?= $p['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="dibeli" <?= $p['status'] == 'dibeli' ? 'selected' : '' ?>>Dibeli</option>
                                                    <option value="telah sampai" <?= $p['status'] == 'telah sampai' ? 'selected' : '' ?>>Telah Sampai</option>
                                                </select>
                                                <button type="submit" class="btn btn-success btn-sm">✔</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="alert alert-warning">Belum ada pengajuan pembelian.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <div class="footer">
        &copy; <?= date('Y') ?> Monitoring Barang. All rights reserved.
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
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
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
        const sectionToShow = document.getElementById(id);
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
        showSection('dashboardSection');
    });
</script>

</body>
</html>