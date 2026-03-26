<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Toko Telur Munti - Kualitas Terbaik' ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-blur {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.8);
        }
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #16a34a;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
    <style>
    /* Animasi Masuk Halaman */
    html {
        scroll-behavior: smooth; /* Membuat scroll ke ID #produk jadi sangat halus */
    }

    body {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    body.loaded {
        opacity: 1;
    }
</style>

</head>
<body class="bg-slate-50 text-slate-900">

<nav class="sticky top-0 z-50 nav-blur border-b border-slate-200/60 bg-white/80 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex items-center gap-2 group cursor-pointer">
                <div class="bg-green-600 p-2 rounded-xl group-hover:rotate-12 transition-all">
                    <i data-lucide="egg" class="text-white w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-800">
                    Munti<span class="text-green-600">Eggs</span>
                </span>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="?page=shop" class="nav-link text-sm font-medium text-slate-600 hover:text-green-600">Beranda</a>
                <a href="#produk" class="nav-link text-sm font-medium text-slate-600 hover:text-green-600">Produk</a>
                <a href="?page=cart" class="nav-link text-sm font-medium text-slate-600 hover:text-green-600 flex items-center gap-1">
    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
    <?php if (!empty($_SESSION['cart'])) : ?>
        <span class="bg-green-600 text-white text-xs px-2 py-0.5 rounded-full">
        <?= array_sum($_SESSION['cart'] ?? []) ?>
        </span>
    <?php endif; ?>
</a>

                <a href="?page=login" class="px-5 py-2.5 text-sm font-semibold text-white bg-green-600 rounded-full shadow-lg shadow-green-200 hover:bg-green-700 transition-all">
                    Login
                </a>
            </div>

            <div class="md:hidden flex items-center gap-2">
    <a href="?page=cart" class="relative p-2 text-slate-700 bg-slate-50 rounded-xl mr-2">
        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
        <span class="cart-count absolute -top-1 -right-1 bg-green-600 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
            <?= array_sum($_SESSION['cart'] ?? [0]) ?>
        </span>
    </a>
    
    <button id="mobile-menu-button" class="p-2 text-slate-700 focus:outline-none">
        <i data-lucide="menu" class="w-7 h-7"></i>
    </button>
</div>
        </div>
    </div>

    <div id="mobile-sidebar" class="hidden md:hidden bg-white border-b border-slate-100 shadow-xl overflow-hidden transition-all duration-300">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="#produk" class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="package" class="w-5 h-5"></i> Produk
                </div>
            </a>
            <a href="?page=login" class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="log-in" class="w-5 h-5"></i> Login
                </div>
            </a>
        </div>
    </div>
</nav>

<script>
    const menuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('mobile-sidebar');

    menuButton.addEventListener('click', () => {
        // Toggle class 'hidden'
        sidebar.classList.toggle('hidden');
        
        // Opsional: Animasi ganti ikon (dari menu ke X)
        const icon = menuButton.querySelector('i');
        if (sidebar.classList.contains('hidden')) {
            icon.setAttribute('data-lucide', 'menu');
        } else {
            icon.setAttribute('data-lucide', 'x');
        }
        lucide.createIcons(); // Re-render icon
    });

    // Menutup sidebar otomatis jika link diklik
    document.querySelectorAll('#mobile-sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            sidebar.classList.add('hidden');
            document.querySelector('#mobile-menu-button i').setAttribute('data-lucide', 'menu');
            lucide.createIcons();
        });
    });
</script>

<script>
    // Inisialisasi Lucide Icons
    lucide.createIcons();
</script>

<script>
    // Pastikan ikon Lucide tetap jalan
    lucide.createIcons();

    // Efek Fade-in saat halaman selesai dimuat
    window.addEventListener('DOMContentLoaded', () => {
        document.body.classList.add('loaded');
    });

    // Menangani Smooth Scroll untuk menu "Produk"
    // Agar jika kita di halaman home, dia scroll halus ke bawah
    // Jika dari halaman lain (seperti login), dia akan pindah dulu baru scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>