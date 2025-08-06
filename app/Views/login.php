<!DOCTYPE html>
<html data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <title>Login - Monitoring Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(135deg, var(--bs-body-tertiary) 0%, var(--bs-light) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
        }
        .mode-toggle {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1050;
        }
        .copyright {
            font-size: 0.85rem;
            color: var(--bs-secondary-color);
            margin-top: 20px;
            text-align: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 10px;
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }
        /* Style for the "profile picture" logo on the login page */
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-profile-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid var(--bs-primary);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Adjustments for input group icons */
        .input-group .input-group-text {
            /* Ensure background and border match theme */
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            border-color: var(--bs-border-color);
        }

        /* Specific style for the password toggle button within an input group */
        #togglePassword {
            cursor: pointer;
        }
        #togglePassword:hover {
            color: var(--bs-primary);
        }
    </style>
</head>
<body class="bg-body-tertiary">

    <button class="btn btn-outline-secondary mode-toggle" id="toggleModeBtn">🌙</button>

    <div class="card p-4 shadow-lg login-card">
        <div class="logo-container">
            <img src="<?= base_url('img/profiles/Kebun.png') ?>" alt="Monitoring Barang Logo" class="login-profile-pic">
            <h4 class="text-center mb-0">Monitoring Barang dan Bahan</h4>
            <p class="text-muted">PT Campang Tiga Mukut</p>
        </div>

        <h3 class="text-center mb-4">Login</h3>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/auth') ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label visually-hidden">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus autocomplete="username">
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label visually-hidden">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                    <button type="button" class="input-group-text" id="togglePassword">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Peran</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">-- Pilih Peran --</option>
                    <option value="Karyawan">Karyawan</option>
                    <option value="Staf Gudang">Staf Gudang</option>
                    <option value="Manajer Gudang">Manajer Gudang</option>
                    <option value="Keuangan">Keuangan</option>
                </select>
            </div>
            <div class="mb-4 text-center">
                <div class="form-check d-inline-block">
                    <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="remember_me">
                    <label class="form-check-label" for="rememberMe">
                        Ingat Saya
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg">Masuk</button>
        </form>

        <div class="copyright">
            &copy; <?= date('Y') ?> Monitoring Barang. All rights reserved.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleModeBtn');
        const htmlRoot = document.getElementById('htmlRoot');

        // Load mode from localStorage
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

        // --- Password Show/Hide Functionality ---
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>