<?php

$title = 'Login Admin';
require '../app/config/database.php';

if (isset($_SESSION['admin'])) {
    header('Location: ?page=dashboard');
    exit;
}

$error = '';
$loginSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $p = md5($_POST['password']);

    // LOGIKA ASLI (TIDAK DIUBAH)
    $q = mysqli_query($conn,
        "SELECT * FROM users WHERE username='$u' AND password='$p' AND role='admin'"
    );

    if (mysqli_num_rows($q) > 0) {
        $_SESSION['admin'] = $u;
        $loginSuccess = true;
    } else {
        $error = 'Username atau password salah';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | MuntiEggs</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=LINE+Seed+JP:wght@400;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        /* Font khusus SweetAlert */
        .swal-line {
            font-family: 'LINE Seed JP', 'Plus Jakarta Sans', sans-serif !important;
        }
    </style>
    <style>
.swal-line {
    font-family: 'LINE Seed JP', 'Plus Jakarta Sans', sans-serif !important;
}

.morph-wrap {
    width: 120px;
    height: 120px;
    margin: 0 auto 12px;
    position: relative;
}

.loader {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 6px solid #e5e7eb;
    border-top-color: #16a34a;
    animation: spin 0.8s linear infinite;
}

.checkmark {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 6px solid #16a34a;
    position: absolute;
    top: 0;
    left: 0;
    display: none;
}

.checkmark svg {
    width: 60px;
    height: 60px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.checkmark path {
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: draw 0.4s ease forwards;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@keyframes draw {
    to { stroke-dashoffset: 0; }
}
</style>

</head>

<body class="bg-[#f8fafc] flex items-center justify-center min-h-screen p-6 relative overflow-hidden">

    <!-- Background blur -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-green-50 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-50 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[420px] relative">
        <div class="text-center mb-8">
            <div class="bg-green-600 w-16 h-16 rounded-[1.5rem] flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-200">
                <i data-lucide="shield-check" class="text-white w-8 h-8"></i>
            </div>
            <h1 class="text-3xl font-[800] text-slate-900 tracking-tight">MuntiEggs Admin</h1>
            <p class="text-slate-400 mt-2 font-medium">Panel kontrol manajemen peternakan</p>
        </div>

        <form method="post" class="bg-white p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100">

            <div class="space-y-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">
                        Username
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300"></i>
                        <input name="username" type="text" required
                            placeholder="Masukkan username"
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-12 py-4 text-sm font-semibold focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:bg-white focus:border-green-500 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">
                        Password
                    </label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300"></i>
                        <input name="password" type="password" required
                            placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-12 py-4 text-sm font-semibold focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:bg-white focus:border-green-500 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-green-600 transition-all duration-300 shadow-xl shadow-slate-200 hover:shadow-green-200 flex items-center justify-center gap-2 group">
                    <span>Masuk ke Dashboard</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

            <div class="relative my-8 text-center">
                <hr class="border-slate-100">
                <span class="bg-white px-4 text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 italic">
                    Atau
                </span>
            </div>

            <a href="?page=shop"
                class="flex items-center justify-center gap-2 w-full py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all">
                <i data-lucide="shopping-bag" class="w-4 h-4 text-slate-400"></i>
                Kembali ke Toko
            </a>
        </form>

        <p class="text-center text-slate-300 text-[11px] mt-8 font-bold uppercase tracking-[0.2em]">
            © 2026 MuntiEggs Secure System
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>

    <!-- SWEETALERT LOGIN SUCCESS -->
    <?php if ($loginSuccess): ?>
<script>
Swal.fire({
    title: 'Login Berhasil',
    html: `
        <div class="morph-wrap">
            <div class="loader" id="loader"></div>
            <div class="checkmark" id="check">
                <svg viewBox="0 0 52 52" fill="none">
                    <path d="M14 27 L23 36 L38 18"
                          stroke="#16a34a"
                          stroke-width="5"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <p class="text-slate-500 mt-2">Memverifikasi akses admin…</p>
    `,
    showConfirmButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
    customClass: {
        popup: 'swal-line'
    },
    didOpen: () => {
        setTimeout(() => {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('check').style.display = 'block';
        }, 900);
    }
}).then(() => {
    window.location.href = '?page=dashboard';
});

setTimeout(() => {
    Swal.close();
}, 1600);
</script>
<?php endif; ?>


    <!-- SWEETALERT LOGIN FAILED -->
    <?php if ($error): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '<?= $error ?>',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#dc2626',
            customClass: {
                popup: 'swal-line',
                title: 'swal-line',
                htmlContainer: 'swal-line',
                confirmButton: 'swal-line'
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>
