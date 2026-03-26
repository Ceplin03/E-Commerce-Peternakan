<?php
require '../app/helpers/auth.php';
require '../app/config/database.php';

adminOnly();

// LOGIKA ASLI (TIDAK DIUBAH)
$total = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(total) AS total FROM orders")
)['total'] ?? 0;

$totalOrder = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jml FROM orders")
)['jml'] ?? 0;

$hariIni = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT SUM(total) AS t FROM orders WHERE DATE(created_at)=CURDATE()")
)['t'] ?? 0;

$orders = mysqli_query($conn,
    "SELECT * FROM orders ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | MuntiEggs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

<div class="max-w-7xl mx-auto px-6 py-10">
    
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ringkasan Bisnis</h1>
            <p class="text-slate-500 text-sm mt-1">Pantau performa penjualan MuntiEggs Anda secara real-time.</p>
        </div>
        <a href="?page=logout" class="flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-all text-sm">
            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:shadow-md transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Total Omzet</p>
            </div>
            <h2 class="text-3xl font-black text-slate-900">
                Rp<?= number_format($total,0,',','.') ?>
            </h2>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:shadow-md transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Total Order</p>
            </div>
            <h2 class="text-3xl font-black text-slate-900"><?= $totalOrder ?> <span class="text-sm font-medium text-slate-400 italic">Pesanan</span></h2>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:shadow-md transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-orange-50 text-orange-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Omzet Hari Ini</p>
            </div>
            <h2 class="text-3xl font-black text-green-600">
                Rp<?= number_format($hariIni,0,',','.') ?>
            </h2>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                <i data-lucide="list-ordered" class="text-green-600"></i>
                Daftar Transaksi Terbaru
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50 text-left border-b border-slate-100">
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">Kode Order</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">Nama Pembeli</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">Total Bayar</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">Metode</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">Tanggal</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while ($o = mysqli_fetch_assoc($orders)) : ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="font-black text-slate-800 tracking-tight group-hover:text-green-600 transition-colors">
                                #<?= $o['kode_order'] ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 font-semibold text-slate-700">
                            <?= htmlspecialchars($o['nama']) ?>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-green-50 text-green-700 font-bold rounded-lg text-sm">
                                Rp<?= number_format($o['total'],0,',','.') ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 text-slate-500 font-medium italic">
                            <?= $o['metode_pembayaran'] ?>
                        </td>
                        <td class="px-8 py-5 text-slate-500 text-sm font-medium">
                            <?= date('d M Y', strtotime($o['created_at'])) ?>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="?page=order-detail&id=<?= $o['id'] ?>"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-green-600 transition-all shadow-sm">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (mysqli_num_rows($orders) == 0) : ?>
        <div class="p-20 text-center">
            <i data-lucide="inbox" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
            <p class="text-slate-400 font-medium">Belum ada transaksi masuk.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Jalankan ikon Lucide
    lucide.createIcons();
</script>
</body>
</html>