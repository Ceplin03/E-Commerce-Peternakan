<?php
$title = 'Checkout';

require '../app/config/database.php';
require '../app/helpers/cart.php';

$cart = getCart();

// 🔴 REDIRECT SEBELUM RENDER HTML
$totalQty = 0;
foreach ($cart as $qty) {
    $totalQty += (int)$qty;
}

if ($totalQty <= 0) {
    header('Location: ?page=cart');
    exit;
}

require '../app/views/layouts/header.php';
$total = 0;
?>

<section class="max-w-6xl mx-auto px-6 py-12 md:py-20">
    <div class="flex flex-col md:flex-row gap-12">
        
        <div class="flex-[1.5] space-y-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Checkout</h1>
                <p class="text-slate-500 mt-2">Lengkapi data pengiriman untuk menyelesaikan pesanan Anda.</p>
            </div>

            <form id="checkout-form" method="post" action="?page=checkout-process" class="space-y-8">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 space-y-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                        <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm">1</span>
                        Informasi Pengiriman
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                            <input type="text" name="nama" placeholder="Masukkan nama penerima" required
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-green-500 transition">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">No. WhatsApp</label>
                            <input type="tel" name="no_hp" placeholder="Contoh: 08123456789" required
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-green-500 transition">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Nama jalan, Nomor rumah, RT/RW, Kelurahan, Kecamatan" required
                                  class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-green-500 transition"></textarea>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 space-y-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                        <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm">2</span>
                        Metode Pembayaran
                    </h2>

                    <div class="grid grid-cols-1 gap-4">
                        <label class="payment-card relative flex items-center gap-4 p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-green-600 has-[:checked]:bg-green-50/30">
                            <input type="radio" name="metode_pembayaran" value="Transfer Bank" required class="accent-green-600 w-5 h-5">
                            <div>
                                <p class="font-bold text-slate-800">Transfer Bank</p>
                                <p class="text-xs text-slate-500">BCA, BRI, atau Mandiri</p>
                            </div>
                        </label>

                        <label class="payment-card relative flex items-center gap-4 p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-green-600 has-[:checked]:bg-green-50/30">
                            <input type="radio" name="metode_pembayaran" value="Bayar di Tempat" class="accent-green-600 w-5 h-5">
                            <div>
                                <p class="font-bold text-slate-800">Bayar di Tempat (COD)</p>
                                <p class="text-xs text-slate-500">Bayar tunai saat kurir sampai</p>
                            </div>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex-1">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 sticky top-24 text-white shadow-2xl shadow-slate-300">
                <h2 class="text-xl font-bold mb-8 flex items-center justify-between">
                    Ringkasan Belanja
                    <span class="text-xs bg-white/10 px-3 py-1 rounded-full font-normal">
                        <?= $totalQty ?> kg
                    </span>
                </h2>

                <div class="space-y-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    <?php foreach ($cart as $id => $qty): ?>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
                        $p = mysqli_fetch_assoc($q);
                        $subtotal = $p['harga'] * $qty;
                        $total += $subtotal;
                        ?>
                        <div class="flex justify-between gap-4">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-white leading-tight"><?= $p['nama_produk'] ?></p>
                                <p class="text-xs text-slate-400 mt-1"><?= $qty ?> kg x Rp<?= number_format($p['harga'],0,',','.') ?></p>
                            </div>
                            <span class="text-sm font-bold">Rp<?= number_format($subtotal,0,',','.') ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-white/10 my-8 pt-8 space-y-4">
                    <div class="flex justify-between text-slate-400">
                        <span>Biaya Pengiriman</span>
                        <span class="text-white font-bold italic">Gratis</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-slate-400">Total Pembayaran</span>
                        <span class="text-3xl font-black text-green-400">
                            Rp<?= number_format($total,0,',','.') ?>
                        </span>
                    </div>
                </div>

                <button type="submit" form="checkout-form"
                        class="w-full bg-green-500 text-white py-5 rounded-2xl font-black text-lg hover:bg-green-400 active:scale-95 transition-all shadow-lg shadow-green-500/20 mt-4">
                    BUAT PESANAN SEKARANG
                </button>
                
                <p class="text-[10px] text-center text-slate-500 mt-6 uppercase tracking-widest font-bold">
                    🔒 Keamanan Transaksi Terjamin
                </p>
            </div>
        </div>

    </div>
</section>

<style>
    /* Styling scrollbar untuk ringkasan produk */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    
    /* Menghilangkan ring fokus default pada input */
    input:focus, textarea:focus { outline: none; }
</style>

<?php require '../app/views/layouts/footer.php'; ?>