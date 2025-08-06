<!DOCTYPE html>
<html data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajer Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        .main-content {
            flex-grow: 1;
            padding: 20px;
            transition: margin-left 0.3s ease;
            margin-top: var(--header-height);
        }
        body.sidebar-closed {
            padding-left: 0;
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
        .card {
            margin-bottom: 1.5rem;
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            background-color: var(--bs-card-bg);
            color: var(--primary-text-color);
        }
        .card.bg-primary, .card.bg-info, .card.bg-success {
            color: var(--card-text-color-primary) !important;
        }
        .card.bg-warning {
            color: var(--card-text-color-warning) !important;
        }

        .card-body h6 {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }
        .card-body h3 {
            font-size: 2rem;
            font-weight: 700;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }
        #stokPieChart {
            max-width: 100%;
            max-height: 350px;
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
        .footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--bs-border-color);
            color: var(--secondary-text-color);
            margin-top: auto;
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

        .badge {
            padding: 0.5em 0.8em;
            border-radius: 0.375rem;
            font-weight: 500;
        }
        .chartjs-render-monitor {
            color: var(--primary-text-color) !important;
        }
    </style>
</head>
<body class="bg-body-tertiary">

<div class="header-bar d-flex justify-content-between align-items-center">
    <div>
        <button class="toggle-sidebar" id="toggleSidebarBtn" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <span class="h4 mb-0 d-none d-md-inline-block" id="currentSectionTitle">Dashboard Manajer Gudang</span>
    </div>
    <button class="btn btn-outline-secondary" id="toggleModeBtn" aria-label="Toggle Light/Dark Mode">🌙</button>
</div>

<div class="sidebar" id="sidebar">
    <div class="profile-section">
        <?php
            $profilePicUrl = base_url('img/profiles/kebun.png');
            $userName = 'Manajer Gudang';
            $userEmail = 'warehouse.manager@example.com';
        ?>
        <img src="<?= $profilePicUrl ?>" alt="Profile Picture" class="rounded-circle mb-2" width="80" height="80">
        <h5><?= $userName ?></h5>
        <p class="text-muted"><?= $userEmail ?></p>
    </div>
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a href="#" class="nav-link active" data-section="dashboardSection">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="laporanBarangSection">
                <i class="fas fa-box-open"></i> Laporan Barang
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-section="approval">
                <i class="fas fa-clipboard-list"></i> Daftar Pengajuan Pembelian
            </a>
        </li>
        <li class="nav-item mt-auto py-3"> <a href="<?= base_url('/login/logout') ?>" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div class="main-content" id="mainContent">
    <div class="container-fluid">
        <div id="dashboardSection" class="content-section">
            <h1 class="mb-4">Dashboard Overview</h1>

            <div class="row g-4 dashboard-grid">
                <div class="col">
                    <div class="card shadow-sm bg-primary text-white">
                        <div class="card-body">
                            <h6 class="mb-0">Total Barang</h6>
                            <h3><?= count($barang) ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <?php $menipis = array_filter($barang, fn($b) => $b['stok'] < $b['minimum_stok']); ?>
                    <div class="card shadow-sm bg-warning text-dark">
                        <div class="card-body">
                            <h6 class="mb-0">Barang Menipis</h6>
                            <h3><?= count($menipis) ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm bg-info text-white">
                        <div class="card-body">
                            <h6 class="mb-0">Total Pengajuan</h6>
                            <h3><?= count($pengajuan) ?></h3>
                        </div>
                    </div>
                </div>
                </div>

            <?php if (count($barang) > 0): ?>
            <div class="card mt-5 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Distribusi Stok Barang</h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="stokPieChart"></canvas>
                </div>
            </div>
            <?php endif; ?>

            <div class="row g-4 mt-4">
                <div class="col-lg-6">
                    <?php if (count($pengajuan) > 0): ?>
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Pengajuan Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($pengajuan, 0, 5) as $p): ?>
                                        <tr>
                                            <td><?= esc($p['nama_barang']) ?></td>
                                            <td><?= esc($p['jumlah']) ?></td>
                                            <td><?= esc($p['created_at']) ?></td>
                                            <td><span class="badge bg-secondary"><?= esc($p['status']) ?></span></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-6">
                    <?php if (count($menipis) > 0): ?>
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Barang di Bawah Minimum</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($menipis as $b): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= esc($b['nama_barang']) ?>
                                    <span class="badge bg-danger">Stok: <?= esc($b['stok']) ?> / Min: <?= esc($b['minimum_stok']) ?></span>
                                </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-5 text-center">
                <a href="#" data-section="laporanBarangSection" class="btn btn-primary btn-lg mx-2">
                    <i class="fas fa-boxes me-2"></i> Laporan Barang
                </a>
                <a href="#" data-section="approval" class="btn btn-info btn-lg mx-2 text-white">
                    <i class="fas fa-file-invoice me-2"></i> Pengajuan
                </a>
            </div>
        </div>

        <div id="approval" class="content-section" style="display:none;">
            </div>

        <div id="laporanBarangSection" class="content-section" style="display: none;">
            <h2 class="mb-4">Laporan Jumlah Barang</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="tabelLaporan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($barang)) : $no = 1; ?>
                                    <?php foreach ($barang as $item) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($item['nama_barang']) ?></td>
                                            <td><?= esc($item['stok']) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr><td colspan="3" class="text-center">Data barang kosong.</td></tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print me-2"></i> Cetak</button>
                        <button onclick="exportToExcel()" class="btn btn-success"><i class="fas fa-file-excel me-2"></i> Export Excel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Monitoring Barang. All rights reserved.
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const allNavLinks = document.querySelectorAll('.sidebar .nav-link');
    const currentSectionTitle = document.getElementById('currentSectionTitle');

    function showSection(id) {
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.display = 'none';
        });
        const sectionToShow = document.getElementById(id);
        if (sectionToShow) {
            sectionToShow.style.display = 'block';
            const activeLink = document.querySelector(`.nav-link[data-section="${id}"]`);
            allNavLinks.forEach(link => link.classList.remove('active'));
            if (activeLink) {
                activeLink.classList.add('active');
                currentSectionTitle.textContent = activeLink.textContent.trim();
            } else {
                currentSectionTitle.textContent = 'Dashboard Manajer Gudang'; // Default title if no link matches
            }
        }
        if (id === 'approval') {
            loadPengajuan();
        }
    }

    allNavLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = e.currentTarget.dataset.section;
            showSection(sectionId);
        });
    });

    // Event listeners for shortcut buttons
    document.querySelectorAll('.btn[data-section]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = e.currentTarget.dataset.section;
            showSection(sectionId);
        });
    });

    function loadPengajuan() {
        const approvalSection = document.getElementById('approval');
        approvalSection.innerHTML = '<div class="alert alert-info text-center"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data pengajuan...</div>';
        fetch('<?= base_url('kepalagudang/getPengajuan') ?>')
            .then(res => res.json())
            .then(data => {
                approvalSection.innerHTML = '<h3 class="mb-3">Daftar Pengajuan Pembelian</h3>';
                if (data.length === 0) {
                    approvalSection.innerHTML += '<div class="alert alert-warning text-center">Tidak ada pengajuan saat ini.</div>';
                    return;
                }
                const table = document.createElement('table');
                table.className = 'table table-bordered table-hover table-striped';
                table.innerHTML = `
                    <thead>
                        <tr>
                            <th>Nama Barang atau Bahan</th>
                            <th>Jumlah</th>
                            <th>Tanggal dan Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `;
                const tbody = table.querySelector('tbody');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    let badgeClass = 'bg-secondary';
                    switch(item.status.toLowerCase()) {
                        case 'diajukan': badgeClass = 'bg-secondary'; break;
                        case 'diproses': badgeClass = 'bg-warning text-dark'; break;
                        case 'dibeli': badgeClass = 'bg-primary'; break;
                        case 'telah sampai': badgeClass = 'bg-success'; break;
                        case 'ditolak': badgeClass = 'bg-danger'; break;
                    }
                    row.innerHTML = `
                        <td>${escapeHTML(item.nama_barang)}</td>
                        <td>${escapeHTML(item.jumlah)}</td>
                        <td>${escapeHTML(item.created_at)}</td>
                        <td><span class="badge ${badgeClass}">${escapeHTML(item.status)}</span></td>
                        <td>
                            ${item.status.toLowerCase() === 'diajukan' ? `
                            <button class="btn btn-success btn-sm me-1" onclick="updatePengajuanStatus(${item.id}, 'setujui')">Setujui</button>
                            <button class="btn btn-danger btn-sm" onclick="updatePengajuanStatus(${item.id}, 'tolak')">Tolak</button>`
                            : `<span class="text-muted">Sudah diproses</span>`}
                        </td>
                    `;
                    tbody.appendChild(row);
                });
                approvalSection.appendChild(table);
            })
            .catch(error => {
                approvalSection.innerHTML = '<div class="alert alert-danger text-center">Gagal memuat pengajuan. Silakan coba lagi.</div>';
                console.error(error);
            });
    }

    function updatePengajuanStatus(id, action) {
        if (!confirm(`Apakah Anda yakin ingin ${action === 'setujui' ? 'menyetujui' : 'menolak'} pengajuan ini?`)) {
            return;
        }
        const url = `<?= base_url('kepalagudang/') ?>${action}/${id}`;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(response => {
            alert(response.message);
            if (response.success) loadPengajuan();
        })
        .catch(error => {
            alert('Terjadi kesalahan saat memperbarui status. Silakan cek konsol untuk detail.');
            console.error(error);
        });
    }

    function escapeHTML(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    function exportToExcel() {
        let table = document.getElementById("tabelLaporan");
        let wb = XLSX.utils.table_to_book(table, {sheet: "Laporan Barang"});
        XLSX.writeFile(wb, "laporan_barang.xlsx");
    }

    document.getElementById('toggleModeBtn').addEventListener('click', () => {
        const htmlRoot = document.getElementById('htmlRoot');
        const newTheme = htmlRoot.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        htmlRoot.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        document.getElementById('toggleModeBtn').innerHTML = newTheme === 'dark' ? '☀️' : '🌙';
        updateChartColors(newTheme); // Panggil fungsi untuk update warna chart
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem('theme') === 'dark') {
            document.getElementById('htmlRoot').setAttribute('data-bs-theme', 'dark');
            document.getElementById('toggleModeBtn').innerHTML = '☀️';
        }
        showSection('dashboardSection');
        initializeChart();
    });

    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebar = document.getElementById('sidebar');
    const body = document.body;

    toggleSidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        body.classList.toggle('sidebar-closed');
        const headerBar = document.querySelector('.header-bar');
        if (sidebar.classList.contains('closed')) {
            headerBar.style.left = '0';
        } else {
            headerBar.style.left = 'var(--sidebar-width)';
        }
    });

    let stokPieChartInstance = null;

    function initializeChart() {
        const barang = <?= json_encode($barang) ?>;
        if (barang.length > 0) {
            const ctx = document.getElementById('stokPieChart').getContext('2d');
            if (stokPieChartInstance) {
                stokPieChartInstance.destroy();
            }

            const currentTheme = document.getElementById('htmlRoot').getAttribute('data-bs-theme');
            const textColor = currentTheme === 'dark' ? '#f8f9fa' : '#212529';

            stokPieChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: barang.map(b => b.nama_barang),
                    datasets: [{
                        data: barang.map(b => b.stok),
                        backgroundColor: [
                            '#0d6efd', '#dc3545', '#ffc107', '#198754',
                            '#20c997', '#6610f2', '#fd7e14', '#6c757d',
                            '#0dcaf0', '#e83e8c', '#6f42c1', '#28a745'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                color: textColor
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' unit';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    function updateChartColors(theme) {
        if (stokPieChartInstance) {
            const textColor = theme === 'dark' ? '#f8f9fa' : '#212529';
            stokPieChartInstance.options.plugins.legend.labels.color = textColor;
            stokPieChartInstance.update();
        }
    }
</script>

</body>
</html>