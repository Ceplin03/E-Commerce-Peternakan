<footer class="bg-white border-t border-slate-200 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="space-y-6">
                <div class="flex items-center gap-2 group cursor-pointer">
                    <div class="bg-green-600 p-2 rounded-xl">
                        <i data-lucide="egg" class="text-white w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">
                        Munti<span class="text-green-600">Eggs</span>
                    </span>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Menyediakan telur segar langsung dari peternakan Munti. Kami berkomitmen menjaga nutrisi terbaik untuk keluarga Anda.
                </p>
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/sepri_iratas03/?__pwa=1#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-green-600 hover:text-white transition-all shadow-sm">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-green-600 hover:text-white transition-all shadow-sm">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-green-600 hover:text-white transition-all shadow-sm">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-slate-900 mb-6">Menu Utama</h4>
                <ul class="space-y-4 text-sm font-medium text-slate-500">
                    <li><a href="?page=shop" class="hover:text-green-600 transition-colors">Beranda</a></li>
                    <li><a href="#produk" class="hover:text-green-600 transition-colors">Katalog Produk</a></li>
                    <li><a href="#" class="hover:text-green-600 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-green-600 transition-colors">Testimoni</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-slate-900 mb-6">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-green-600 shrink-0"></i>
                        <span class="text-sm text-slate-500">Munti, Nagari Kapalo Hilalang</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-green-600 shrink-0"></i>
                        <span class="text-sm text-slate-500">+62 812 7575 1928</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-green-600 shrink-0"></i>
                        <span class="text-sm text-slate-500">sepriiratas430@gmail.com</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-slate-900 mb-6">Berlangganan Promo</h4>
                <p class="text-sm text-slate-500 mb-4">Dapatkan info stok segar dan promo harga mingguan.</p>
                <form class="flex gap-2">
                    <input type="email" placeholder="Email Anda" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-green-600 transition-all">
                    <button class="bg-green-600 text-white p-3 rounded-xl hover:bg-green-700 transition-all">
                        <i data-lucide="send" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-xs font-medium">
            <p>© <?= date('Y') ?> MuntiEggs Farm. Sepri Iratas.</p>
            
        </div>
    </div>
</footer>

<script>
    lucide.createIcons();
</script>

</body>
</html>