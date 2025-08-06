<!DOCTYPE html>
<html data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8" />
    <title>Laporan Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .mode-toggle {
            position: fixed;
            top: 10px;
            right: 120px;
            z-index: 1050;
        }
        .back-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1050;
        }
        .copyright {
            font-size: 0.9rem;
            color: #999;
            text-align: center;
            margin-top: 50px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        #searchInput {
            max-width: 300px;
        }
    </style>
</head>
<body class="p-4 bg-body-tertiary">

    <button class="btn btn-outline-secondary mode-toggle" id="toggleModeBtn">🌙</button>
    <a href="<?= base_url('/stafgudang') ?>" class="btn btn-primary back-btn">Kembali</a>

    <div class="container">
        <h1 class="mb-4">Laporan Stok Barang</h1>

        <!-- Tambah fitur search dan tombol tambah di satu baris -->
        <div class="action-buttons">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama barang..." />

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTambahBarangKeluar">
                Tambah Barang Keluar
            </button>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah Barang
            </button>
        </div>

        <table class="table table-striped table-bordered align-middle" id="stokTable">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Minimum Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stokBarang as $barang): ?>
                <tr>
                    <td><?= esc($barang['nama_barang']) ?></td>
                    <td><?= esc($barang['stok']) ?></td>
                    <td><?= esc($barang['minimum_stok']) ?></td>
                    <td>
                        <button 
                            class="btn btn-sm btn-warning edit-btn" 
                            data-id="<?= $barang['id'] ?>"
                            data-nama="<?= esc($barang['nama_barang'], 'attr') ?>"
                            data-stok="<?= $barang['stok'] ?>"
                            data-minimum="<?= $barang['minimum_stok'] ?>"
                        >
                            Edit
                        </button>
                        <form action="<?= base_url('/stafgudang/hapusBarang/' . $barang['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="copyright mt-5">
            &copy; <?= date('Y') ?> Monitoring Barang. All rights reserved.
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= base_url('/stafgudang/tambahBarang') ?>" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required min="0" />
                    </div>
                    <div class="mb-3">
                        <label for="minimum_stok" class="form-label">Minimum Stok</label>
                        <input type="number" name="minimum_stok" id="minimum_stok" class="form-control" required min="0" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalTambahBarangKeluar" tabindex="-1" aria-labelledby="modalTambahBarangKeluarLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="<?= base_url('stafgudang/tambahBarangKeluar') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTambahBarangKeluarLabel">Tambah Barang Keluar</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="barang_id" class="form-label">Pilih Barang</label>
                <select class="form-select" id="barang_id" name="barang_id" required>
                  <option value="" selected disabled>Pilih barang</option>
                  <?php foreach($stokBarang as $barang): ?>
                    <option value="<?= $barang['id'] ?>"><?= esc($barang['nama_barang']) ?> (Stok: <?= $barang['stok'] ?>)</option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                <input type="number" min="1" class="form-control" id="jumlah_keluar" name="jumlah_keluar" required>
              </div>
              <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Simpan Barang Keluar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= base_url('/stafgudang/editBarang') ?>" method="post" class="modal-content">
                <input type="hidden" name="id" id="edit_id" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="edit_nama_barang" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_stok" class="form-label">Stok</label>
                        <input type="number" name="stok" id="edit_stok" class="form-control" required min="0" />
                    </div>
                    <div class="mb-3">
                        <label for="edit_minimum_stok" class="form-label">Minimum Stok</label>
                        <input type="number" name="minimum_stok" id="edit_minimum_stok" class="form-control" required min="0" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleModeBtn');
        const htmlRoot = document.getElementById('htmlRoot');

        const currentMode = localStorage.getItem('theme');
        if (currentMode === 'dark') {
            htmlRoot.setAttribute('data-bs-theme', 'dark');
            toggleBtn.textContent = '☀️';
        }

        toggleBtn.addEventListener('click', () => {
            const theme = htmlRoot.getAttribute('data-bs-theme');
            if (theme === 'light') {
                htmlRoot.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                toggleBtn.textContent = '☀️';
            } else {
                htmlRoot.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('theme', 'light');
                toggleBtn.textContent = '🌙';
            }
        });

        const editButtons = document.querySelectorAll('.edit-btn');
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('edit_id').value = button.getAttribute('data-id');
                document.getElementById('edit_nama_barang').value = button.getAttribute('data-nama');
                document.getElementById('edit_stok').value = button.getAttribute('data-stok');
                document.getElementById('edit_minimum_stok').value = button.getAttribute('data-minimum');
                editModal.show();
            });
        });

        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('stokTable');
        const tbody = table.tBodies[0];

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            for (const row of tbody.rows) {
                const namaBarang = row.cells[0].textContent.toLowerCase();
                row.style.display = namaBarang.includes(filter) ? '' : 'none';
            }
        });
    </script>
</body>
</html>
