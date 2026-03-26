<?php
$title = 'MuntiEggs | Telur Segar Kualitas Premium';

require '../app/views/layouts/header.php';
require '../app/config/database.php';
require '../app/models/Product.php';

$products = Product::all($conn);
?>

<section class="relative overflow-hidden bg-white pt-12 pb-16 md:pt-20 md:pb-24">
    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 rounded-full bg-green-50 text-green-700 text-[10px] font-bold tracking-[0.2em] uppercase mb-4 border border-green-100">
            Fresh From Farm
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 leading-tight">
            Telur Segar <span class="text-green-600">Penuh Nutrisi</span>
        </h1>
        <p class="text-base md:text-lg text-slate-500 mb-10 leading-relaxed">
            Kami memastikan setiap butir telur yang sampai ke tangan Anda adalah hasil seleksi ketat dengan standar kebersihan yang tinggi.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#produk" class="px-8 py-4 bg-green-600 text-white font-bold rounded-2xl shadow-xl shadow-green-100 hover:bg-green-700 transition-all">
                Belanja Sekarang
            </a>
            <a href="#" class="px-8 py-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-slate-100 transition-all">
                Pelajari Kualitas
            </a>
        </div>
    </div>
</section>

<section id="produk" class="bg-slate-50/50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Katalog Produk</h2>
            <div class="w-20 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">

            <?php while ($p = mysqli_fetch_assoc($products)) : ?>
            
                <?php
                // LOGIKA GAMBAR PRODUK
                $nama_produk = $p['nama_produk'];
                $gambar = "TelurS.png"; // default

                if (stripos($nama_produk, 'Bakso') !== false) {
                    $gambar = "TelurBakso.png";
                } elseif (stripos($nama_produk, 'Menengah') !== false) {
                    $gambar = "TelurMK.png";
                } elseif (stripos($nama_produk, 'Standar') !== false) {
                    $gambar = "TelurS.png";
                }
                
                // Path file untuk pengecekan waktu modifikasi (Cache Busting)
                $imagePath = "assets/images/" . $gambar;
                $version = file_exists($imagePath) ? filemtime($imagePath) : time();
                ?>

                <div class="group w-full max-w-[340px] bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col">
                    
                    <div class="relative aspect-square bg-slate-100 overflow-hidden">
                        <div class="absolute top-6 left-6 z-10">
                            <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-bold text-slate-700 shadow-sm uppercase tracking-widest border border-white/50">
                                <?= htmlspecialchars($p['tipe']) ?>
                            </span>
                        </div>
                        
                        <img src="<?= $imagePath ?>?v=<?= $version ?>"
                             alt="<?= htmlspecialchars($nama_produk) ?>"
                             class="w-full h-full object-contain p-8 group-hover:scale-110 transition-transform duration-1000">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow text-center">
                        <h3 class="font-bold text-slate-800 text-xl mb-2 group-hover:text-green-600 transition-colors">
                            <?= htmlspecialchars($nama_produk) ?>
                        </h3>
                        
                        <div class="flex justify-center text-yellow-400 mb-6 gap-0.5">
                             <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                             <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                             <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                             <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                             <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 mb-8">
                            <p class="text-[10px] text-slate-400 uppercase font-bold mb-1 tracking-widest">Harga per Kg</p>
                            <p class="text-2xl font-black text-slate-900">
                                Rp<?= number_format($p['harga'], 0, ',', '.') ?>
                            </p>
                            <p class="text-[11px] text-green-600 font-bold mt-1">Stok: <?= $p['stok'] ?> kg tersedia</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button 
                                class="add-to-cart-btn w-full group relative border-2 border-green-600 text-green-600 py-3.5 rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-green-50 transition-all duration-300 active:scale-95"
                                data-id="<?= $p['id'] ?>">
                                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:animate-bounce"></i>
                                <span class="text-sm">Keranjang</span>
                            </button>

                            <button 
                                class="buy-now-btn w-full bg-green-600 text-white py-3.5 rounded-2xl font-bold shadow-lg shadow-green-100 hover:bg-green-700 transition-all duration-300 active:scale-95"
                                data-id="<?= $p['id'] ?>">
                                <span class="text-sm">Beli Sekarang</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </div>
</section>

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    /**
     * Efek Animasi Telur Terbang
     */
    function flyToCart(button) {
        const cartIcon = document.querySelector('.cart-count');
        if (!cartIcon) return;

        const rectStart = button.getBoundingClientRect();
        const rectEnd = cartIcon.getBoundingClientRect();

        const flyer = document.createElement('div');
        flyer.innerHTML = '🥚';
        flyer.style.position = 'fixed';
        flyer.style.left = rectStart.left + (rectStart.width / 2) + 'px';
        flyer.style.top = rectStart.top + 'px';
        flyer.style.fontSize = '24px';
        flyer.style.zIndex = '9999';
        flyer.style.transition = 'all 0.8s cubic-bezier(0.42, 0, 0.58, 1)';

        document.body.appendChild(flyer);

        setTimeout(() => {
            flyer.style.left = rectEnd.left + 'px';
            flyer.style.top = rectEnd.top + 'px';
            flyer.style.transform = 'scale(0.3) rotate(360deg)';
            flyer.style.opacity = '0';
        }, 50);

        setTimeout(() => flyer.remove(), 800);
    }

    /**
     * Event Listener Keranjang & Beli
     */
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. TAMBAH KE KERANJANG
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                
                // Jalankan animasi terbang
                flyToCart(this);

                fetch('ajax/cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}&action=plus`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'ok') {
                        // Update angka di badge (Desktop & Mobile)
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.totalQty;
                            el.classList.add('animate-ping');
                            setTimeout(() => el.classList.remove('animate-ping'), 500);
                        });
                    }
                })
                .catch(err => console.error('Error:', err));
            });
        });

        // 2. BELI SEKARANG
        document.querySelectorAll('.buy-now-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                
                fetch('ajax/cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}&action=plus`
                })
                .then(() => {
                    window.location.href = '?page=cart';
                });
            });
        });
    });
</script>

<?php require '../app/views/layouts/footer.php'; ?>