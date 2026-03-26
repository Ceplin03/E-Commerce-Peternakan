<?php
require '../app/helpers/auth.php';
require '../app/config/database.php';

adminOnly();

$id = $_GET['id'] ?? 0;

// DATA ORDER (Logika Tetap)
$order = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM orders WHERE id='$id'")
);

if (!$order) {
    echo "Order tidak ditemukan";
    exit;
}

// ITEM ORDER (Logika Tetap)
$items = mysqli_query($conn,
    "SELECT oi.*, p.nama_produk
     FROM order_items oi
     JOIN products p ON oi.product_id = p.id
     WHERE oi.order_id='$id'"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= $order['kode_order'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* OPTIMASI CETAK (1 HALAMAN) */
        @media print {
            @page {
                size: A4;
                margin: 10mm; /* Memperkecil margin kertas */
            }
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-shrink { 
                padding: 1.5rem !important; /* Mengurangi padding card */
                border-radius: 1rem !important; /* Mengurangi radius agar hemat tempat */
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
            }
            .print-compact-text { font-size: 0.85rem !important; }
            .print-row-tight { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
            .print-margin-none { margin-bottom: 1rem !important; }
            .print-grid { display: block !important; } /* Mengubah grid jadi block agar tidak terpotong */
            .print-w-full { width: 100% !important; margin-bottom: 1rem !important; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

<div class="max-w-5xl mx-auto px-6 py-6 md:py-10">
    
    <div class="mb-6 no-print">
        <a href="?page=dashboard" class="group inline-flex items-center text-sm font-bold text-slate-500 hover:text-green-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 print-margin-none">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                Invoice <span class="text-green-600">#<?= $order['kode_order'] ?></span>
            </h1>
            <p class="text-slate-400 text-xs md:text-sm font-medium">
                Waktu Transaksi: <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
            </p>
        </div>
        <button onclick="window.print()" class="no-print flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 shadow-sm transition-all">
            <i data-lucide="printer" class="w-4 h-4"></i> Cetak Sekarang
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 print-grid">
        
        <div class="lg:col-span-1 space-y-4 print-w-full">
            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm print-shrink">
                <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-green-600"></i> Data Pembeli
                </h3>
                <div class="space-y-4 print-compact-text">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama</p>
                        <p class="text-slate-800 font-bold"><?= htmlspecialchars($order['nama']) ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">WhatsApp</p>
                        <p class="text-slate-800 font-semibold"><?= $order['no_hp'] ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat</p>
                        <p class="text-slate-600 leading-tight"><?= nl2br(htmlspecialchars($order['alamat'])) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm print-shrink">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Metode Pembayaran</p>
                <div class="p-3 bg-blue-50/50 rounded-xl border border-blue-100 flex items-center justify-between">
                    <span class="font-bold text-blue-700 text-xs uppercase"><?= $order['metode_pembayaran'] ?></span>
                    <i data-lucide="shield-check" class="w-4 h-4 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 print-w-full">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden print-shrink">
        <div class="p-6 md:p-10">
            <h3 class="text-xl font-bold text-slate-900 mb-8 flex items-center gap-2 print-margin-none">
                <i data-lucide="shopping-bag" class="w-6 h-6 text-green-600"></i>
                Daftar Produk
            </h3>

            <div class="hidden md:block print:block overflow-x-auto text-sm">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100 text-[10px] text-slate-400 uppercase tracking-widest font-bold">
                            <th class="pb-4">Produk</th>
                            <th class="pb-4 text-center">Jumlah</th>
                            <th class="pb-4 text-right">Harga</th>
                            <th class="pb-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php
                        $grand = 0;
                        mysqli_data_seek($items, 0); // Reset pointer agar bisa diloop ulang
                        while ($i = mysqli_fetch_assoc($items)) :
                            $sub = $i['qty'] * $i['harga'];
                            $grand += $sub;
                        ?>
                        <tr class="print-compact-text">
                            <td class="py-5 font-bold text-slate-800 print-row-tight"><?= $i['nama_produk'] ?></td>
                            <td class="py-5 text-center font-bold text-slate-600 print-row-tight"><?= $i['qty'] ?> kg</td>
                            <td class="py-5 text-right text-slate-500 print-row-tight">Rp<?= number_format($i['harga'],0,',','.') ?></td>
                            <td class="py-5 text-right font-black text-slate-900 print-row-tight">Rp<?= number_format($sub,0,',','.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="block md:hidden print:hidden space-y-4">
                <?php 
                mysqli_data_seek($items, 0); 
                while ($i = mysqli_fetch_assoc($items)) : 
                    $sub = $i['qty'] * $i['harga'];
                ?>
                <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-bold text-slate-800"><?= $i['nama_produk'] ?></span>
                        <span class="text-xs font-bold text-slate-500"><?= $i['qty'] ?> kg</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-xs text-slate-400">Rp<?= number_format($i['harga'],0,',','.') ?></span>
                        <span class="font-black text-green-700">Rp<?= number_format($sub,0,',','.') ?></span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div class="mt-10 pt-8 border-t-2 border-dashed border-slate-100">
                <div class="flex flex-col items-end gap-2">
                    <div class="flex items-center gap-4 bg-green-50 px-8 py-5 rounded-3xl border border-green-100">
                        <span class="text-xs font-bold text-green-600 uppercase tracking-widest">Total Bayar</span>
                        <h2 class="text-3xl font-[900] text-green-700 tracking-tighter">
                            Rp<?= number_format($grand,0,',','.') ?>
                        </h2>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 font-medium italic">"Harap pastikan stok fisik sesuai sebelum konfirmasi."</p>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>