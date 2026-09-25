<header class="bg-[#124d54] fixed top-0 left-0 w-full h-20 z-30 shadow-md flex items-center justify-between px-6 transition-all duration-300">
  
  <h1 class="text-xl md:text-3xl font-bold text-white pl-5 truncate">
    DASHBOARD VISUALISASI KONDISI PEKERJA FORMAL DKI JAKARTA 2025
  </h1>

  <button id="menu-btn" class="text-white focus:outline-none hover:text-[#f9744b] transition flex items-center gap-2 md:hidden">
    <span class="hidden md:inline font-semibold text-sm">MENU</span>
    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

</header>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity duration-300 opacity-0"></div>

<div id="sub-header" class="fixed top-0 md:top-20 left-0 w-64 md:w-full h-full md:h-auto bg-[#0d383d] z-50 md:z-20 shadow-lg transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
  
  <div class="flex justify-end p-4 md:hidden">
    <button id="close-sidebar" class="text-white hover:text-[#f9744b] transition">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>

  <nav class="flex flex-col md:flex-row items-start md:items-center md:justify-center gap-2 md:gap-8 py-4 px-6 md:py-4">
    
    <a href="{{ route('home') }}" 
       class="block w-full md:w-auto text-left text-white font-semibold py-2.5 md:py-0 transition duration-200 hover:text-[#f9744b] 
       {{ request()->routeIs('home') ? 'text-[#f9744b] border-l-4 border-[#f9744b] pl-3 md:border-l-0 md:border-b-2 md:border-[#f9744b] md:pl-0' : '' }}">
       Beranda
    </a>

    <a href="{{ route('sae') }}" 
       class="block w-full md:w-auto text-left text-white font-semibold py-2.5 md:py-0 transition duration-200 hover:text-[#f9744b] 
       {{ request()->routeIs('sae') ? 'text-[#f9744b] border-l-4 border-[#f9744b] pl-3 md:border-l-0 md:border-b-2 md:border-[#f9744b] md:pl-0' : '' }}">
       Proses Estimasi SAE
    </a>
  </nav>
</div>

<script>
  const menuBtn = document.getElementById('menu-btn');
  const closeSidebarBtn = document.getElementById('close-sidebar');
  const subHeader = document.getElementById('sub-header');
  const overlay = document.getElementById('sidebar-overlay');

  // Fungsi Toggle Menu (Kini Hanya untuk Mobile)
  function toggleMenu() {
    if (window.innerWidth < 768) {
      // LOGIKA MOBILE: Slide dari kiri (-translate-x-full)
      const isClosed = subHeader.classList.contains('-translate-x-full');
      if (isClosed) {
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.remove('opacity-0'), 10);
        subHeader.classList.remove('-translate-x-full');
      } else {
        closeMobileSidebar();
      }
    }
    // Logika desktop (else) dihapus karena menu selalu terbuka
  }

  // Fungsi Menutup Mobile Sidebar
  function closeMobileSidebar() {
    subHeader.classList.add('-translate-x-full');
    overlay.classList.add('opacity-0');
    setTimeout(() => overlay.classList.add('hidden'), 300); // Menunggu transisi selesai
  }

  // Event Listeners
  menuBtn.addEventListener('click', toggleMenu);
  closeSidebarBtn.addEventListener('click', closeMobileSidebar);
  overlay.addEventListener('click', closeMobileSidebar);

  // Mengantisipasi perubahan ukuran window dari mobile ke desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
      // Pastikan sidebar kembali ke state desktop (tidak ada kelas translate yang disembunyikan untuk X)
      subHeader.classList.remove('-translate-x-full');
      overlay.classList.add('hidden', 'opacity-0');
    } else {
      // Pastikan kembali tertutup jika di-resize ke ukuran mobile
      subHeader.classList.add('-translate-x-full');
    }
  });
</script>