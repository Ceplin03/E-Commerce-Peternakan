<?php
$title = 'Keranjang Belanja';

require '../app/views/layouts/header.php';
require '../app/config/database.php';
require '../app/helpers/cart.php';

$cart = getCart();
$total = 0;
?>

<section class="max-w-6xl mx-auto px-4 py-6 md:py-20 min-h-[80vh] bg-slate-50/50 md:bg-transparent">
    <div class="flex items-center justify-between mb-6 md:mb-10">
        <div>
            <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight">Keranjang</h1>
            <p class="text-xs md:text-base text-slate-500 mt-1">Total item: <span class="font-bold text-green-600"><?= count($cart) ?></span></p>
        </div>
        <a href="index.php?page=shop" class="text-sm md:text-base text-green-600 font-bold flex items-center gap-1">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> <span class="hidden md:inline">Tambah Item</span>
        </a>
    </div>

    <?php if (empty($cart)) : ?>
        <div class="text-center py-20 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 px-6">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-slate-300"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Keranjang Kosong</h2>
            <p class="text-slate-500 mt-2 text-sm">Mari penuhi kebutuhan nutrisi harian Anda.</p>
            <a href="index.php?page=shop" class="inline-block mt-8 px-8 py-3 bg-green-600 text-white rounded-2xl font-bold shadow-lg shadow-green-200">
                Belanja Sekarang
            </a>
        </div>
    <?php else : ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-10 pb-32 md:pb-0">
        
        <div class="lg:col-span-2 space-y-3 md:space-y-6">
            <?php foreach ($cart as $id => $qty) : ?>
            <?php
                $q = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
                $p = mysqli_fetch_assoc($q);
                if (!$p) continue;

                $subtotal = $p['harga'] * $qty;
                $total += $subtotal;

                $gambar = "TelurS.png";
                if (stripos($p['nama_produk'], 'Bakso') !== false) $gambar = "TelurBakso.png";
                elseif (stripos($p['nama_produk'], 'Menengah') !== false) $gambar = "TelurMK.png";
            ?>

            <div class="bg-white rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-sm p-4 md:p-8 flex gap-4 md:gap-6 items-center">
                
                <div class="w-20 h-20 md:w-28 md:h-28 bg-slate-50 rounded-2xl flex-shrink-0 flex items-center justify-center p-2">
                    <img src="assets/images/<?= $gambar ?>" alt="<?= $p['nama_produk'] ?>" class="w-full h-full object-contain">
                </div>

                <div class="flex-grow flex flex-col justify-between h-20 md:h-28">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="font-bold text-slate-800 text-sm md:text-lg leading-tight line-clamp-1">
                                <?= htmlspecialchars($p['nama_produk']) ?>
                            </h2>
                            <p class="text-xs md:text-sm font-semibold text-green-600 mt-0.5">
                                Rp<?= number_format($p['harga'],0,',','.') ?> <span class="text-slate-400 font-normal">/ kg</span>
                            </p>
                        </div>
                        <a href="?page=remove-cart&id=<?= $id ?>" class="hidden md:block text-red-300 hover:text-red-500 transition-colors">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </a>
                    </div>

                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center bg-slate-50 px-1 py-1 rounded-xl border border-slate-100">
                            <button class="qty-btn w-7 h-7 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-500 active:scale-90" 
                                    data-id="<?= $id ?>" data-action="minus">
                                <i data-lucide="minus" class="w-3 h-3 md:w-4 md:h-4"></i>
                            </button>
                            <span class="w-8 text-center font-bold text-slate-800 text-sm qty-value" data-id="<?= $id ?>"><?= $qty ?></span>
                            <button class="qty-btn plus-btn w-7 h-7 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-500 active:scale-90" 
                                    data-id="<?= $id ?>" data-action="plus" data-stock="<?= $p['stok'] ?>" <?= $qty >= $p['stok'] ? 'disabled' : '' ?>>
                                <i data-lucide="plus" class="w-3 h-3 md:w-4 md:h-4"></i>
                            </button>
                        </div>
                        
                        <div class="text-right">
                             <p class="font-black text-slate-900 text-sm md:text-lg" 
                               data-price="<?= $p['harga'] ?>" data-id="<?= $id ?>" id="subtotal-<?= $id ?>">
                                Rp<?= number_format($subtotal,0,',','.') ?>
                            </p>
                            <a href="?page=remove-cart&id=<?= $id ?>" class="md:hidden text-[10px] font-bold text-red-400 uppercase tracking-tighter">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="lg:col-span-1">
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 p-4 md:relative md:p-8 md:rounded-[2.5rem] md:border md:shadow-xl md:shadow-slate-200/50 md:sticky md:top-28 z-50">
                <div class="max-w-6xl mx-auto flex items-center justify-between md:block">
                    <div class="md:mb-6">
                        <p class="text-[10px] md:text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Total Bayar</p>
                        <h3 id="cart-total" class="text-xl md:text-3xl font-black text-green-600 leading-none">
                            Rp<?= number_format($total,0,',','.') ?>
                        </h3>
                    </div>

                    <div class="flex gap-2 md:flex-col md:gap-3">
                        <a href="?page=checkout" class="px-6 md:px-10 py-3.5 md:py-4 bg-green-600 text-white rounded-2xl font-bold shadow-lg shadow-green-200 hover:bg-green-700 active:scale-95 transition-all text-sm md:text-base">
                            Checkout <span class="hidden md:inline">Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>
</section>

<script>
lucide.createIcons();

// Logic update harga (sama seperti sebelumnya agar sinkron)
function updateTotal() {
    let total = 0;
    document.querySelectorAll('[data-price]').forEach(el => {
        const price = parseInt(el.dataset.price);
        const id = el.dataset.id;
        const qtyEl = document.querySelector(`.qty-value[data-id="${id}"]`);
        if(!qtyEl) return;
        
        const qty = parseInt(qtyEl.textContent);
        const subtotal = price * qty;
        total += subtotal;
        
        document.getElementById(`subtotal-${id}`).textContent = 'Rp' + subtotal.toLocaleString('id-ID');
    });

    const formattedTotal = 'Rp' + total.toLocaleString('id-ID');
    document.querySelectorAll('#cart-total').forEach(el => el.textContent = formattedTotal);
}

document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const action = this.dataset.action;
        const qtyEl = document.querySelector(`.qty-value[data-id="${id}"]`);
        const currentQty = parseInt(qtyEl.textContent);

        if (action === 'minus' && currentQty <= 1) return;
        if (action === 'plus') {
            const stock = parseInt(this.dataset.stock);
            if (currentQty >= stock) return;
        }

        qtyEl.style.opacity = '0.5';

        fetch('ajax/cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&action=${action}`
        })
        .then(res => res.json())
        .then(data => {
            qtyEl.style.opacity = '1';
            if (data.status === 'ok') {
                qtyEl.textContent = data.qty;
                if(typeof updateCartCount === 'function') updateCartCount(data.totalQty);
                updateTotal();
            }
        });
    });
});
</script>