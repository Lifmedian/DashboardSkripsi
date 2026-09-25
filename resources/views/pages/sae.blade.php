@extends('layouts.app')

@section('title', 'Proses Estimasi SAE HB-Beta | Dashboard Pekerja Formal DKI Jakarta')

@section('content')

<style>
    html { scroll-behavior: smooth; }

    /* ── Sidebar nav active state (dikendalikan JS) ── */
    .nav-step.is-active .step-dot   { background-color: #f9744b; }
    .nav-step.is-active .step-num   { color: #f9744b; }
    .nav-step.is-active .step-label { color: #0d383d; font-weight: 700; }
    .nav-step.is-active             { border-left-color: #f9744b !important; }

    /* ── Tabel narasi ── */
    .narasi-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    .narasi-table th { background: #124d54; color: #fff; padding: 8px 12px; text-align: left; font-weight: 600; }
    .narasi-table td { padding: 7px 12px; border-bottom: 1px solid #e5e7eb; vertical-align: top; color: #374151; }
    .narasi-table tr:last-child td { border-bottom: none; }
    .narasi-table tr:hover td { background: #f8fafc; }

    /* ── Formula box ── */
    .formula-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 3px solid #124d54;
        border-radius: 10px;
        padding: 14px 18px;
        font-family: 'Georgia', serif;
        font-size: 0.9rem;
        color: #1e293b;
        line-height: 1.8;
    }

    /* ── Step connector line ── */
    .step-connector {
        position: absolute;
        left: 23px;
        top: 52px;
        width: 2px;
        background: linear-gradient(to bottom, #124d54, #e5e7eb);
        bottom: -16px;
        z-index: 0;
    }
</style>

{{-- ══════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════ --}}
<section class="pt-28 md:pt-36 pb-16 md:pb-20 bg-[#102937] text-white relative overflow-hidden w-full">
    <div class="absolute inset-0 opacity-[0.06]"
         style="background-image: radial-gradient(#f9744b 1px, transparent 1px); background-size: 20px 20px;"></div>
         
    <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-b from-transparent to-[#ededed] pointer-events-none z-0"></div>

    <div class="w-full px-6 md:px-12 lg:px-16 relative z-10 max-w-5xl">
        <span class="inline-block px-3 py-1 bg-[#f9744b] text-white text-[11px] font-bold uppercase tracking-widest rounded-md mb-3">
            Tahapan Estimasi Proporsi Pekerja Formal pada Penelitian
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight mb-4">
            Small Area Estimation<br>
            <span class="text-[#f9744b]">Hierarchical Bayes–Beta</span>
        </h1>
        <p class="text-[#a8c4c8] text-sm md:text-base max-w-2xl leading-relaxed">
            Empat tahap utama untuk menghasilkan estimasi proporsi pekerja formal yang andal,
            presisi, dan konsisten pada seluruh <strong class="text-white">44 kecamatan</strong> di Provinsi DKI Jakarta.
        </p>

        {{-- Ringkasan capaian penelitian ── 3 stat kecil --}}
        <div class="flex flex-wrap gap-4 mt-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 border border-white/10">
                <div class="text-2xl font-bold text-white">±87%</div>
                <div class="text-[11px] text-[#a8c4c8] mt-0.5">Penurunan rata-rata RSE dari RSE estimasi langsung</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 border border-white/10">
                <div class="text-2xl font-bold text-white">&lt;2%</div>
                <div class="text-[11px] text-[#a8c4c8] mt-0.5">RSE seluruh kecamatan hasil kedua model SAE</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 border border-white/10">
                <div class="text-2xl font-bold text-[#f9744b]">Big Data</div>
                <div class="text-[11px] text-[#a8c4c8] mt-0.5">Skenario Model Terbaik Penelitian</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     BODY: SIDEBAR + MAIN
══════════════════════════════════════════════════ --}}
<div class="bg-[#ededed] min-h-screen py-14 w-full">
    <div class="w-full px-6 md:px-12 lg:px-16 flex flex-col lg:flex-row gap-10">

        {{-- ─── SIDEBAR ─────────────────────────────── --++ --}}
        <aside class="w-full lg:w-[260px] shrink-0 lg:sticky lg:top-36 h-fit mb-10">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#124d54] flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f9744b] animate-pulse"></span>
                    Navigasi Alur Tahapan
                </p>
            </div>

            <nav id="sidebar-nav" class="space-y-1">
                @php
                $steps = [
                    ['id'=>'tahap-1','num'=>'01','label'=>'Estimasi Langsung','sub'=>'Data Sakernas Agustus 2025'],
                    ['id'=>'tahap-2','num'=>'02','label'=>'Seleksi Variabel Penyerta','sub'=>'Backward Elimination + AIC'],
                    ['id'=>'tahap-3','num'=>'03','label'=>'Pemodelan SAE HB-Beta','sub'=>'MCMC · Distribusi Beta'],
                    ['id'=>'tahap-4','num'=>'04','label'=>'Difference Benchmarking','sub'=>'Konsistensi Agregasi'],
                ];
                @endphp

                @foreach($steps as $s)
                <a href="#{{ $s['id'] }}"
                   class="nav-step group flex items-start gap-3 py-3 px-3 rounded-xl border border-transparent
                          -ml-1 transition-all duration-200 cursor-pointer hover:bg-white hover:border-gray-200 hover:shadow-sm
                          border-l-4 border-l-transparent"
                   data-target="{{ $s['id'] }}">
                    <div class="shrink-0 pt-0.5">
                        <span class="step-num text-[10px] font-black text-gray-300 block transition-colors">{{ $s['num'] }}</span>
                        <span class="step-dot w-2 h-2 rounded-full bg-gray-300 block mt-1 transition-colors mx-auto"></span>
                    </div>
                    <div>
                        <span class="step-label block text-sm font-semibold text-gray-500 group-hover:text-[#0d383d] transition-colors leading-tight">
                            {{ $s['label'] }}
                        </span>
                        <span class="block text-[11px] text-gray-400 mt-0.5">{{ $s['sub'] }}</span>
                    </div>
                </a>
                @endforeach
            </nav>

            <div class="mt-8 space-y-2.5">
                
                {{-- Kotak 1: Lokus & Unit Analisis --}}
                <div class="p-3 bg-white rounded-xl border border-gray-200/80 shadow-2xs text-[11px] text-gray-600 leading-relaxed">
                    <span class="font-bold text-[#124d54] block mb-0.5 uppercase tracking-wider text-[9px]">Lokus & Unit Analisis</span>
                    44 kecamatan yang tersebar di 5 kota 1 kabupaten administrasi DKI Jakarta
                </div>

                {{-- Kotak 2: Periode --}}
                <div class="p-3 bg-white rounded-xl border border-gray-200/80 shadow-2xs text-[11px] text-gray-600 leading-relaxed">
                    <span class="font-bold text-[#124d54] block mb-0.5 uppercase tracking-wider text-[9px]">Periode</span>
                    2025
                </div>

                {{-- Kotak 3: Sumber Data Utama --}}
                <div class="p-3 bg-white rounded-xl border border-gray-200/80 shadow-2xs text-[11px] text-gray-600 leading-relaxed">
                    <span class="font-bold text-[#124d54] block mb-0.5 uppercase tracking-wider text-[9px]">Sumber Data Utama</span>
                    Sakernas · Disdukcapil · Podes · Dataset GRIP · VIIRS · Sentinel-2A · Landsat 8 · Glints
                </div>
            </div>
        </aside>

        {{-- ─── MAIN CONTENT ────────────────────────── --}}
        <main class="flex-1 space-y-8 min-w-0">

            {{-- ══ TAHAP 1: ESTIMASI LANGSUNG ══════════════════════════ --}}
            <section id="tahap-1" class="scroll-mt-28 bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-200/80">

                {{-- Section header --}}
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-11 h-11 rounded-xl bg-[#102937] flex items-center justify-center text-white font-bold text-lg shrink-0">1</div>
                    <div>
                        <span class="text-[10px] font-bold text-[#f9744b] uppercase tracking-widest">Tahap Awal</span>
                        <h2 class="text-lg md:text-xl font-bold text-[#0d383d] leading-tight">Estimasi Langsung Proporsi Pekerja Formal</h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6">
                    Sebelum memasuki pemodelan SAE, dilakukan terlebih dahulu <strong>estimasi langsung</strong>
                    dari data sampel Sakernas Agustus 2025. Nilai ini menjadi variabel respons (<em>Y</em>)
                    sekaligus pembanding awal untuk mengevaluasi seberapa besar model SAE mampu meningkatkan presisi estimasi.
                    Penghitungan menggunakan rumus <em>weighted average</em> dengan <em>sampling weight</em> survei,
                    dibantu <em>package</em> <code class="bg-slate-100 px-1 rounded text-xs">survey</code> di R.
                </p>

                {{-- Formula --}}
                <div class="formula-box mb-6">
                    <div class="text-[15px] font-bold text-gray-400 uppercase tracking-wider mb-2">Estimasi Langsung Proporsi</div>
                    
                    <div class="text-lg md:text-xl overflow-x-auto py-2">
                        $$\hat{y}_i = \frac{\sum_{j=1}^{n_i} w_{ij} y_{ij}}{\sum_{j=1}^{n_i} w_{ij}} \quad (i = 1, 2, \dots, 44 \text{ kecamatan})$$
                    </div>
                </div>

                {{-- Temuan kunci --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 mb-6">
                    @php
                    $stats1 = [
                        ['val'=>'0,6433','label'=>'Rata-rata proporsi','note'=>'44 kecamatan','color'=>'text-[#124d54]'],
                        ['val'=>'8,39%','label'=>'RSE rata-rata','note'=>'Estimasi langsung','color'=>'text-[#f9744b]'],
                        ['val'=>'3,63%','label'=>'RSE terendah','note'=>'Kec. Cipayung','color'=>'text-green-600'],
                        ['val'=>'14,94%','label'=>'RSE tertinggi','note'=>'Kec. Pesanggrahan','color'=>'text-red-600'],
                    ];
                    @endphp
                    @foreach($stats1 as $s)
                    <div class="bg-slate-50 rounded-xl p-4 border border-gray-100">
                        <div class="text-xl font-bold {{ $s['color'] }}">{{ $s['val'] }}</div>
                        <div class="text-xs font-semibold text-gray-700 mt-1">{{ $s['label'] }}</div>
                        <div class="text-[11px] text-gray-400">{{ $s['note'] }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Insight box --}}
                <div class="bg-[#124d54]/5 border border-[#124d54]/10 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                    <span class="font-bold text-[#124d54]">Catatan : </span>
                    Meskipun seluruh 44 kecamatan memiliki RSE di bawah 25% (Layak Sesuai Standar Publikasi Statistik BPS), namun
                    terdapat ketimpangan presisi yang lebar dengan selisih lebih dari 10% antara kecamatan
                    dengan RSE terendah dan tertinggi. Kondisi ini tetap dapat menjadi dasar penerapan SAE yang bukan sekadar menurunkan
                    RSE absolut, tetapi untuk meratakan dan menstabilkan presisi estimasi di
                    seluruh kecamatan. Selain itu penerapan SAE sekaligus untuk menguji apakah variabel penyerta <i>big data</i> dapat memberi
                    nilai tambah di atas estimasi langsung yang sudah tergolong baik maupun skenario model SAE dengan variabel penyerta data administrasi di tahap berikutnya.
                </div>
            </section>

            {{-- ══ TAHAP 2: SELEKSI VARIABEL ═══════════════════════════ --}}
            <section id="tahap-2" class="scroll-mt-28 bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-200/80">

                <div class="flex items-start gap-4 mb-6">
                    <div class="w-11 h-11 rounded-xl bg-[#124d54] flex items-center justify-center text-white font-bold text-lg shrink-0">2</div>
                    <div>
                        <span class="text-[10px] font-bold text-[#f9744b] uppercase tracking-widest">Pra-Pemodelan</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#0d383d] leading-tight">Seleksi Variabel Penyerta</h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6">
                    Dari 12 kandidat variabel penyerta (6 dari data administrasi/Podes dan 6 dari <em>big data</em>) 
                    dilakukan seleksi terpisah untuk dua skenario model yang diusung menggunakan <strong>Backward Elimination berbasis AIC</strong>.
                    Transformasi logit pada variabel target [Logit(<em>Y</em>)] diterapkan untuk memenuhi asumsi
                    linearitas dan homoskedastisitas karena proses seleksi variabel menggunakan basis model linear.
                </p>

                {{-- 2 kolom skenario --}}
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mb-6">

                    {{-- Skenario 1: Data Administrasi --}}
                    <div class="rounded-2xl border-2 border-amber-600/30 bg-amber-50/50 overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-amber-700 text-white px-5 py-3">
                                <div class="text-xs font-bold uppercase tracking-wider">Skenario I</div>
                                <div class="font-bold text-sm mt-0.5">Variabel Penyerta Data Administrasi yang Lolos Seleksi</div>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- Kotak Catatan Eliminasi --}}
                                <div class="bg-white/80 rounded-xl p-3.5 border border-amber-200/60 shadow-2xs space-y-1.5 text-xs">
                                    <div class="font-bold text-amber-900 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-amber-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0 z"/></svg>
                                        Ringkasan Eliminasi Skenario I
                                    </div>
                                    <p class="text-gray-600 pl-5">
                                        Dilakukan <strong class="text-gray-800">3 tahap eliminasi</strong> dari 6 kandidat awal. Variabel yang <strong class="text-red-600">tereliminasi</strong> meliputi:
                                    </p>
                                    <ul class="list-disc list-inside pl-5 text-gray-600 space-y-0.5">
                                        <li><strong class="text-gray-700">X3</strong> (Proporsi penduduk berpendidikan SMA ke atas)</li>
                                        <li><strong class="text-gray-700">X4</strong> (Proporsi penduduk berstatus kawin)</li>
                                        <li><strong class="text-gray-700">X6</strong> (Jumlah pertokoan, pasar, minimarket, restoran, dsb.)</li>
                                    </ul>
                                </div>

                                @php
                                $vars_admin = [
                                    ['sym'=>'X1','name'=>'Proporsi Penduduk Usia Produktif'],
                                    ['sym'=>'X2','name'=>'Proporsi Perempuan Usia Kerja'],
                                    ['sym'=>'X7','name'=>'Jumlah Fasilitas Kredit'],
                                ];
                                @endphp
                                <div class="space-y-2.5">
                                    @foreach($vars_admin as $v)
                                    <div class="flex items-center gap-3 bg-white rounded-xl p-3.5 border border-amber-100 shadow-sm">
                                        <span class="w-8 h-8 rounded-lg bg-amber-700 text-white flex items-center justify-center text-[10px] font-black shrink-0">{{ $v['sym'] }}</span>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs font-semibold text-gray-800 leading-snug">{{ $v['name'] }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Metrik AIC & Adj R2 Skenario I --}}
                        <div class="px-5 py-3.5 bg-amber-100/60 border-t border-amber-200/70 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase font-bold text-amber-900 tracking-wider">AIC Akhir:</span>
                                <span class="px-2 py-0.5 bg-white text-amber-900 font-bold text-xs rounded-md shadow-2xs border border-amber-200">–106,03</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase font-bold text-amber-900 tracking-wider">Adj. R²:</span>
                                <span class="px-2 py-0.5 bg-white text-amber-900 font-bold text-xs rounded-md shadow-2xs border border-amber-200">0,2052</span>
                            </div>
                        </div>
                    </div>

                    {{-- Skenario 2: Big Data --}}
                    <div class="rounded-2xl border-2 border-sky-700/30 bg-sky-50/50 overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-sky-800 text-white px-5 py-3">
                                <div class="text-xs font-bold uppercase tracking-wider">Skenario II</div>
                                <div class="font-bold text-sm mt-0.5">Variabel Penyerta Big Data yang Lolos Seleksi</div>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- Kotak Catatan Eliminasi --}}
                                <div class="bg-white/80 rounded-xl p-3.5 border border-sky-200/60 shadow-2xs space-y-1.5 text-xs">
                                    <div class="font-bold text-sky-900 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-sky-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0 z"/></svg>
                                        Ringkasan Eliminasi Skenario II
                                    </div>
                                    <p class="text-gray-600 pl-5">
                                        Dilakukan <strong class="text-gray-800">2 tahap eliminasi</strong> dari 6 kandidat awal. Variabel yang <strong class="text-red-600">tereliminasi</strong> meliputi:
                                    </p>
                                    <ul class="list-disc list-inside pl-5 text-gray-600 space-y-0.5">
                                        <li><strong class="text-gray-700">X9</strong> (NDBI)</li>
                                        <li><strong class="text-gray-700">X10</strong> (NDVI)</li>
                                    </ul>
                                </div>

                                @php
                                $vars_bigdata = [
                                    ['sym'=>'X5','name'=>'Road Density (Infrastruktur Jalan)'],
                                    ['sym'=>'X8','name'=>'Night-Time Lights (NTL)'],
                                    ['sym'=>'X11','name'=>'Land Surface Temperature (LST)'],
                                    ['sym'=>'X12','name'=>'Proporsi Lowongan Kerja Daring'],
                                ];
                                @endphp
                                <div class="space-y-2.5">
                                    @foreach($vars_bigdata as $v)
                                    <div class="flex items-center gap-3 bg-white rounded-xl p-3.5 border border-sky-100 shadow-sm">
                                        <span class="w-8 h-8 rounded-lg bg-sky-800 text-white flex items-center justify-center text-[10px] font-black shrink-0">{{ $v['sym'] }}</span>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs font-semibold text-gray-800 leading-snug">{{ $v['name'] }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Metrik AIC & Adj R2 Skenario II --}}
                        <div class="px-5 py-3.5 bg-sky-100/60 border-t border-sky-200/70 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase font-bold text-sky-950 tracking-wider">AIC Akhir:</span>
                                <span class="px-2 py-0.5 bg-white text-sky-950 font-bold text-xs rounded-md shadow-2xs border border-sky-200">–98,16</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase font-bold text-sky-950 tracking-wider">Adj. R²:</span>
                                <span class="px-2 py-0.5 bg-white text-sky-950 font-bold text-xs rounded-md shadow-2xs border border-sky-200">0,0683</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#124d54]/5 border border-[#124d54]/10 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                    <span class="font-bold text-[#0d383d]">Catatan :</span>
                    Meski Adj. R² skenario data administrasi jauh lebih tinggi pada tahap seleksi linear ini,
                    hal tersebut belum menentukan performa akhir model SAE. Variabel <em>big data</em> dapat
                    menangkap variasi non-linear yang tidak tertangkap regresi linear. Tahap ini dilakukan hanya untuk menyingkirkan variabel yang jelas tidak signifikan, sehingga model SAE yang dibangun dapat lebih stabil dan efisien.
                </div>
            </section>

            {{-- ══ TAHAP 3: SAE HB-BETA ════════════════════════════════ --}}
            <section id="tahap-3" class="scroll-mt-28 bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-200/80">

                <div class="flex items-start gap-4 mb-6">
                    <div class="w-11 h-11 rounded-xl bg-[#124d54] flex items-center justify-center text-white font-bold text-lg shrink-0">3</div>
                    <div>
                        <span class="text-[10px] font-bold text-[#f9744b] uppercase tracking-widest">Inti Penelitian</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#0d383d] leading-tight">Pemodelan SAE Hierarchical Bayes–Beta</h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6">
                    Distribusi Beta dipilih karena variabel target berupa proporsi (0–1) yang bersifat non-normal.
                    Model SAE HB-Beta terdiri dari dua level hierarki — <strong>Sampling Model</strong> yang memodelkan
                    varians estimasi langsung, dan <strong>Linking Model</strong> yang menghubungkan parameter proporsi
                    dengan variabel penyerta via fungsi <em>link</em> logit. Estimasi parameter diperoleh dari
                    nilai <em>mean</em> distribusi posterior melalui simulasi MCMC.
                </p>

                {{-- Model hierarki --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="formula-box">
                        <div class="text-[12px] font-bold text-gray-400 tracking-widest mb-2">SAMPLING MODEL</div>
                        <div class="text-base md:text-lg py-1 overflow-x-auto">
                            $$\hat{y}_i \mid \theta_i \sim \text{Beta}(a_i, b_i)$$
                        </div>
                        <div class="text-xs text-gray-425 mt-2">
                            $$a_i = \frac{\hat{y}_i}{k}, \quad b_i = \frac{1 - \hat{y}_i}{k}$$
                        </div>
                    </div>
                    <div class="formula-box">
                        <div class="text-[12px] font-bold text-gray-400 tracking-widest mb-2">LINKING MODEL (logit)</div>
                        <div class="text-base md:text-lg py-1 overflow-x-auto">
                            $$\ln\left(\frac{y_i}{1 - y_i}\right) \mid \beta, \sigma^2_v \sim N(\mathbf{x}_i^T \boldsymbol{\beta}, \sigma^2_v)$$
                        </div>
                        <div class="text-xs text-gray-425 mt-2">
                            $$\sigma^2_v \sim \text{IG}(c_1, c_2)$$
                        </div>
                    </div>
                </div>

                {{-- Setting MCMC --}}
                <div class="bg-[#102937] text-white rounded-xl p-5 mb-6 text-xs font-mono leading-relaxed">
                    <div class="text-[#f9744b] font-bold mb-2 font-sans text-[10px] tracking-widest uppercase">Konfigurasi MCMC</div>
                    Total Iterasi    : 500.000<br>
                    Burn-in          : 30.000 (dibuang)<br>
                    Thinning Interval: 500<br>
                    Sampel Posterior : (500.000 − 30.000) ÷ 500 = <strong class="text-[#f9744b]">940 sampel</strong><br>
                    Iter Update      : 30× (stabilisasi hyperparameter)
                </div>

                {{-- Perbandingan 2 skenario SAE --}}
                <h3 class="text-sm font-bold text-[#0d383d] mb-3 uppercase tracking-wide">Perbandingan Hasil Dua Skenario Model</h3>
                <div class="overflow-x-auto rounded-xl border border-gray-200 mb-6">
                    <table class="narasi-table">
                        <thead>
                            <tr>
                                <th>Aspek</th>
                                <th>Skenario I — Administrasi</th>
                                <th>Skenario II — Big Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-medium">Variabel Terpilih</td>
                                <td>X1, X2, X7</td>
                                <td>X5, X8, X11, X12</td>
                            </tr>
                            <tr>
                                <td class="font-medium">Rentang Estimasi</td>
                                <td>0,5241 – 0,7986</td>
                                <td>0,5242 – 0,7996</td>
                            </tr>
                            <tr>
                                <td class="font-medium">Rata-rata Estimasi</td>
                                <td>0,6434</td>
                                <td>0,6433</td>
                            </tr>
                            <tr>
                                <td class="font-medium">Median RSE</td>
                                <td>1,24%</td>
                                <td class="font-bold text-sky-700">1,03% ✓</td>
                            </tr>
                            <tr>
                                <td class="font-medium">Rata-rata RSE</td>
                                <td>1,3%</td>
                                <td class="font-bold text-sky-700">1,1% ✓</td>
                            </tr>
                            <tr>
                                <td class="font-medium">IQR RSE</td>
                                <td>1,14% – 1,48%</td>
                                <td class="font-bold text-sky-700">0,92% – 1,19% ✓ (lebih sempit)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Koefisien model terbaik --}}
                <h3 class="text-sm font-bold text-[#0d383d] mb-3 uppercase tracking-wide">Koefisien Model Terpilih (Skenario Big Data)</h3>
                <div class="overflow-x-auto rounded-xl border border-gray-200 mb-6">
                    <table class="narasi-table">
                        <thead>
                            <tr>
                                <th>Variabel</th>
                                <th>Mean Posterior</th>
                                <th>SD</th>
                                <th>95% Credible Interval</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-medium">Intercept</td>
                                <td>−0,3804</td>
                                <td>0,0109</td>
                                <td>[−0,402 ; −0,360]</td>
                            </tr>
                            <tr>
                                <td class="font-medium">X5 Road Density</td>
                                <td>+0,0232</td>
                                <td>0,0008</td>
                                <td>[0,022 ; 0,025]</td>
                            </tr>
                            <tr>
                                <td class="font-medium">X8 NTL</td>
                                <td>−0,0123</td>
                                <td>0,0003</td>
                                <td>[−0,013 ; −0,012]</td>
                            </tr>
                            <tr>
                                <td class="font-medium">X11 LST</td>
                                <td>+0,0261</td>
                                <td>0,0003</td>
                                <td>[0,026 ; 0,027]</td>
                            </tr>
                            <tr>
                                <td class="font-medium">X12 Lowongan Kerja Daring</td>
                                <td>+3,2119</td>
                                <td>0,3103</td>
                                <td>[2,616 ; 3,808]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Interpretasi koefisien --}}
                <div class="space-y-3">
                    @php
                    $interps = [
                        ['var'=>'X5 (Road Density)','arah'=>'+','color'=>'border-l-green-500','interp'=>'Arah positif menunjukan di wilayah dengan jaringan jalan yang padat maka cenderung memiliki proporsi pekerja formal yang lebih tinggi. Hal ini karena kepadatan jaringan jalan mencerminkan infrastruktur publik yang mendorong perkembangan usaha/pekerjaan formal.'],
                        ['var'=>'X8 (NTL)','arah'=>'−','color'=>'border-l-orange-400','interp'=>'Arah negatif berarti semakin terang cahaya malam suatu wilayah justru cenderung kecil proporsi pekerja formal di wilayah tersebut. Hal ini mengindikasikan intensitas cahaya malam di DKI Jakarta banyak dikontribusi aktivitas permukiman padat dan ekonomi informal (pasar malam, usaha rumahan), bukan semata aktivitas pekerja formal.'],
                        ['var'=>'X11 (LST)','arah'=>'+','color'=>'border-l-green-500','interp'=>'Arah positif menunjukkan bahwa daerah dengan suhu permukaan tinggi cenderung memiliki proporsi pekerja formal yang tinggi juga. Hal ini disebabkan suhu permukaan tinggi berkaitan dengan kepadatan bangunan dan urbanisasi yang lebih intens, yang umumnya berasosiasi dengan konsentrasi ekonomi formal.'],
                        ['var'=>'X12 (Lowongan Kerja Daring)','arah'=>'+','color'=>'border-l-green-500','interp'=>'Koefisien terbesar (+3,21) menegaskan bahwa kecamatan dengan intensitas lowongan kerja formal daring lebih tinggi memiliki proporsi pekerja formal yang signifikan lebih besar. Sehingga konsisten dengan karakteristik perekrutan sektor formal yang dominan menggunakan platform daring saat ini.'],
                    ];
                    @endphp
                    @foreach($interps as $it)
                    <div class="pl-4 border-l-[3px] {{ $it['color'] }} bg-slate-50/80 rounded-r-xl py-3 pr-4">
                        <div class="text-xs font-bold text-gray-700 mb-0.5">
                            {{ $it['var'] }}
                            <span class="ml-2 text-[10px] font-normal px-1.5 py-0.5 rounded
                                {{ $it['arah'] === '+' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                Arah {{ $it['arah'] }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">{{ $it['interp'] }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 bg-sky-50 border border-sky-200 rounded-xl p-4 flex items-start gap-3">
                    <svg class="h-5 w-5 text-sky-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-sky-800">
                        <strong>Model Terpilih: Skenario Big Data (X5, X8, X11, X12).</strong>
                        Dibandingkan dengan skenario model data administrasi, median dan rata-rata RSE seluruh kecamatan <strong>lebih rendah</strong>, IQR RSE <strong>lebih sempit</strong> sehingga konsistensi presisi
                        antarkecamatan lebih baik. Selain itu seluruh RSE berada <strong>jauh di bawah ambang 25%</strong> serta menunjukkan performa 
                        penurunan rata-rata RSE sekitar <strong>±87%</strong> terhadap RSE estimasi langsung.
                    </div>
                </div>
            </section>

            {{-- ══ TAHAP 4: BENCHMARKING ═══════════════════════════════ --}}
            <section id="tahap-4" class="scroll-mt-28 bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-200/80">

                <div class="flex items-start gap-4 mb-6">
                    <div class="w-11 h-11 rounded-xl bg-[#124d54] flex items-center justify-center text-white font-bold text-lg shrink-0">4</div>
                    <div>
                        <span class="text-[10px] font-bold text-[#f9744b] uppercase tracking-widest">Konsistensi Dengan Publikasi Resmi</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#0d383d] leading-tight">Difference Benchmarking</h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6">
                    Estimasi hasil pemodelan area kecil(SAE) secara alami tidak mengakomodasi sifat <em>benchmarking</em>.
                    Agregasi hasil estimasi kecamatan ini belum tentu konsisten dengan angka statistik publikasi resmi BPS di tingkat wilayah yang lebih luas. 
                    Untuk menjaga konsistensi produk statistik di wilayah berbeda sesuai prinsip ke-8 FPOS PBB, dilakukan koreksi melalui metode <strong>Difference Benchmarking</strong> dengan menambahkan faktor koreksi α pada tiap kecamatan.
                </p>

                {{-- Formula benchmarking --}}
                <div class="formula-box mb-6">
                    <div class="text-[15px] font-bold text-gray-400 tracking-widest mb-3">DIFFERENCE BENCHMARKING</div>
                    <div class="space-y-3">
                        <div class="text-base md:text-lg overflow-x-auto py-1">
                            $$\hat{\theta}_i^{DB} = \hat{\theta}_i^H + \alpha$$
                        </div>
                        <div class="text-base md:text-lg overflow-x-auto py-1">
                            $$\alpha = \sum W_i \hat{y}_i - \sum W_i \hat{\theta}_i^H$$
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            $W_i =$ bobot populasi pekerja kecamatan ke-$i$ yang dinormalisasi terhadap total kabupaten/kotanya
                        </div>
                    </div>
                </div>

                {{-- Tabel koreksi per kab/kota --}}
                <h3 class="text-sm font-bold text-[#0d383d] mb-3 uppercase tracking-wide">Faktor Koreksi (α) per Kabupaten/Kota</h3>
                <div class="overflow-x-auto rounded-xl border border-gray-200 mb-6">
                    <table class="narasi-table">
                        <thead>
                            <tr>
                                <th>Kabupaten/Kota</th>
                                <th>Agregat SAE (sebelum)</th>
                                <th>Publikasi BPS</th>
                                <th>α (faktor koreksi)</th>
                                <th>Selisih Relatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $bench = [
                                ['kab'=>'Kab. Kepulauan Seribu','sae'=>'0,5726','bps'=>'0,5345','alpha'=>'−0,0380','pct'=>'7,12%','class'=>'text-red-600'],
                                ['kab'=>'Kota Jakarta Selatan','sae'=>'0,6534','bps'=>'0,6285','alpha'=>'−0,0249','pct'=>'3,96%','class'=>'text-orange-500'],
                                ['kab'=>'Kota Jakarta Timur','sae'=>'0,6588','bps'=>'0,6349','alpha'=>'−0,0239','pct'=>'3,77%','class'=>'text-orange-500'],
                                ['kab'=>'Kota Jakarta Utara','sae'=>'0,6467','bps'=>'0,6211','alpha'=>'−0,0256','pct'=>'4,12%','class'=>'text-orange-500'],
                                ['kab'=>'Kota Jakarta Barat','sae'=>'0,6760','bps'=>'0,6576','alpha'=>'−0,0184','pct'=>'2,80%','class'=>'text-yellow-600'],
                                ['kab'=>'Kota Jakarta Pusat','sae'=>'0,6246','bps'=>'0,6119','alpha'=>'−0,0127','pct'=>'2,08%','class'=>'text-yellow-600'],
                            ];
                            @endphp
                            @foreach($bench as $b)
                            <tr>
                                <td class="font-medium">{{ $b['kab'] }}</td>
                                <td>{{ $b['sae'] }}</td>
                                <td>{{ $b['bps'] }}</td>
                                <td class="font-bold {{ $b['class'] }}">{{ $b['alpha'] }}</td>
                                <td class="{{ $b['class'] }}">{{ $b['pct'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Trade-off RSE --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6 items-center">
                    {{-- Kartu 1: Sebelum --}}
                    <div class="md:col-span-5 bg-slate-50 rounded-2xl p-5 border border-gray-200/80 text-center shadow-2xs">
                        <div class="text-xs font-medium text-gray-500 mb-1">Median RSE Sebelum Benchmarking</div>
                        <div class="text-2xl font-extrabold text-sky-700">1,03%</div>
                    </div>

                    <div class="md:col-span-2 flex flex-col items-center justify-center py-2 md:py-0">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#124d54] to-[#102937] text-white flex items-center justify-center shadow-md shadow-[#124d54]/20 border border-white/20 transform hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6 text-[#f9744b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-[#124d54] uppercase tracking-wider mt-1.5 bg-white/80 px-2 py-0.5 rounded-full border border-gray-200/60 shadow-2xs">
                            +0,03%
                        </span>
                    </div>

                    {{-- Kartu 2: Sesudah --}}
                    <div class="md:col-span-5 bg-slate-50 rounded-2xl p-5 border border-gray-200/80 text-center shadow-2xs">
                        <div class="text-xs font-medium text-gray-500 mb-1">Median RSE Sesudah Benchmarking</div>
                        <div class="text-2xl font-extrabold text-[#124d54]">1,06%</div>
                    </div>
                </div>

                {{-- Insight benchmarking --}}
                <div class="space-y-3">
                    <div class="bg-[#124d54]/5 border border-[#124d54]/10 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                        <span class="font-bold text-[#124d54]">Catatan Hasil Benchmarking : </span>
                        Setelah α diterapkan, selisih antara agregat estimasi kecamatan dengan publikasi resmi BPS
                        menjadi nol di seluruh 6 kabupaten/kota. Tujuan penelitian ketiga terpenuhi.
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                        <span class="font-bold text-amber-700">Catatan Trade-Off RSE:</span>
                        Kenaikan median RSE hanya sebesar 0,03 persen (1,03% → 1,06%). Sehingga tetap dapat ditoleransi untuk publikasi resmi.
                        Di sisi lain, Kenaikan RSE terbesar terjadi pada kecamatan di Kepulauan Seribu, proporsional dengan nilai koreksinya yang paling besar (−0,0380). 
                        Hal ini menunjukkan bahwa proses <em>benchmarking</em> membawa
                        trade-off presisi namun tetap dalam batas toleransi publikasi resmi.
                    </div>

                    <div class="bg-[#124d54]/5 border border-[#124d54]/10 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                        <span class="font-bold text-[#0d383d]">Catatan Overestimasi : </span>
                        Seluruh 6 kabupaten/kota menunjukkan hasil agregat dari estimasi SAE yang lebih tinggi dari publikasi BPS,
                        sehingga mengindikasikan kecenderungan <em>overestimation</em> pada model. Hal ini diduga menunjukkan adanya ketimpangan
                        sampel Sakernas di kecamatan tertentu yang lebih terbatas dibanding kabupaten/kota lain, sehingga
                        membuat model lebih bergantung pada informasi dari variabel penyerta yang cenderung merepresentasikan proporsi pekerja formal yang lebih tinggi.
                    </div>
                </div>
            </section>

                {{-- Produk akhir --}}
                <div class="mt-6 bg-[#102937] text-white rounded-xl p-5 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-[#f9744b]/20 border border-[#f9744b]/30 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 text-[#f9744b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-white mb-1">Produk Estimasi Akhir Penelitian</div>
                        <p class="text-sm text-[#a8c4c8] leading-relaxed">
                            Estimasi proporsi pekerja formal di 44 kecamatan DKI Jakarta 2025 hasil pemodelan SAE HB-Beta dengan skenario variabel penyerta
                            <em>big data</em> yang telah melewati <em>difference benchmarking</em> ditetapkan sebagai produk akhir penelitian ini.
                            Dimana estimasi ini memiliki median RSE 1,06%, dan telah konsisten terhadap publikasi resmi BPS tingkat kabupaten/kota.
                        </p>
                    </div>
                </div>
        </main>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sections  = document.querySelectorAll('section[id^="tahap-"]');
    const navLinks  = document.querySelectorAll('.nav-step');

    // ── Sidebar active state on scroll ──────────────
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const id = entry.target.id;
            navLinks.forEach(link => {
                link.classList.toggle('is-active', link.dataset.target === id);
            });
        });
    }, { rootMargin: '-25% 0px -65% 0px' });

    sections.forEach(s => observer.observe(s));

    // ── Smooth click on nav links ────────────────────
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.getElementById(this.dataset.target);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});
</script>
@endpush