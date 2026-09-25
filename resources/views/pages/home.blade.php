@extends('layouts.app')

@section('title', 'Dashboard Proporsi Pekerja Formal DKI Jakarta')

@section('content')

{{--
  ============================================================================
  SECTION 1 — PEMETAAN PROPORSI PEKERJA FORMAL (KECAMATAN)
  ============================================================================
--}}
<section id="peta-indeks" class="pt-16 pb-10 md:pt-24 md:pb-16 bg-[#ededed]">
  <div class="w-full mx-auto px-6 md:px-12">

    <h3 class="text-3xl font-bold mb-8 text-[#f9744b] text-center">
        PEMETAAN PROPORSI PEKERJA FORMAL DKI JAKARTA TAHUN 2025
    </h3>

    <div class="flex flex-col md:flex-row gap-5 mb-5 items-stretch">
      <div class="relative overflow-hidden bg-gradient-to-br from-white to-blue-50/50 border border-blue-100/70 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] py-8 px-6 flex flex-col items-center justify-center text-center md:w-[320px] shrink-0 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
        <svg class="absolute -bottom-4 -right-4 w-32 h-32 text-blue-500/5 rotate-12" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>

        <div class="text-6xl font-black text-[#124d54] tracking-tight relative z-10" id="stat-provinsi-value">–</div>
        
        <div class="text-sm font-bold text-slate-600 mt-2 uppercase tracking-wide relative z-10">Persentase Pekerja Formal</div>
        <div class="text-[16px] font-semibold text-slate-400 mb-3 relative z-10">Provinsi DKI Jakarta</div>
        
        <div class="text-[12px] text-slate-400 mt-2 border-t border-slate-100 pt-3 relative z-10 w-full">Publikasi Keadaan Angkatan Kerja Agustus 2025 <br> <span class="font-medium">(BPS Provinsi DKI Jakarta, 2025)</span></div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg p-5 flex-1 flex flex-col justify-center">
        <h5 class="text-sm font-bold text-[#124d54] mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f9744b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          RINGKASAN STATISTIK TENAGA KERJA DKI JAKARTA 2025
        </h5>
        
        <div id="stat-ringkasan-text" class="w-full flex flex-col lg:flex-row gap-4 items-stretch">
          <div class="w-full text-center py-4 text-sm text-gray-500 italic">Memuat agregat makro...</div>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-4">
      <div class="flex flex-col lg:flex-row gap-4 items-stretch">

        <div class="flex-1 flex flex-col gap-4">
          <div class="relative w-full z-0">
            <div id="map-indeks" class="w-full h-full min-h-[720px] rounded-xl shadow-inner border border-gray-100"></div>

            <button id="btn-refresh-peta"
              class="absolute top-4 right-4 z-[1000] bg-white border border-gray-300 text-gray-700 hover:bg-[#f9744b] hover:text-white hover:border-[#f9744b] font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Refresh Peta
            </button>
          </div>
        </div>

        <div class="w-full lg:w-[320px] flex flex-col gap-4">

          <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm h-fit">
            <h4 class="text-xl font-bold text-[#124d54] mb-5 text-center">
              PENCARIAN KECAMATAN
            </h4>

            <div class="mb-5">
              <label class="block text-sm font-semibold mb-2 text-gray-700">Pilih Kecamatan</label>
              <select id="filter-wilayah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#124d54]">
                <option value="">-- Memuat data... --</option>
              </select>
            </div>

            <button id="btn-cari-desa"
              class="w-full bg-[#f9744b] hover:opacity-90 text-white font-semibold py-3 rounded-xl transition duration-300 shadow-md">
              Cari Lokasi
            </button>

            <div class="bg-white rounded-xl p-4 shadow-sm mb-1 mt-8 border border-gray-200">
              <h5 class="font-bold text-[#124d54] mb-3">Legenda Kategori</h5>
              <div class="space-y-3 text-sm">
                <div class="flex items-center gap-3">
                  <span class="w-5 h-5 bg-[#55ff21] rounded"></span>
                  <span>Tinggi</span>
                </div>
                <div class="flex items-center gap-3">
                  <span class="w-5 h-5 bg-[#c8db1d] rounded"></span>
                  <span>Sedang</span>
                </div>
                <div class="flex items-center gap-3">
                  <span class="w-5 h-5 bg-[#ff3f3f] rounded"></span>
                  <span>Rendah</span>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm h-fit">
            <h4 class="text-base font-bold text-[#124d54] mb-3 text-center flex items-center justify-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f9744b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              METODE ESTIMASI
            </h4>
            <div class="text-xs text-gray-600 leading-relaxed p-3 bg-slate-50 border border-gray-100 rounded-xl space-y-2">
              <p class="font-semibold text-gray-800 mb-1">Small Area Estimation (SAE) Hierarchical Bayes-Beta</p>
              <p>Menggunakan pemodelan area kecil dengan pendekatan <i>Hierarchical Bayes</i> (HB) berdistribusi Beta, dengan <i>auxiliary variables</i> dari big data yaitu <strong>data citra satelit</strong> dan <strong>data lowongan kerja daring</strong>.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
      {{-- Bar Chart Kabkot --}}
      <div class="bg-white rounded-2xl shadow-lg p-5">
        <h5 class="text-sm font-bold text-[#124d54] mb-7">Persentase Pekerja Formal Menurut Kabupaten/Kota</h5>
        <canvas id="chart-bar-kabkota" height="280"></canvas>
        <div class="text-[11px] text-gray-400 mt-2">Publikasi Keadaan Angkatan Kerja Agustus 2025 <br> (BPS Provinsi DKI Jakarta, 2025)</div>
      </div>

      {{-- Donut Chart Kecamatan --}}
      <div class="bg-white rounded-2xl shadow-lg p-5">
        <h5 class="text-sm font-bold text-[#124d54] mb-7">Distribusi Kecamatan Berdasarkan Kategori Proporsi Pekerja Formal</h5>
        <canvas id="chart-donut-kecamatan" height="230"></canvas>
      </div>

      <div class="bg-white rounded-2xl shadow-lg p-5">
        <h5 class="text-sm font-bold text-[#124d54] mb-7">5 Kecamatan dengan Persentase Pekerja Formal Tertinggi dan Terendah</h5>
        <div class="grid grid-cols-1 gap-4">
          <div>
            <div class="text-xs font-bold text-green-700 mb-2 uppercase">Persentase Tertinggi</div>
            <ol id="list-top5" class="text-sm space-y-1.5"></ol>
          </div>
          <div class="mt-8">
            <div class="text-xs font-bold text-red-700 mb-2 uppercase">Persentase Terendah</div>
            <ol id="list-bottom5" class="text-sm space-y-1.5"></ol>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{--
  ============================================================================
  SECTION 2 — VISUALISASI VARIABEL PENYERTA 
  ============================================================================
--}}
<section id="variabel-penyerta" class="py-10 bg-white">
  <div class="w-full mx-auto px-6 md:px-12">

    <h3 class="text-3xl font-bold mb-8 text-[#f9744b] text-center">
      VARIABEL PENYERTA DALAM ESTIMASI PROPORSI PEKERJA FORMAL
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

      {{-- KIRI: Administratif & Podes --}}
      <div class="rounded-2xl overflow-hidden border-2 border-amber-700 shadow-md bg-amber-50">
        <div class="bg-amber-700 text-white px-5 py-3 flex items-center justify-between">
          <div class="font-bold text-sm flex items-center gap-2">
            <i class="ti ti-building text-lg"></i> DATA ADMINISTRATIF &amp; PODES
          </div>
          <span class="text-xs font-semibold bg-white text-amber-800 rounded-full px-2.5 py-0.5">6 variabel</span>
        </div>
        <ul class="p-4 space-y-2" id="list-var-admin"></ul>
      </div>

      {{-- KANAN: Big Data --}}
      <div class="rounded-2xl overflow-hidden border-2 border-sky-800 shadow-md bg-sky-50">
        <div class="bg-sky-800 text-white px-5 py-3 flex items-center justify-between">
          <div class="font-bold text-sm flex items-center gap-2">
            <i class="ti ti-satellite text-lg"></i> BIG DATA
          </div>
          <span class="text-xs font-semibold bg-white text-sky-900 rounded-full px-2.5 py-0.5">6 variabel</span>
        </div>
        <div class="p-4 space-y-4">
          <div>
            <div class="inline-block bg-sky-700 text-white text-[11px] font-bold rounded-md px-2.5 py-1 mb-2">
              CITRA SATELIT · 5 variabel
            </div>
            <ul class="space-y-2" id="list-var-satelit"></ul>
          </div>
          <div>
            <div class="inline-block bg-emerald-700 text-white text-[11px] font-bold rounded-md px-2.5 py-1 mb-2">
              LOWONGAN KERJA DARING · 1 variabel
            </div>
            <ul class="space-y-2" id="list-var-loker"></ul>
          </div>
          <div>
            <div class="inline-block bg-violet-700 text-white text-[11px] font-bold rounded-md px-2.5 py-1 mb-2">
              DATASET GEOSPASIAL (GRIP) · 1 variabel
            </div>
            <ul class="space-y-2" id="list-var-geo"></ul>
          </div>
        </div>
      </div>
    </div>

    {{-- Peta Choropleth Variabel Big Data (gradasi halus / kontinu) --}}
    <div class="bg-white rounded-2xl shadow-lg p-5 mb-8 border border-gray-100">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-4 border-b border-gray-100 pb-4">
        <div>
          <h5 class="text-base font-bold text-[#124d54]">Peta Sebaran Variabel Big Data per Kecamatan</h5>
        </div>
        <select id="select-map-bigdata-var" class="border border-gray-300 rounded-xl px-3 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#124d54] bg-gray-50 min-w-[260px] transition-all cursor-pointer">
          <!-- Options dimuat dari JS -->
        </select>
      </div>

      <div class="relative w-full z-0">
        <div id="map-varpenyerta" class="w-full h-full min-h-[480px] rounded-xl shadow-inner border border-gray-100"></div>

        <button id="btn-refresh-peta-bigdata"
          class="absolute top-4 right-4 z-[1000] bg-white border border-gray-300 text-gray-700 hover:bg-[#124d54] hover:text-white hover:border-[#124d54] font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          Refresh Peta
        </button>
      </div>

      <div class="flex flex-col sm:flex-row sm:items-center gap-3 mt-4 pt-4 border-t border-gray-100">
        <span id="legend-var-label-bigdata" class="text-xs font-semibold text-gray-600 shrink-0">-</span>
        <div class="flex items-center gap-2 flex-1 min-w-[200px]">
          <span class="text-[11px] text-gray-500 font-medium">Rendah</span>
          <div id="legend-gradient-bigdata" class="h-3 flex-1 rounded-full border border-gray-200"></div>
          <span class="text-[11px] text-gray-500 font-medium">Tinggi</span>
        </div>
      </div>
    </div>

    {{-- Top 5 & Bottom 5 jumlah lowongan kerja daring --}}
    <h4 class="text-lg font-bold text-[#124d54] mb-1">Jumlah Lowongan Kerja Daring per Kecamatan</h4>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-3">
      <div class="bg-white rounded-2xl shadow-lg p-5 border border-gray-100">
        <h5 class="text-sm font-bold text-emerald-700 mb-3">5 Kecamatan dengan Jumlah Tertinggi</h5>
        <div class="relative h-[260px]"><canvas id="chart-loker-top5"></canvas></div>
      </div>
      <div class="bg-white rounded-2xl shadow-lg p-5 border border-gray-100">
        <h5 class="text-sm font-bold text-red-700 mb-3">5 Kecamatan dengan Jumlah Terendah</h5>
        <div class="relative h-[260px]"><canvas id="chart-loker-bottom5"></canvas></div>
      </div>
    </div>
    <p class="text-xs text-gray-500 mb-8">*Pengumpulan Data Lowongan kerja dilakukan dengan <i>web scraping</i> laman glints dari Petengahan Desember 2025 hingga Awal Februari 2026</p>

    {{-- Histogram Variabel Penyerta --}}    
    <div class="flex justify-center mb-6">
      <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100 w-full max-w-5xl">
        
        <!-- Bagian Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4 border-b border-gray-100 pb-4">
          <div>
            <h5 class="text-base font-bold text-[#124d54]">Distribusi Nilai Variabel Penyerta</h5>
            <p class="text-xs text-gray-400 mt-1">Histogram sebaran data untuk 44 kecamatan</p>
          </div>
          <select id="select-hist-var" class="border border-gray-300 rounded-xl px-3 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#124d54] bg-gray-50 min-w-[220px] transition-all cursor-pointer">
            <!-- Options dimuat dari JS -->
          </select>
        </div>

        <!-- Bagian Konten: Grafik (Kiri) & Statistik (Kanan) -->
        <div class="flex flex-col lg:flex-row gap-8 items-center">
          
          <!-- Container Grafik (2/3 Lebar) -->
          <div class="w-full lg:w-2/3 relative h-[300px]">
            <canvas id="chart-hist-var"></canvas>
          </div>

          <!-- Container Statistik Deskriptif (1/3 Lebar) -->
          <div class="w-full lg:w-1/3 bg-[#f8fafc] rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h6 class="text-sm font-bold text-[#124d54] mb-5 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f9744b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              Statistik Deskriptif
            </h6>
            
            <!-- List Statistik -->
            <div class="space-y-4">
              <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                <span class="text-xs text-gray-500 font-medium">Rata-rata (Mean)</span>
                <span class="text-sm font-bold text-gray-800" id="stat-mean">-</span>
              </div>
              <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                <span class="text-xs text-gray-500 font-medium">Nilai Tengah (Median)</span>
                <span class="text-sm font-bold text-gray-800" id="stat-median">-</span>
              </div>
              <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                <span class="text-xs text-gray-500 font-medium">Nilai Tertinggi</span>
                <div class="text-right">
                    <span class="text-sm font-bold text-[#059669]" id="stat-max-val">-</span><br>
                    <span class="text-[10px] text-gray-500" id="stat-max-loc">Kecamatan -</span>
                </div>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500 font-medium">Nilai Terendah</span>
                <div class="text-right">
                    <span class="text-sm font-bold text-[#dc2626]" id="stat-min-val">-</span><br>
                    <span class="text-[10px] text-gray-500" id="stat-min-loc">Kecamatan -</span>
                </div>
              </div>
            </div>
            
            <!-- Elemen p lawas disembunyikan agar JS (jika belum diubah) tidak melempar error -->
            <p id="hist-summary-text" class="hidden"></p>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

{{--
  ============================================================================
  SECTION 3 — VISUALISASI RSE ESTIMASI
  ============================================================================
--}}
<section id="rse-indeks" class="py-10 bg-[#ededed]">
  <div class="w-full mx-auto px-6 md:px-12">

    <h3 class="text-3xl font-bold mb-8 text-[#f9744b] text-center">
      VISUALISASI RELATIVE STANDARD ERROR (RSE) ESTIMASI
    </h3>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <!-- Kolom Kiri: Boxplot -->
      <div class="bg-white rounded-2xl shadow-lg p-5 flex flex-col">
        <h5 class="text-sm font-bold text-[#124d54] mb-3">Distribusi Nilai RSE 44 Kecamatan</h5>
        <div class="relative h-[320px]"><canvas id="chart-boxplot-rse"></canvas></div>
        <p class="text-xs text-gray-500 mt-auto pt-3" id="rse-summary-text">Memuat ringkasan RSE…</p>
      </div>

      <!-- Kolom Kanan: Top 3 & Bottom 3 Bar Charts -->
      <div class="bg-white rounded-2xl shadow-lg p-5 flex flex-col gap-2">
        <div>
          <h5 class="text-sm font-bold text-emerald-700 mb-2">3 Kecamatan dengan RSE Terendah</h5>
          <div class="relative h-[150px]"><canvas id="chart-rse-top3"></canvas></div>
        </div>
        <div class="border-t border-gray-100 pt-4">
          <h5 class="text-sm font-bold text-red-700 mb-2">3 Kecamatan dengan RSE Tertinggi</h5>
          <div class="relative h-[150px]"><canvas id="chart-rse-bottom3"></canvas></div>
        </div>
      </div>
    </div>

  </div>
</section>

{{--
  ============================================================================
  SECTION 4 — TABEL PROPORSI PEKERJA FORMAL 3 LEVEL
  ============================================================================
--}}

<section id="tabel-indeks" class="py-10 bg-[#ededed]">
  <div class="w-full mx-auto px-6 md:px-12 bg-[#ededed]">

    <h3 id="judul-tabel" class="text-3xl font-bold mb-6 text-[#f9744b] text-center">
      TABEL PROPORSI PEKERJA FORMAL TINGKAT KECAMATAN DKI JAKARTA TAHUN 2025
    </h3>

    <div class="mb-5 flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex flex-wrap sm:flex-nowrap gap-2 bg-white p-2 rounded-xl border border-gray-200 shadow-sm w-full md:w-auto">
        <button id="tab-tabel-provinsi"
          class="w-full md:w-auto py-2 px-4 rounded-lg font-semibold text-sm transition-all duration-300 bg-transparent text-gray-500 hover:bg-[#124d54]/10 hover:text-[#124d54]">
          Tingkat Provinsi
        </button>
        <button id="tab-tabel-kabkota"
          class="w-full md:w-auto py-2 px-4 rounded-lg font-semibold text-sm transition-all duration-300 bg-transparent text-gray-500 hover:bg-[#124d54]/10 hover:text-[#124d54]">
          Kabupaten/Kota
        </button>
        <button id="tab-tabel-kecamatan"
          class="w-full md:w-auto py-2 px-4 rounded-lg font-semibold text-sm transition-all duration-300 bg-[#124d54] text-white shadow-md">
          Kecamatan
        </button>
      </div>

      <div class="w-full md:w-1/3">
        <input
          type="text"
          id="search-table"
          placeholder="Cari wilayah di tabel..."
          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#124d54]"
        >
      </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-[#124d54] text-white">
          <tr>
            <th class="px-4 py-3">Kabupaten/Kota</th>
            <th id="th-wilayah-dinamis" class="px-4 py-3">Kecamatan</th>
            <th class="px-4 py-3">Proporsi Pekerja Formal</th>
            <th id="th-rse" class="px-4 py-3">RSE (%)</th>
            <th class="px-4 py-3">Kategori Nilai Proporsi</th>
          </tr>
        </thead>
        <tbody id="table-body" class="divide-y divide-gray-200">
        </tbody>
      </table>

      <div class="flex justify-between items-center px-4 py-4 border-t">
        <div id="pagination-info" class="text-sm text-gray-600">
          Menampilkan 1-10 data
        </div>
        <div class="flex gap-2">
          <button id="prev-page"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg text-sm font-semibold">
            Prev
          </button>
          <button id="next-page"
            class="px-4 py-2 bg-blue-700 hover:bg-blue-900 text-white rounded-lg text-sm font-semibold">
            Next
          </button>
        </div>
      </div>

      <div class="flex gap-3 px-4 py-4 border-t">
        <button id="export-csv"
          class="px-4 py-2 bg-emerald-700 hover:bg-emerald-900 text-white rounded-lg text-sm font-semibold">
          Export CSV
        </button>
        <button id="export-excel"
          class="px-4 py-2 bg-emerald-700 hover:bg-emerald-900 text-white rounded-lg text-sm font-semibold">
          Export Excel
        </button>
      </div>

    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@sgratzl/chartjs-chart-boxplot@4.4.2/build/index.umd.min.js"></script>

<script>
function capitalizeFirstLetter(str) {
  if (!str) return '';
  return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
}

// ============================================================
// DEFINISI 12 VARIABEL PENYERTA (dipetakan dari Dataset.xlsx)
// ============================================================
const VARIABEL_PENYERTA = [
  { key: 'X1',  label: 'Usia Produktif',        desc: 'Proporsi penduduk usia 15–64 thn terhadap penduduk usia kerja', sumber: 'Disdukcapil DKI',  grup: 'admin' },
  { key: 'X2',  label: 'Jenis Kelamin',          desc: 'Proporsi penduduk perempuan usia kerja',                        sumber: 'Disdukcapil DKI',  grup: 'admin' },
  { key: 'X3',  label: 'Tingkat Pendidikan',     desc: 'Proporsi penduduk berpendidikan SMA ke atas',                   sumber: 'Disdukcapil DKI',  grup: 'admin' },
  { key: 'X4',  label: 'Status Perkawinan',      desc: 'Proporsi penduduk berstatus kawin',                             sumber: 'Disdukcapil DKI',  grup: 'admin' },
  { key: 'X5',  label: 'Infrastruktur Jalan',    desc: 'Panjang vektor jalan dibagi luas wilayah (Road Density)',        sumber: 'GRIP (GEE Community Catalog)', grup: 'geospasial' },
  { key: 'X6',  label: 'Fasilitas Ekonomi',      desc: 'Jumlah pertokoan, pasar, minimarket, restoran, dsb.',           sumber: 'Podes BPS',        grup: 'admin' },
  { key: 'X7',  label: 'Fasilitas Kredit',       desc: 'Jumlah bank dan koperasi',                                      sumber: 'Podes BPS',        grup: 'admin' },
  { key: 'X8',  label: 'Cahaya Malam (NTL)',     desc: 'Night-Time Lights',                                             sumber: 'VIIRS',            grup: 'satelit' },
  { key: 'X9',  label: 'Kepadatan Bangunan (NDBI)', desc: 'Normalized Difference Built-up Index',                       sumber: 'Sentinel-2A',      grup: 'satelit' },
  { key: 'X10', label: 'Kerapatan Vegetasi (NDVI)', desc: 'Normalized Difference Vegetation Index',                     sumber: 'Sentinel-2A',      grup: 'satelit' },
  { key: 'X11', label: 'Temperatur Wilayah (LST)', desc: 'Land Surface Temperature',                                    sumber: 'Landsat 8',        grup: 'satelit' },
  { key: 'X12', label: 'Lapangan Kerja',         desc: 'Proporsi lowongan kerja per kecamatan',                         sumber: 'Glints',           grup: 'loker' },
];
const GRUP_WARNA = { satelit: '#0284c7', loker: '#059669', admin: '#d97706', geospasial: '#7c3aed' };

// ============================================================
// VARIABEL BIG DATA UNTUK PETA CHOROPLETH GRADASI HALUS
// (X12 memakai Jumlah_Loker, bukan proporsi, karena yang tersedia
//  per-kecamatan dari big data adalah jumlah lowongan kerja daring)
// Tiap variabel punya skema warna (colors: rendah -> tinggi) yang
// disesuaikan dengan karakteristik aslinya, bukan warna generik grup.
// ============================================================
const BIGDATA_MAP_VARS = [
  {
    key: 'X5', field: 'X5',
    label: 'X5 · Infrastruktur Jalan (Road Density)',
    descLabel: 'Infrastruktur Jalan (Road Density)',
    colors: ['#f3f4f6', '#60a5fa', '#1e3a8a'] // abu terang -> biru -> biru tua (makin padat jalan)
  },
  {
    key: 'X8', field: 'X8',
    label: 'X8 · Cahaya Malam (NTL)',
    descLabel: 'Cahaya Malam (NTL)',
    colors: ['#0f172a', '#a855f7', '#fef08a'] // gelap (minim cahaya) -> ungu -> kuning terang (makin terang)
  },
  {
    key: 'X9', field: 'X9',
    label: 'X9 · Kepadatan Bangunan (NDBI)',
    descLabel: 'Kepadatan Bangunan (NDBI)',
    colors: ['#ecfccb', '#fb923c', '#7c2d12'] // hijau muda (lahan terbuka) -> oranye -> cokelat tua (makin terbangun)
  },
  {
    key: 'X10', field: 'X10',
    label: 'X10 · Kerapatan Vegetasi (NDVI)',
    descLabel: 'Kerapatan Vegetasi (NDVI)',
    colors: ['#fefce8', '#a3e635', '#14532d'] // kuning pucat (minim vegetasi) -> hijau -> hijau tua (makin rapat)
  },
  {
    key: 'X11', field: 'X11',
    label: 'X11 · Temperatur Wilayah (LST)',
    descLabel: 'Temperatur Wilayah (LST)',
    colors: ['#fef9c3', '#fb923c', '#7f1d1d'] // kuning pucat (sejuk) -> oranye -> merah tua (makin panas)
  },
{
    key: 'X12', field: 'X12', 
    label: 'X12 · Proporsi Lowongan Kerja Daring', 
    descLabel: 'Proporsi Lowongan Kerja Daring',
    colors: ['#ecfdf5', '#34d399', '#064e3b'] 
  },
];

function hexToRgb(hex) {
  const h = hex.replace('#', '');
  const bigint = parseInt(h, 16);
  return { r: (bigint >> 16) & 255, g: (bigint >> 8) & 255, b: bigint & 255 };
}
function rgbToHex({ r, g, b }) {
  const c = v => Math.round(Math.min(255, Math.max(0, v))).toString(16).padStart(2, '0');
  return `#${c(r)}${c(g)}${c(b)}`;
}
function lerpColor(hexA, hexB, t) {
  const a = hexToRgb(hexA), b = hexToRgb(hexB);
  return rgbToHex({ r: a.r + (b.r - a.r) * t, g: a.g + (b.g - a.g) * t, b: a.b + (b.b - a.b) * t });
}
function makeMultiStopColorScale(colors) {
  const n = colors.length - 1;
  return function (t) {
    t = Math.max(0, Math.min(1, Number(t) || 0));
    if (n <= 0) return colors[0];
    const scaled = t * n;
    const idx = Math.min(n - 1, Math.floor(scaled));
    const localT = scaled - idx;
    return lerpColor(colors[idx], colors[idx + 1], localT);
  };
}

// ============================================================
// PLUGIN LABEL NILAI CHART.JS (tanpa library tambahan)
// ============================================================
function barValueLabels(formatter) {
  return {
    id: 'barValueLabels',
    afterDatasetsDraw(chart) {
      const { ctx } = chart;
      const horizontal = chart.options.indexAxis === 'y';
      const meta = chart.getDatasetMeta(0);
      const dataset = chart.data.datasets[0].data;
      ctx.save();
      ctx.font = 'bold 11px sans-serif';
      ctx.fillStyle = '#124d54';
      ctx.textBaseline = 'middle';
      meta.data.forEach((bar, i) => {
        const val = dataset[i];
        if (val === null || val === undefined) return;
        if (horizontal) {
          ctx.textAlign = 'left';
          ctx.fillText(formatter(val), bar.x + 6, bar.y);
        } else {
          ctx.textAlign = 'center';
          ctx.fillText(formatter(val), bar.x, bar.y - 8);
        }
      });
      ctx.restore();
    }
  };
}

// Donut: "n kec." + persentase di tiap potongan.
const donutValueLabels = {
  id: 'donutValueLabels',
  afterDatasetsDraw(chart) {
    const { ctx } = chart;
    const meta = chart.getDatasetMeta(0);
    const data = chart.data.datasets[0].data;
    const total = data.reduce((a, b) => a + b, 0);
    if (!total) return;
    ctx.save();
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillStyle = '#111827';
    meta.data.forEach((arc, i) => {
      if (!data[i]) return;
      const { x, y } = arc.getCenterPoint();
      const pct = (data[i] / total * 100).toFixed(1).replace('.', ',');
      ctx.font = 'bold 13px sans-serif';
      ctx.fillText(`${data[i]} kecamatan`, x, y - 8);
      ctx.font = '12px sans-serif';
      ctx.fillText(`(${pct}%)`, x, y + 8);
    });
    ctx.restore();
  }
};

// Format angka generik (nilai < 1 pakai 4 desimal, lainnya 2 desimal)
function fmtNum(v) {
  const n = Number(v);
  if (isNaN(n)) return '-';
  return (Math.abs(n) < 1 ? n.toFixed(4) : n.toFixed(2)).replace('.', ',');
}

document.addEventListener('DOMContentLoaded', function () {

  // ============================
  // INISIALISASI PETA DASAR (KECAMATAN SAJA)
  // ============================
  const mapIndeks = L.map('map-indeks', {
      scrollWheelZoom: false
  }).setView([-6.2250, 106.8250], 12);

  let indeksLayer;

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mapIndeks);

  mapIndeks.on('click', function() {
    if (!mapIndeks.scrollWheelZoom.enabled()) mapIndeks.scrollWheelZoom.enable();
  });
  mapIndeks.on('mouseout', function() {
    mapIndeks.scrollWheelZoom.disable();
  });

  // ======================================
  // PATH GEOJSON & CACHE
  // ======================================
  const geojsonPaths = {
    'provinsi': '{{ asset("data/SHPValue_Provinsi.geojson") }}',
    'kabkota': '{{ asset("data/SHPValue_Kabkot.geojson") }}',
    'kecamatan': '{{ asset("data/SHPValue_Kecamatan.geojson") }}'
  };

  let currentTableLevel = 'kecamatan';
  const geojsonDataCache = {};

  async function fetchGeoJSON(level) {
    if (geojsonDataCache[level]) return geojsonDataCache[level];
    const res = await fetch(geojsonPaths[level]);
    if (!res.ok) throw new Error("File GeoJSON tidak dapat dijangkau");
    const data = await res.json();
    geojsonDataCache[level] = data;
    return data;
  }

  function getRegionName(feature, level) {
    if (!feature.properties) return '-';
    if (level === 'provinsi') return feature.properties.WADMPR || 'DKI Jakarta';
    if (level === 'kabkota') return feature.properties.WADMKK || feature.properties.NAMOBJ;
    return feature.properties.NAMOBJ;
  }

  function kategoriColorClass(kategori) {
    switch ((kategori || '').toLowerCase()) {
      case 'tinggi': return 'bg-[#55ff21]/20 text-green-800';
      case 'sedang': return 'bg-[#c8db1d]/30 text-yellow-800';
      case 'rendah': return 'bg-[#ff3f3f]/20 text-red-800';
      default: return 'bg-gray-100 text-gray-700';
    }
  }
  const KATEGORI_HEX = { tinggi: '#55ff21', sedang: '#c8db1d', rendah: '#ff3f3f' };

  // DOM refs — peta
  const filterWilayah = document.getElementById('filter-wilayah');
  const btnCari = document.getElementById('btn-cari-desa');
  const btnRefresh = document.getElementById('btn-refresh-peta');

  // DOM refs — tabel
  const judulTabel = document.getElementById('judul-tabel');
  const thWilayahDinamis = document.getElementById('th-wilayah-dinamis');
  const thRse = document.getElementById('th-rse');
  const tableBody = document.getElementById('table-body');
  const prevPageBtn = document.getElementById('prev-page');
  const nextPageBtn = document.getElementById('next-page');
  const paginationInfo = document.getElementById('pagination-info');
  const searchTable = document.getElementById('search-table');
  const exportCSVBtn = document.getElementById('export-csv');
  const exportExcelBtn = document.getElementById('export-excel');
  const tabProvinsi = document.getElementById('tab-tabel-provinsi');
  const tabKabKota = document.getElementById('tab-tabel-kabkota');
  const tabKecamatan = document.getElementById('tab-tabel-kecamatan');

  let currentPage = 1;
  const rowsPerPage = 10;
  let filteredTableData = [];
  let sortedTableFeatures = [];

  // ======================================
  // PETA CHOROPLETH KECAMATAN
  // ======================================
  async function loadMapKecamatan() {
    filterWilayah.innerHTML = '<option value="">-- Memuat data... --</option>';
    try {
      const data = await fetchGeoJSON('kecamatan');
      if (indeksLayer) mapIndeks.removeLayer(indeksLayer);

      indeksLayer = L.geoJSON(data, {
        style: function(feature) {
          const kategori = (feature.properties.Est_Cat || '').toLowerCase();
          return { color: '#ffffff', weight: 1, fillColor: KATEGORI_HEX[kategori] || '#9ca3af', fillOpacity: 0.8 };
        },
        onEachFeature: function(feature, layer) {
          const props = feature.properties;
          const regionName = getRegionName(feature, 'kecamatan');
          const popupValue = props.Estimasi_Benchmark ? Number(props.Estimasi_Benchmark).toFixed(4) : '-';
          const popupRse = props.RSE_Benchmark ? Number(props.RSE_Benchmark).toFixed(2) + '%' : '-';

          layer.bindPopup(`
            <div style="min-width:220px">
              <h3 style="font-weight:bold; font-size:15px; margin-bottom:8px; border-bottom:1px solid #eee; padding-bottom:4px;">
                Kecamatan ${regionName}
              </h3>
              <table style="width:100%; font-size:13px;">
                <tr><td style="padding-right:8px;"><b>Proporsi Pekerja Formal</b></td><td>: ${popupValue}</td></tr>
                <tr><td><b>RSE</b></td><td>: ${popupRse}</td></tr>
                <tr><td><b>Kategori</b></td><td>: <b>${props.Est_Cat || '-'}</b></td></tr>
              </table>
            </div>
          `);

          layer.on({
            mouseover: function(e) { e.target.setStyle({ weight: 3, color: '#000', fillOpacity: 1 }); },
            mouseout: function(e) { indeksLayer.resetStyle(e.target); }
          });
        }
      }).addTo(mapIndeks);

      const bounds = indeksLayer.getBounds();
      if (bounds.isValid()) mapIndeks.fitBounds(bounds, { padding: [20, 20], maxZoom: 14 });

      const daftarWilayah = [...new Set(data.features.map(f => getRegionName(f, 'kecamatan')))].sort();
      filterWilayah.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
      daftarWilayah.forEach(wilayah => {
        if (wilayah && wilayah !== '-') {
          const option = document.createElement('option');
          option.value = wilayah;
          option.textContent = wilayah;
          filterWilayah.appendChild(option);
        }
      });

      return data;
    } catch (err) {
      console.warn('[Peta] Gagal memuat visualisasi spasial kecamatan:', err);
      if (indeksLayer) mapIndeks.removeLayer(indeksLayer);
      filterWilayah.innerHTML = '<option value="">-- Data Belum Ada --</option>';
      alert('Peta tingkat Kecamatan gagal dieksekusi.');
      return null;
    }
  }

  // ======================================
  // PETA CHOROPLETH VARIABEL BIG DATA (GRADASI HALUS/KONTINU)
  // ======================================
  let mapVarBigData, layerVarBigData;

function initMapVarBigData(kecamatanData) {
    const elMap = document.getElementById('map-varpenyerta');
    const select = document.getElementById('select-map-bigdata-var');
    if (!elMap || !select) return;

    mapVarBigData = L.map('map-varpenyerta', { scrollWheelZoom: false }).setView([-6.2250, 106.8250], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapVarBigData);
    mapVarBigData.on('click', function () {
      if (!mapVarBigData.scrollWheelZoom.enabled()) mapVarBigData.scrollWheelZoom.enable();
    });
    mapVarBigData.on('mouseout', function () {
      mapVarBigData.scrollWheelZoom.disable();
    });

    select.innerHTML = BIGDATA_MAP_VARS.map(v => `<option value="${v.key}">${v.label}</option>`).join('');
    select.value = 'X12';
    select.addEventListener('change', () => renderMapVarBigData(kecamatanData, select.value));

    renderMapVarBigData(kecamatanData, select.value);

    const btnRefreshBigData = document.getElementById('btn-refresh-peta-bigdata');
    if (btnRefreshBigData) {
      btnRefreshBigData.addEventListener('click', function () {
        if (mapVarBigData) {
          mapVarBigData.closePopup(); 
          if (layerVarBigData) {
            const bounds = layerVarBigData.getBounds();
            if (bounds.isValid()) mapVarBigData.fitBounds(bounds, { padding: [20, 20], maxZoom: 13 });
          } else {
            mapVarBigData.setView([-6.2250, 106.8250], 11);
          }
        }
      });
    }
  }

  // Format nilai untuk popup: X12 (jumlah lowongan) tampil sebagai bilangan bulat,
  // variabel lain memakai format desimal standar (fmtNum).
  function fmtPopupVal(varDef, val) {
    if (isNaN(val)) return '-';
    return varDef.isInteger ? Math.round(val).toLocaleString('id-ID') : fmtNum(val);
  }

  function renderMapVarBigData(kecamatanData, key) {
    const varDef = BIGDATA_MAP_VARS.find(v => v.key === key);
    const legendLabel = document.getElementById('legend-var-label-bigdata');
    const legendGrad = document.getElementById('legend-gradient-bigdata');
    if (!varDef || !mapVarBigData) return;

    const scale = makeMultiStopColorScale(varDef.colors);

    const values = kecamatanData.features
      .map(f => Number(f.properties[varDef.field]))
      .filter(v => !isNaN(v));

    if (!values.length) {
      if (layerVarBigData) { mapVarBigData.removeLayer(layerVarBigData); layerVarBigData = null; }
      legendLabel.textContent = `${varDef.label} — data belum tersedia`;
      legendGrad.style.background = '#e5e7eb';
      return;
    }

    const min = Math.min(...values);
    const max = Math.max(...values);

    if (layerVarBigData) mapVarBigData.removeLayer(layerVarBigData);

    layerVarBigData = L.geoJSON(kecamatanData, {
      style: function (feature) {
        const val = Number(feature.properties[varDef.field]);
        const t = (isNaN(val) || max === min) ? 0 : (val - min) / (max - min);
        return {
          color: '#ffffff',
          weight: 1,
          fillColor: isNaN(val) ? '#e5e7eb' : scale(t),
          fillOpacity: 0.85
        };
      },
      onEachFeature: function (feature, layer) {
        const val = Number(feature.properties[varDef.field]);
        const regionName = getRegionName(feature, 'kecamatan'); // Ambil nama kecamatan
        
        // Template Pop-up yang baru dengan nama kecamatan
        layer.bindPopup(`
          <div style="min-width:200px">
            <h3 style="font-weight:bold; font-size:14px; margin-bottom:6px; border-bottom:1px solid #eee; padding-bottom:4px;">
              Kecamatan ${regionName}
            </h3>
            <div style="font-size:13px;">Nilai ${varDef.descLabel}: <b>${fmtPopupVal(varDef, val)}</b></div>
          </div>
        `);

        layer.on({
          mouseover: function (e) { e.target.setStyle({ weight: 3, color: '#000', fillOpacity: 1 }); },
          mouseout: function (e) { layerVarBigData.resetStyle(e.target); }
        });
      }
    }).addTo(mapVarBigData);

    const bounds = layerVarBigData.getBounds();
    if (bounds.isValid()) mapVarBigData.fitBounds(bounds, { padding: [20, 20], maxZoom: 13 });

    // Update legend gradasi, sinkron dengan skema warna variabel yang dipilih
    legendLabel.textContent = varDef.label;
    legendGrad.style.background = `linear-gradient(to right, ${varDef.colors.join(', ')})`;
  }

  btnCari.addEventListener('click', function () {
    const wilayahDipilih = filterWilayah.value;
    if (!wilayahDipilih) { alert('Silakan pilih wilayah terlebih dahulu.'); return; }
    if (!indeksLayer) return;

    indeksLayer.eachLayer(function(layer) {
      if (getRegionName(layer.feature, 'kecamatan') === wilayahDipilih) {
        mapIndeks.fitBounds(layer.getBounds(), { padding: [40, 40], maxZoom: 14 });
        layer.openPopup();
      }
    });
  });

  btnRefresh.addEventListener('click', function () {
    filterWilayah.value = '';
    mapIndeks.closePopup();
    mapIndeks.setView([-6.2250, 106.8250], 12);
  });

  // ============================================================
  // FUNGSI ANIMASI COUNTER UP 
  // ============================================================
  function animateCountUp() {
    const counters = document.querySelectorAll('.count-up');
    const duration = 2000; // Durasi animasi 2 detik

    counters.forEach(counter => {
      const target = parseInt(counter.getAttribute('data-target'), 10);
      if (isNaN(target)) return;

      const startTime = performance.now();
      
      function updateCount(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        
        // Easing Curve (Ease Out Quart) agar perlambatannya terasa natural
        const easeProgress = 1 - Math.pow(1 - progress, 4);
        const currentVal = Math.floor(easeProgress * target);

        // Render dengan format ribuan
        counter.innerText = currentVal.toLocaleString('id-ID');

        if (progress < 1) {
          requestAnimationFrame(updateCount);
        } else {
          // Angka akhir dipastikan tepat sasaran
          counter.innerText = target.toLocaleString('id-ID'); 
        }
      }
      
      requestAnimationFrame(updateCount);
    });
  }

  // ======================================
  // STATISTIK & CHART — SECTION 1
  // ======================================
  function renderRingkasanProvinsiKecamatan(provinsiData, kecamatanData) {
    const propsProv = provinsiData?.features?.[0]?.properties;
    
    // Perbaikan Bug %_Formal
    const provNilai = propsProv?.['%_Formal'];
    document.getElementById('stat-provinsi-value').textContent =
      provNilai ? (Number(provNilai) * 100).toFixed(2).replace('.', ',') + '%' : '-';

    // Ambil Data dari QGIS (Atau fallback hardcode jika belum ada)
    const valTot15 = propsProv?.['Tot_15+'] || 8430623; 
    const valTotKerja = propsProv?.['Tot_Kerja'] || 5128464;
    const valTotFormal = propsProv?.['Tot_Formal'] || 3249983;
    const valTotInform = propsProv?.['Tot_Infrml'] || 1878481;

    const cont = document.getElementById('stat-ringkasan-text');

    // HAPUS SEMUA ISI AWAL 
    cont.innerHTML = '';

    cont.innerHTML = `
      <!-- KOTAK KIRI: Populasi Dasar (Usia Kerja) -->
      <!-- Menggunakan gradien abu-abu ke biru sangat pucat, dengan shadow halus -->
      <div class="lg:w-1/3 w-full bg-gradient-to-br from-slate-50 to-blue-50/20 border border-slate-200/60 rounded-xl p-6 flex flex-col justify-center items-center text-center shadow-sm relative overflow-hidden h-full min-h-[140px] group">
        
        <span class="text-[14px] font-bold text-slate-500 uppercase tracking-wide mb-2 z-10">
          Penduduk Usia Kerja (15+)
        </span>
        
        <!-- Angka dengan efek drop-shadow tipis agar menonjol -->
        <span class="text-4xl font-black text-[#124d54] tracking-tighter drop-shadow-sm count-up z-10" data-target="${valTot15}">0</span>
        
        <span class="text-xs font-semibold py-0.5 px-2 bg-slate-200/50 text-slate-500 rounded-md mt-2 z-10">Jiwa</span>
      </div>

      <!-- KOTAK KANAN: Komposisi Pekerja (Bersarang) -->
      <div class="lg:w-2/3 w-full bg-white border border-slate-200/70 shadow-sm rounded-xl p-1.5 flex flex-col h-full justify-between relative">
        
        <!-- Header Total Bekerja (Parent) -->
        <div class="bg-gradient-to-r from-slate-50 to-white rounded-t-lg px-4 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 gap-1">
          <span class="text-[17px] font-bold text-slate-600 uppercase tracking-wide flex items-center gap-1.5">
             <div class="w-1.5 h-1.5 rounded-full bg-[#124d54]"></div>
             Total Penduduk Bekerja
          </span>
          <div class="flex items-baseline gap-1.5">
            <span class="text-3xl font-black text-slate-800 tracking-tighter drop-shadow-sm count-up" data-target="${valTotKerja}">0</span>
            <span class="text-[14px] font-bold text-slate-400 uppercase">Jiwa</span>
          </div>
        </div>
        
        <!-- Konten Rincian Formal/Informal (Children) -->
        <div class="bg-slate-50/50 rounded-b-lg p-2.5 flex flex-col sm:flex-row gap-3 h-full">
          
          <!-- Sektor Formal -->
          <!-- Menambahkan gradien dari putih ke hijau sangat pudar -->
          <div class="flex-1 bg-gradient-to-br from-white to-green-50/30 border border-green-100 rounded-lg p-3.5 flex flex-col justify-center border-t-[3px] border-t-green-500 shadow-[0_2px_10px_rgb(0,0,0,0.02)] relative overflow-hidden h-full transition-transform hover:-translate-y-0.5">
            <span class="text-[14px] font-bold text-green-700/80 uppercase tracking-wide mb-1 z-10">Pekerja Formal</span>
            <div class="flex items-baseline gap-1 z-10">
              <span class="text-2xl font-black text-green-700 tracking-tight count-up" data-target="${valTotFormal}">0</span>
            </div>
            
            <!-- Elemen dekoratif abstrak -->
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-green-500/5 rounded-full blur-xl"></div>
          </div>
          
          <!-- Sektor Informal -->
          <!-- Menambahkan gradien dari putih ke kuning sangat pudar -->
          <div class="flex-1 bg-gradient-to-br from-white to-amber-50/40 border border-amber-100 rounded-lg p-3.5 flex flex-col justify-center border-t-[3px] border-t-amber-400 shadow-[0_2px_10px_rgb(0,0,0,0.02)] relative overflow-hidden h-full transition-transform hover:-translate-y-0.5">
            <span class="text-[14px] font-bold text-amber-700/80 uppercase tracking-wide mb-1 z-10">Pekerja Informal</span>
            <div class="flex items-baseline gap-1 z-10">
              <span class="text-2xl font-black text-amber-600 tracking-tight count-up" data-target="${valTotInform}">0</span>
            </div>
            
            <!-- Elemen dekoratif abstrak -->
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-amber-400/10 rounded-full blur-xl"></div>
          </div>

        </div>
      </div>
    `;

    // Panggil fungsi animasi
    animateCountUp();
  }

  // Bar kab/kota — nilai proporsi di sebelah kanan tiap bar
  function renderBarKabkota(kabkotaData) {
    const rows = kabkotaData.features
      .map(f => ({
        nama: getRegionName(f, 'kabkota'),
        nilai: Number(f.properties['Proporsi P']) || 0,
        kategori: (f.properties.Cat_Prop || '').toLowerCase()
      }))
      .sort((a, b) => b.nilai - a.nilai);

    new Chart(document.getElementById('chart-bar-kabkota'), {
      type: 'bar',
      data: {
        labels: rows.map(r => r.nama),
        datasets: [{
          data: rows.map(r => r.nilai),
          backgroundColor: rows.map(r => KATEGORI_HEX[r.kategori] || '#9ca3af')
        }]
      },
      options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true, grace: '18%' } }
      },
      plugins: [barValueLabels(v => (Number(v)*100).toFixed(2).replace('.', ',')+ '%')]
    });
  }

  // Donut kecamatan — jumlah kecamatan + persentase di tiap potongan
  function renderDonutKecamatan(kecamatanData) {
    const counts = { Tinggi: 0, Sedang: 0, Rendah: 0 };
    kecamatanData.features.forEach(f => {
      const cat = capitalizeFirstLetter(f.properties.Est_Cat || '');
      if (counts[cat] !== undefined) counts[cat]++;
    });

    new Chart(document.getElementById('chart-donut-kecamatan'), {
      type: 'doughnut',
      data: {
        labels: Object.keys(counts),
        datasets: [{
          data: Object.values(counts),
          backgroundColor: [KATEGORI_HEX.tinggi, KATEGORI_HEX.sedang, KATEGORI_HEX.rendah]
        }]
      },
      options: { cutout: '45%', plugins: { legend: { position: 'bottom' } } },
      plugins: [donutValueLabels]
    });
  }

  function renderTopBottom5(kecamatanData) {
    const rows = kecamatanData.features
      .map(f => ({ nama: getRegionName(f, 'kecamatan'), nilai: Number(f.properties.Estimasi_Benchmark) }))
      .filter(r => !isNaN(r.nilai))
      .sort((a, b) => b.nilai - a.nilai);

    const fmt = v => (v * (v <= 1 ? 100 : 1)).toFixed(2).replace('.', ',') + '%';

    const top5 = rows.slice(0, 5);
    const bottom5 = rows.slice(-5).reverse();

    document.getElementById('list-top5').innerHTML = top5.map((r, i) =>
      `<li class="flex justify-between border-b border-gray-100 pb-1"><span>${i + 1}. ${r.nama}</span><b class="text-green-700">${fmt(r.nilai)}</b></li>`
    ).join('');

    document.getElementById('list-bottom5').innerHTML = bottom5.map((r, i) =>
      `<li class="flex justify-between border-b border-gray-100 pb-1"><span>${i + 1}. ${r.nama}</span><b class="text-red-700">${fmt(r.nilai)}</b></li>`
    ).join('');
  }

  // ======================================
  // SECTION 2 — VARIABEL PENYERTA
  // ======================================
  function renderKartuVariabel() {
    const kartu = (v, borderClass) =>
      `<li class="bg-white rounded-lg px-3 py-2 border border-gray-200 border-l-4 ${borderClass} shadow-sm">
         <div class="text-sm font-bold text-gray-900">${v.key} — ${v.label}</div>
         <div class="text-xs text-gray-700 mt-0.5">${v.desc}</div>
         <div class="text-[11px] text-gray-500 mt-0.5">Sumber: <i class="font-medium text-gray-700">${v.sumber}</i></div>
       </li>`;

    document.getElementById('list-var-admin').innerHTML =
      VARIABEL_PENYERTA.filter(v => v.grup === 'admin').map(v => kartu(v, 'border-l-amber-600')).join('');
    document.getElementById('list-var-satelit').innerHTML =
      VARIABEL_PENYERTA.filter(v => v.grup === 'satelit').map(v => kartu(v, 'border-l-sky-600')).join('');
    document.getElementById('list-var-geo').innerHTML =
      VARIABEL_PENYERTA.filter(v => v.grup === 'geospasial').map(v => kartu(v, 'border-l-violet-600')).join('');
    document.getElementById('list-var-loker').innerHTML =
      VARIABEL_PENYERTA.filter(v => v.grup === 'loker').map(v => kartu(v, 'border-l-emerald-600')).join('');
  }

  // Ambil nilai variabel per kecamatan (hanya yang valid)
  function getVals(kecamatanData, key) {
    const out = [];
    kecamatanData.features.forEach(f => {
      const raw = f.properties[key];
      if (raw === null || raw === undefined || raw === '') return;
      const x = Number(raw);
      if (!isNaN(x)) out.push({ nama: getRegionName(f, 'kecamatan'), v: x });
    });
    return out;
  }

  // Top 5 & Bottom 5 jumlah lowongan kerja daring 
  function renderLokerTopBottom(kecamatanData) {
    const rows = [];
    kecamatanData.features.forEach(f => {
      const raw = f.properties.Jumlah_Loker; 
      if (raw === null || raw === undefined || raw === '') return;
      const x = Number(raw);
      if (!isNaN(x)) {
        rows.push({ nama: getRegionName(f, 'kecamatan'), v: x });
      }
    });

    // Urutkan dari nilai tertinggi ke terendah
    rows.sort((a, b) => b.v - a.v);

    if (rows.length < 5) {
      ['chart-loker-top5', 'chart-loker-bottom5'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
          const wrap = el.parentElement;
          wrap.innerHTML = '<p class="text-xs text-gray-400 italic">Data field jumlah_loker belum tersedia di GeoJSON kecamatan.</p>';
        }
      });
      return;
    }

    const top5 = rows.slice(0, 5);
    const bottom5 = rows.slice(-5).reverse(); // Nilai terendah paling atas pada chart

    const buat = (id, data, warna) => new Chart(document.getElementById(id), {
      type: 'bar',
      data: {
        labels: data.map(r => r.nama),
        datasets: [{ data: data.map(r => r.v), backgroundColor: warna }]
      },
      options: {
        indexAxis: 'y',
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { 
            beginAtZero: true, 
            grace: '18%', 
            title: { display: true, text: 'Lowongan Kerja' },
            ticks: {
              // Memformat angka sumbu X dengan pemisah ribuan titik (contoh: 1.000)
              callback: function(value) {
                return Number(value).toLocaleString('id-ID');
              }
            }
          }
        }
      },
      // Menggunakan format angka ribuan untuk label batang bar chart
      plugins: [barValueLabels(v => Number(v).toLocaleString('id-ID'))]
    });

    buat('chart-loker-top5', top5, '#059669');
    buat('chart-loker-bottom5', bottom5, '#dc2626');
  }

// Histogram variabel terpilih
  let histChart;
  function renderHistogram(kecamatanData, key) {
    const v = VARIABEL_PENYERTA.find(x => x.key === key);
    const data = getVals(kecamatanData, key);
    
    // Hancurkan instance chart lama jika ada
    if (histChart) { histChart.destroy(); histChart = null; }

    if (data.length < 2) {
      console.warn(`Data ${key} belum tersedia di GeoJSON kecamatan.`);
      return;
    }

    // Kalkulasi Bins untuk Histogram
    const vals = data.map(d => d.v);
    const mn = Math.min(...vals), mx = Math.max(...vals);
    const bins = 8;
    const width = (mx - mn) / bins || 1;
    const counts = new Array(bins).fill(0);
    vals.forEach(x => counts[Math.min(bins - 1, Math.floor((x - mn) / width))]++);
    const labels = counts.map((_, i) => `${fmtNum(mn + i * width)} – ${fmtNum(mn + (i + 1) * width)}`);

    // Inisialisasi Chart Histogram Minimalis
    histChart = new Chart(document.getElementById('chart-hist-var'), {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          data: counts,
          backgroundColor: v ? GRUP_WARNA[v.grup] : '#124d54', // Mempertahankan warna sesuai grup
          borderRadius: 6, // Estetika: ujung bar agak membulat
          categoryPercentage: 1,
          barPercentage: 0.92
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { 
            grid: { display: false, drawBorder: false }, // Menghilangkan garis grid vertikal
            title: { 
              display: true, 
              text: v ? v.desc : key,
              color: '#6b7280',
              font: { size: 11, weight: 'bold' }
            }, 
            ticks: { 
              maxRotation: 0, // Mencegah teks label menjadi miring
              autoSkip: true, // Otomatis melompati label jika terlalu sempit
              maxTicksLimit: 6, // Membatasi jumlah label di sumbu X agar tidak terlalu rapat
              color: '#9ca3af',
              font: { size: 10 } 
            } 
          },
          y: { 
            beginAtZero: true, 
            grace: '12%', 
            grid: { color: '#f3f4f6', drawBorder: false }, // Garis grid horizontal lebih tipis/halus
            title: { 
              display: true, 
              text: 'Jumlah Kecamatan',
              color: '#6b7280',
              font: { size: 11 }
            },
            ticks: { 
              precision: 0, 
              stepSize: 2, 
              color: '#9ca3af',
              font: { size: 10 } 
            } 
          }
        }
      },
      plugins: [barValueLabels(v => v)]
    });

    // Kalkulasi Statistik Deskriptif
    const sorted = [...data].sort((a, b) => a.v - b.v);
    const rata2 = vals.reduce((a, b) => a + b, 0) / vals.length;
    const med = sorted.length % 2
      ? sorted[(sorted.length - 1) / 2].v
      : (sorted[sorted.length / 2 - 1].v + sorted[sorted.length / 2].v) / 2;
    
    // Injeksi Nilai ke Elemen HTML Baru
    document.getElementById('stat-mean').textContent = fmtNum(rata2);
    document.getElementById('stat-median').textContent = fmtNum(med);
    document.getElementById('stat-max-val').textContent = fmtNum(sorted[sorted.length - 1].v);
    document.getElementById('stat-max-loc').textContent = `Kecamatan ${sorted[sorted.length - 1].nama}`;
    document.getElementById('stat-min-val').textContent = fmtNum(sorted[0].v);
    document.getElementById('stat-min-loc').textContent = `Kecamatan ${sorted[0].nama}`;
  }

  // Inisialisasi Dropdown Histogram
  function initSelectHistogram(kecamatanData) {
    const select = document.getElementById('select-hist-var');
    select.innerHTML = VARIABEL_PENYERTA.map(v => `<option value="${v.key}">${v.key} · ${v.desc}</option>`).join('');
    select.value = 'X12'; // Default variabel yang ditampilkan pertama kali
    select.addEventListener('change', () => renderHistogram(kecamatanData, select.value));
    
    // Render grafik pertama kali
    renderHistogram(kecamatanData, select.value);
  }

  // ======================================
  // SECTION 3 — RSE
  // ======================================
  function renderRseSection(kecamatanData) {
    const rse = kecamatanData.features
      .map(f => Number(f.properties.RSE_Benchmark))
      .filter(v => !isNaN(v));

    if (!rse.length) {
      document.getElementById('rse-summary-text').textContent = 'Data RSE_Benchmark belum tersedia di GeoJSON kecamatan.';
      return;
    }

    const min = Math.min(...rse), max = Math.max(...rse);
    const rata2 = rse.reduce((a, b) => a + b, 0) / rse.length;
    document.getElementById('rse-summary-text').innerHTML =
      `RSE 44 kecamatan berkisar <b>${min.toFixed(2)}%</b> – <b>${max.toFixed(2)}%</b> (rata-rata <b>${rata2.toFixed(2)}%</b>), ` +
      `menunjukkan tingkat presisi estimasi yang konsisten baik di seluruh kecamatan.`;

    // 1. Boxplot tegak
    new Chart(document.getElementById('chart-boxplot-rse'), {
      type: 'boxplot',
      data: {
        labels: ['RSE (%)'],
        datasets: [{
          data: [rse],
          backgroundColor: 'rgba(249, 116, 75, 0.35)',
          borderColor: '#c2410c',
          borderWidth: 2,
          medianColor: '#124d54',
          meanBackgroundColor: '#124d54',
          meanBorderColor: '#124d54',
          itemRadius: 3,
          itemBackgroundColor: '#c2410c',
          barPercentage: 0.4,
          categoryPercentage: 0.5
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { 
          y: { 
            title: { display: true, text: 'RSE (%)' },
            min: 0.5, // Merubah rentang minimal Y-Axis
            max: 2.0  // Merubah rentang maksimal Y-Axis
          } 
        }
      }
    });

    // Urutkan data berdasarkan RSE
    const rows = kecamatanData.features
      .map(f => ({ nama: getRegionName(f, 'kecamatan'), rse: Number(f.properties.RSE_Benchmark) }))
      .filter(r => !isNaN(r.rse))
      .sort((a, b) => a.rse - b.rse); // RSE Terendah (Bagus) ke Tertinggi (Buruk)

    // Ambil Top 3 (Terendah) dan Bottom 3 (Tertinggi)
    const top3 = rows.slice(0, 3);
    const bottom3 = rows.slice(-3).reverse(); // Dibalik agar nilai paling buruk di urutan teratas pada chart-nya

    // Fungsi pembuat chart Bar untuk RSE
    const buatChartRSE = (id, data, warna) => new Chart(document.getElementById(id), {
      type: 'bar',
      data: {
        labels: data.map(r => r.nama),
        datasets: [{ data: data.map(r => r.rse), backgroundColor: warna }]
      },
      options: {
        indexAxis: 'y',
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { 
          x: { 
            beginAtZero: true, 
            grace: '15%',
            title: { display: true, text: 'RSE (%)' } 
          } 
        }
      },
      plugins: [barValueLabels(v => v.toFixed(2) + '%')]
    });

    // 2. Bar Chart Top 3 (Hijau)
    buatChartRSE('chart-rse-top3', top3, '#10b981');
    
    // 3. Bar Chart Bottom 3 (Merah)
    buatChartRSE('chart-rse-bottom3', bottom3, '#ef4444');
  }

  // ======================================
  // TABEL (3 LEVEL) — dengan kolom RSE untuk kecamatan
  // ======================================
  async function loadTableData(level) {
    currentTableLevel = level;

    const activeClass = ['bg-[#124d54]', 'text-white', 'shadow-md'];
    const inactiveClass = ['bg-transparent', 'text-gray-500', 'hover:bg-[#124d54]/10', 'hover:text-[#124d54]'];

    [tabProvinsi, tabKabKota, tabKecamatan].forEach(btn => {
      btn.classList.remove(...activeClass);
      btn.classList.add(...inactiveClass);
    });

    thRse.style.display = level === 'kecamatan' ? '' : 'none';

    if (level === 'provinsi') {
      tabProvinsi.classList.add(...activeClass); tabProvinsi.classList.remove(...inactiveClass);
      judulTabel.textContent = 'TABEL PROPORSI PEKERJA FORMAL TINGKAT PROVINSI DKI JAKARTA TAHUN 2025';
      thWilayahDinamis.textContent = 'Provinsi';
    } else if (level === 'kabkota') {
      tabKabKota.classList.add(...activeClass); tabKabKota.classList.remove(...inactiveClass);
      judulTabel.textContent = 'TABEL PROPORSI PEKERJA FORMAL TINGKAT KABUPATEN/KOTA DKI JAKARTA TAHUN 2025';
      thWilayahDinamis.textContent = 'Kabupaten/Kota';
    } else {
      tabKecamatan.classList.add(...activeClass); tabKecamatan.classList.remove(...inactiveClass);
      judulTabel.textContent = 'TABEL PROPORSI PEKERJA FORMAL TINGKAT KECAMATAN DKI JAKARTA TAHUN 2025';
      thWilayahDinamis.textContent = 'Kecamatan';
    }

    try {
      const data = await fetchGeoJSON(level);
      sortedTableFeatures = data.features.sort((a, b) => (getRegionName(a, level) || '').localeCompare(getRegionName(b, level) || ''));
      currentPage = 1;
      searchTable.value = '';
      renderTable(sortedTableFeatures);
    } catch (err) {
      console.warn(`[Tabel] Gagal merender data tabular tingkat ${level}:`, err);
      tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-500">Data tabular belum tersedia.</td></tr>';
      filteredTableData = [];
      sortedTableFeatures = [];
    }
  }

  function renderTable(features) {
    filteredTableData = features;
    tableBody.innerHTML = '';
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = filteredTableData.slice(start, end);

    paginatedItems.forEach(feature => {
      const props = feature.properties;
      let estimasiVal = '-', kategoriVal = '-', rseVal = '-', kabKotaVal = props.WADMKK || '-';
      const namaWilayahDinamic = getRegionName(feature, currentTableLevel);

      if (currentTableLevel === 'kecamatan') {
        estimasiVal = props.Estimasi_Benchmark ? Number(props.Estimasi_Benchmark).toFixed(4) : '-';
        kategoriVal = props.Est_Cat || '-';
        rseVal = props.RSE_Benchmark ? Number(props.RSE_Benchmark).toFixed(2) + '%' : '-';
      } else if (currentTableLevel === 'kabkota') {
        estimasiVal = props['Proporsi P'] ? Number(props['Proporsi P']).toFixed(4) : '-';
        kategoriVal = props.Cat_Prop || '-';
      } else if (currentTableLevel === 'provinsi') {
        estimasiVal = props['%_Formal'] ? Number(props['%_Formal']).toFixed(4) : '-';
        kategoriVal = '-';
        kabKotaVal = 'DKI Jakarta';
      }

      const rseCell = currentTableLevel === 'kecamatan' ? `<td class="px-4 py-3">${rseVal}</td>` : '';

      tableBody.innerHTML += `
        <tr class="hover:bg-blue-50 transition border-b border-gray-100">
          <td class="px-4 py-3">${kabKotaVal}</td>
          <td class="px-4 py-3 font-semibold">${namaWilayahDinamic}</td>
          <td class="px-4 py-3">${estimasiVal}</td>
          ${rseCell}
          <td class="px-4 py-3">
            <span class="px-3 py-1 rounded-full text-xs font-semibold ${kategoriColorClass(kategoriVal)}">
              ${kategoriVal}
            </span>
          </td>
        </tr>
      `;
    });

    paginationInfo.innerHTML = `Menampilkan ${filteredTableData.length > 0 ? start + 1 : 0} - ${Math.min(end, filteredTableData.length)} dari ${filteredTableData.length} data`;
    prevPageBtn.disabled = currentPage === 1;
    nextPageBtn.disabled = end >= filteredTableData.length;
    prevPageBtn.classList.toggle('opacity-50', currentPage === 1);
    nextPageBtn.classList.toggle('opacity-50', end >= filteredTableData.length);
  }

  tabProvinsi.addEventListener('click', () => loadTableData('provinsi'));
  tabKabKota.addEventListener('click', () => loadTableData('kabkota'));
  tabKecamatan.addEventListener('click', () => loadTableData('kecamatan'));

  searchTable.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    const filtered = sortedTableFeatures.filter(feature => {
      const props = feature.properties;
      const wilayahText = getRegionName(feature, currentTableLevel).toLowerCase();
      const kotaText = (props.WADMKK || '').toLowerCase();
      return wilayahText.includes(keyword) || kotaText.includes(keyword);
    });
    currentPage = 1;
    renderTable(filtered);
  });

  nextPageBtn.addEventListener('click', function () {
    if (currentPage * rowsPerPage < filteredTableData.length) { currentPage++; renderTable(filteredTableData); }
  });
  prevPageBtn.addEventListener('click', function () {
    if (currentPage > 1) { currentPage--; renderTable(filteredTableData); }
  });

  function getExportData(data) {
    return data.map(f => {
      const p = f.properties;
      let estimasiVal = '', kategoriVal = '', rseVal = '';
      if (currentTableLevel === 'kecamatan') {
        estimasiVal = p.Estimasi_Benchmark || ''; kategoriVal = p.Est_Cat || ''; rseVal = p.RSE_Benchmark || '';
      } else if (currentTableLevel === 'kabkota') {
        estimasiVal = p['Proporsi P'] || ''; kategoriVal = p.Cat_Prop || '';
      } else if (currentTableLevel === 'provinsi') {
        estimasiVal = p['%_Formal'] || ''; kategoriVal = '-';
      }

      const row = {
        "Kabupaten/Kota": p.WADMKK || (currentTableLevel === 'provinsi' ? 'DKI Jakarta' : ''),
        "Nama Wilayah": getRegionName(f, currentTableLevel),
        "Estimasi Proporsi": estimasiVal,
      };
      if (currentTableLevel === 'kecamatan') row["RSE (%)"] = rseVal;
      row["Kategori"] = kategoriVal;
      return row;
    });
  }

  exportCSVBtn.addEventListener('click', function () {
    let dataToExport = getExportData(filteredTableData.length ? filteredTableData : sortedTableFeatures);
    if (dataToExport.length === 0) return;
    let csv = [Object.keys(dataToExport[0])];
    dataToExport.forEach(row => csv.push(Object.values(row)));
    let csvContent = "data:text/csv;charset=utf-8," + csv.map(e => e.join(",")).join("\n");
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `Data_Estimasi_Tabel_${currentTableLevel}.csv`);
    document.body.appendChild(link); link.click(); document.body.removeChild(link);
  });

  exportExcelBtn.addEventListener('click', function () {
    let dataToExport = getExportData(filteredTableData.length ? filteredTableData : sortedTableFeatures);
    if (dataToExport.length === 0) return;
    if (typeof XLSX === 'undefined') { alert("Library Excel belum dimuat dengan sempurna."); return; }
    const ws = XLSX.utils.json_to_sheet(dataToExport);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Data Estimasi");
    XLSX.writeFile(wb, `Data_Estimasi_Tabel_${currentTableLevel}.xlsx`);
  });

  // ======================================
  // INISIALISASI DASBOR
  // ======================================
  (async function init() {
    renderKartuVariabel();

    const [kecamatanData] = await Promise.all([ loadMapKecamatan() ]);
    if (!kecamatanData) return;

    const [provinsiData, kabkotaData] = await Promise.all([
      fetchGeoJSON('provinsi').catch(() => null),
      fetchGeoJSON('kabkota').catch(() => null),
    ]);

    if (provinsiData) renderRingkasanProvinsiKecamatan(provinsiData, kecamatanData);
    if (kabkotaData) renderBarKabkota(kabkotaData);
    renderDonutKecamatan(kecamatanData);
    renderTopBottom5(kecamatanData);

    renderLokerTopBottom(kecamatanData);
    //renderBoxplotVariabel(kecamatanData);
    initSelectHistogram(kecamatanData);
    initMapVarBigData(kecamatanData);

    renderRseSection(kecamatanData);
  })();

  loadTableData('kecamatan');

});
</script>
@endpush