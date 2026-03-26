<?php
$title = 'Pesanan Berhasil';

require '../app/views/layouts/header.php';
$kode = $_GET['kode'] ?? 'ORD-000000';
$metode = $_GET['metode'] ?? 'Belum dipilih';
?>

<section class="max-w-4xl mx-auto px-6 py-16 md:py-24">
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-50">
        
        <div class="bg-green-600 px-8 py-12 text-center text-white relative">
            <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-16 -translate-y-16"></div>
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-black/5 rounded-full translate-x-12 translate-y-12"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight mb-2">Pesanan Berhasil!</h1>
                <p class="text-green-100 font-medium">Terima kasih, pesanan Anda sedang kami proses.</p>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-slate-400 mb-1">Kode Transaksi</p>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-black text-slate-800 tracking-tighter"><?= htmlspecialchars($kode) ?></span>
                            <button onclick="copyToClipboard('<?= $kode ?>')" class="p-2 hover:bg-slate-100 rounded-lg transition" title="Salin Kode">
                                <i data-lucide="copy" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-green-600">
                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Metode Pembayaran</p>
                            <p class="font-bold text-slate-800"><?= htmlspecialchars($metode) ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 rounded-[2rem] p-6 border border-orange-100">
                    <h3 class="font-bold text-orange-800 flex items-center gap-2 mb-3">
                        <i data-lucide="info" class="w-5 h-5"></i>
                        Langkah Selanjutnya
                    </h3>
                    <ul class="text-sm text-orange-700/80 space-y-3 font-medium">
                        <li class="flex gap-3">
                            <span class="w-5 h-5 bg-orange-200 text-orange-800 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">1</span>
                            Screenshot halaman ini sebagai bukti.
                        </li>
                        <li class="flex gap-3">
                            <span class="w-5 h-5 bg-orange-200 text-orange-800 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">2</span>
                            Admin kami akan menghubungi via WhatsApp.
                        </li>
                        <li class="flex gap-3">
                            <span class="w-5 h-5 bg-orange-200 text-orange-800 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">3</span>
                            Siapkan pembayaran sesuai metode yang dipilih.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="?page=shop" class="flex items-center justify-center gap-2 px-10 py-4 bg-green-600 text-white rounded-2xl font-bold hover:bg-green-700 hover:shadow-xl hover:shadow-green-200 transition-all active:scale-95">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    Belanja Lagi
                </a>
                <a href="https://wa.me/6281275751928?text=Halo%20Admin%2C%20saya%20ingin%20konfirmasi%20pesanan%20<?= $kode ?>" 
                   target="_blank"
                   class="flex items-center justify-center gap-2 px-10 py-4 bg-white border-2 border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-all active:scale-95">
                    <i data-lucide="message-circle" class="w-5 h-5 text-green-500"></i>
                    Chat Admin
                </a>
            </div>
        </div>
    </div>

    <p class="text-center text-slate-400 text-sm mt-10">
        Punya kendala? <a href="#" class="text-green-600 font-bold hover:underline">Pusat Bantuan</a>
    </p>
</section>

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Fungsi Copy Kode
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        alert('Kode Pesanan disalin ke clipboard!');
    }
</script>

<style>
    /* Tambahan animasi smooth */
    @keyframes bounce {
        0%, 100% { transform: translateY(-5%); }
        50% { transform: translateY(0); }
    }
    .animate-bounce {
        animation: bounce 2s infinite ease-in-out;
    }
</style>

<?php require '../app/views/layouts/footer.php'; ?>