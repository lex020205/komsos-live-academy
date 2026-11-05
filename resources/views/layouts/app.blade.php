<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Komsos Live Academy - Panduan & Pelatihan Kru AV Gereja</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body class="bg-surface font-body text-on-surface min-h-screen flex flex-col justify-between selection:bg-secondary-container selection:text-secondary">

    <!-- ================= TOP FIXED HEADER ================= -->
    <header class="fixed top-0 left-0 w-full z-50 bg-surface-container-lowest/95 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-outline-variant/30">
        <!-- Row 1: Brand & Search & User Info -->
        <div class="h-16 lg:h-20 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none">
                <img alt="Logo Komsos" class="h-8 lg:h-9 w-auto object-contain transition-transform group-hover:scale-105" src="https://lh3.googleusercontent.com/aida/AEtjO1VNjHskc7mJcXkjbKCEt0lo8hzQ8pb-wN6ewbUEVAiNMdCHM8buur-7npBOG0FIXoiEOnTW3r0D4r_ePp6G1VnDWHmnZkpBxwvwGyhyUqqgX67Ut0tKeGytz9-GpYfu_8aw84vJbpVlaEw9KkfywD1AgMpsrgonY5ipMPJaypvbdNTCOMTYdhUfYVAs4JSgXU51jkJ-tmOW8IpO_Z6GC-RGtRpF5PC7CaJH5bjgw6JUqOUREgtYF6Nnhg" />
                <div class="flex flex-col">
                    <span class="font-headline font-bold text-lg lg:text-xl text-primary tracking-tight">Komsos Live Academy</span>
                    <span class="text-xs text-on-surface-variant hidden sm:inline font-medium">Panduan & Pelatihan Kru AV Gereja</span>
                </div>
            </a>

            <!-- Universal Search Bar -->
            <div class="flex-1 max-w-md mx-2 hidden md:block">
                <div class="relative cursor-pointer" onclick="openSearchModal()">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" readonly placeholder="Cari SOP, kabel XLR, ATEM, kendala audio... (Tekan /)" 
                        class="w-full pl-10 pr-12 py-2 bg-surface-container-low hover:bg-surface-container transition-colors rounded-xl text-sm text-on-surface placeholder:text-outline cursor-pointer border border-transparent hover:border-outline-variant/40 focus:outline-none" />
                    <kbd class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-outline px-1.5 py-0.5 rounded bg-surface-container border border-outline-variant/50">⌘K</kbd>
                </div>
            </div>

            <!-- Status & Profile -->
            <div class="flex items-center gap-3">
                <!-- Status Liturgi Badge -->
                <div class="hidden lg:flex items-center gap-2 px-3 py-1 rounded-full bg-tertiary-fixed text-tertiary text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-tertiary-container animate-pulse"></span>
                    <span>Status: Siap Siaran</span>
                </div>

                <!-- Crew ID -->
                <div class="hidden xl:flex flex-col text-right">
                    <span class="text-xs font-bold text-on-surface">Kru Livestream</span>
                    <span class="text-[11px] text-on-surface-variant">Paroki Maria Bunda</span>
                </div>

                <!-- Hotline Button -->
                <button onclick="openHotlineModal()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 transition-colors text-xs font-bold shadow-sm" title="Hotline & Kontak Bantuan">
                    <span class="material-symbols-outlined text-[16px] text-amber-700">emergency</span>
                    <span class="hidden sm:inline">Hotline</span>
                </button>

                <!-- Search Icon on Mobile -->
                <button onclick="openSearchModal()" class="md:hidden p-2 rounded-lg bg-surface-container text-on-surface">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </button>
            </div>
        </div>

        <!-- Row 2: Main Desktop Nav Links -->
        <nav class="h-11 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-surface-container-lowest flex items-center justify-between overflow-x-auto gap-1 border-t border-outline-variant/20 text-xs sm:text-sm font-medium">
            <div class="flex items-center gap-1 sm:gap-2">
                <a href="{{ route('home') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('home') ? 'active' : '' }}" data-nav="beranda">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('equipment.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('equipment.index') ? 'active' : '' }}" data-nav="alat">
                    <span class="material-symbols-outlined text-[18px]">construction</span>
                    <span>Alat & Kabel</span>
                </a>
                <a href="{{ route('steps.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('steps.index') ? 'active' : '' }}" data-nav="langkah">
                    <span class="material-symbols-outlined text-[18px]">format_list_numbered</span>
                    <span>Langkah (SOP)</span>
                </a>
                <a href="{{ route('signal-routes.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('signal-routes.index') ? 'active' : '' }}" data-nav="alur-sinyal">
                    <span class="material-symbols-outlined text-[18px]">schema</span>
                    <span>Alur Sinyal</span>
                </a>
                <a href="{{ route('ptz.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('ptz.index') ? 'active' : '' }}" data-nav="ptz">
                    <span class="material-symbols-outlined text-[18px]">videocam</span>
                    <span>Kamera PTZ</span>
                </a>
                <a href="{{ route('checklist.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('checklist.index') ? 'active' : '' }}" data-nav="hari-h">
                    <span class="material-symbols-outlined text-[18px] text-amber-600">bolt</span>
                    <span>Mode Hari-H</span>
                </a>
                <a href="{{ route('training.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('training.index') ? 'active' : '' }}" data-nav="latihan">
                    <span class="material-symbols-outlined text-[18px]">quiz</span>
                    <span>Latihan & Kuis</span>
                </a>
                <a href="{{ route('troubleshooting.index') }}" class="nav-pill px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ request()->routeIs('troubleshooting.index') ? 'active' : '' }}" data-nav="bantuan">
                    <span class="material-symbols-outlined text-[18px]">help</span>
                    <span>Bantuan</span>
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-2 text-xs text-on-surface-variant font-medium shrink-0">
                <span class="material-symbols-outlined text-secondary text-[16px]">church</span>
                <span>Liturgi Mingguan Hari Minggu</span>
            </div>
        </nav>

        <!-- Row 3: Active Module Status Strip -->
        <div class="h-7 w-full bg-surface-container-low border-t border-outline-variant/20 px-4 sm:px-6 lg:px-8 text-[11px] flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-2 flex-1 max-w-xl">
                <span class="font-bold text-primary whitespace-nowrap">Modul Aktif:</span>
                <span class="truncate text-on-surface">Modul 2: Setup Kabel Audio & Video Misa Mingguan</span>
                <div class="hidden sm:flex items-center gap-1.5 w-32 shrink-0">
                    <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                        <div id="top-progress-bar" class="h-full bg-secondary-container w-[60%] rounded-full transition-all duration-500"></div>
                    </div>
                    <span id="top-progress-text" class="text-secondary font-bold text-[10px]">60%</span>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-1 text-on-surface-variant">
                <span class="material-symbols-outlined text-[14px]">school</span>
                <span>Jalur Pembelajaran Remaja Paroki</span>
            </div>
        </div>
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-surface-container-low border-t border-outline-variant/20 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-on-surface-variant">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] text-secondary">church</span>
                <span>&copy; 2025 Komsos Live Academy. Dibuat untuk Kru Pelayanan AV Gereja.</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-on-surface transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-on-surface transition-colors">Syarat Layanan</a>
                <a href="#" class="hover:text-on-surface transition-colors">Kontak</a>
            </div>
        </div>
    </footer>

    <!-- ================= MODALS ================= -->

    <!-- Search Modal -->
    <div id="search-modal" class="hidden fixed inset-0 z-[100] bg-black/50 flex items-start justify-center pt-20 p-4 overflow-y-auto">
        <div class="bg-surface-container-lowest rounded-2xl w-full max-w-2xl shadow-2xl border border-outline-variant/30">
            <div class="p-4 border-b border-outline-variant/20">
                <input type="text" id="search-input" placeholder="Cari langkah, alat, kabel, bantuan..." 
                    class="w-full px-4 py-3 bg-surface-container rounded-xl border border-outline-variant/30 text-sm focus:outline-none focus:border-primary" 
                    autofocus />
            </div>
            <div id="search-results" class="max-h-96 overflow-y-auto p-4">
                <p class="text-xs text-on-surface-variant text-center py-8">Mulai ketik untuk mencari...</p>
            </div>
        </div>
    </div>

    <!-- Hotline Modal -->
    <div id="hotline-modal" class="hidden fixed inset-0 z-[100] bg-black/50 flex items-center justify-center p-4">
        <div class="bg-surface-container-lowest rounded-2xl w-full max-w-sm shadow-2xl border border-outline-variant/30 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-headline font-bold text-lg text-primary">Hotline & Kontak Bantuan</h2>
                <button onclick="closeHotlineModal()" class="p-1.5 rounded-lg bg-surface-container text-on-surface hover:bg-surface-container-high">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-low border border-outline-variant/20">
                    <span class="material-symbols-outlined text-primary">phone</span>
                    <div>
                        <div class="font-bold text-on-surface">Hotline Teknis</div>
                        <div class="text-on-surface-variant">+62-274-123-4567</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-low border border-outline-variant/20">
                    <span class="material-symbols-outlined text-secondary">mail</span>
                    <div>
                        <div class="font-bold text-on-surface">Email Support</div>
                        <div class="text-on-surface-variant">komsos.av@paroki.id</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-low border border-outline-variant/20">
                    <span class="material-symbols-outlined text-tertiary">groups</span>
                    <div>
                        <div class="font-bold text-on-surface">Grup WhatsApp Kru</div>
                        <div class="text-on-surface-variant">Hubungi ketua Komsos</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ATEM Port Inspector Modal -->
    <div id="atem-modal" class="hidden fixed inset-0 z-[100] bg-black/50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-surface-container-lowest rounded-2xl w-full max-w-3xl shadow-2xl border border-outline-variant/30 p-6 my-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[24px]">developer_board</span>
                    <div>
                        <h2 class="font-headline font-bold text-lg text-primary">Port Inspector: ATEM Mini Switcher</h2>
                        <p class="text-xs text-on-surface-variant">Peta lengkap port masukan & luaran</p>
                    </div>
                </div>
                <button onclick="closeAtemModal()" class="p-1.5 rounded-lg bg-surface-container text-on-surface hover:bg-surface-container-high">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- HDMI Inputs -->
                <div class="p-4 rounded-xl bg-blue-50 border border-blue-200">
                    <h3 class="font-bold text-blue-950 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined">videocam</span>
                        HDMI Input (1-4)
                    </h3>
                    <ul class="space-y-2 text-xs text-blue-900">
                        <li><strong>Port 1:</strong> Kamera Altar (Main)</li>
                        <li><strong>Port 2:</strong> Kamera Mimbar</li>
                        <li><strong>Port 3:</strong> Slide Teks Lagu / Liturgi</li>
                        <li><strong>Port 4:</strong> Cadangan / Guest Speaker</li>
                    </ul>
                </div>

                <!-- Audio Inputs -->
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200">
                    <h3 class="font-bold text-amber-950 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined">mic</span>
                        Mic Input (1-2)
                    </h3>
                    <ul class="space-y-2 text-xs text-amber-900">
                        <li><strong>Mic 1:</strong> Audio dari Mixer Kecil (Jack 3.5mm)</li>
                        <li><strong>Mic 2:</strong> Lapangan / Cadangan</li>
                    </ul>
                </div>

                <!-- USB Output -->
                <div class="p-4 rounded-xl bg-purple-50 border border-purple-200">
                    <h3 class="font-bold text-purple-950 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined">usb</span>
                        USB Output
                    </h3>
                    <ul class="space-y-2 text-xs text-purple-900">
                        <li><strong>USB-C Webcam:</strong> Ke Laptop OBS Studio (Video Out)</li>
                    </ul>
                </div>

                <!-- Ethernet -->
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                    <h3 class="font-bold text-emerald-950 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined">cloud</span>
                        Ethernet Control
                    </h3>
                    <ul class="space-y-2 text-xs text-emerald-900">
                        <li><strong>LAN Port:</strong> Control panel & Remote PTZ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Modal -->
    <div id="certificate-modal" class="hidden fixed inset-0 z-[100] bg-black/50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-outline-variant/30 p-8 my-8">
            <div class="text-center mb-6">
                <h2 class="font-headline font-bold text-2xl text-primary mb-2">Sertifikat Kelulusan</h2>
                <p class="text-sm text-on-surface-variant">Anda telah menyelesaikan latihan Komsos Live Academy</p>
            </div>

            <!-- Certificate Card -->
            <div class="relative p-8 rounded-2xl bg-gradient-to-br from-secondary-container to-secondary-fixed border-4 border-secondary mb-6">
                <div class="absolute top-0 left-0 w-full h-full rounded-2xl bg-[repeating-linear-gradient(45deg,transparent,transparent_10px,rgba(255,255,255,.1)_10px,rgba(255,255,255,.1)_20px)] pointer-events-none"></div>
                <div class="relative z-10 text-center text-secondary-container">
                    <div class="font-headline font-bold text-3xl mb-2">SERTIFIKAT</div>
                    <div class="text-xs font-bold tracking-widest mb-6">KOMSOS LIVE ACADEMY</div>
                    <div class="border-b-2 border-secondary/30 pb-3 mb-3">
                        <p class="text-lg font-bold">Nama User</p>
                    </div>
                    <p class="text-xs">Telah berhasil menyelesaikan Pelatihan Dasar Kru AV Liturgi</p>
                    <div class="mt-4 pt-4 border-t border-secondary/30 text-xs">
                        <p>Sertifikat No: <strong>KMS-2025-001</strong></p>
                        <p>Tanggal: <strong id="cert-date">5 November 2025</strong></p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 justify-center">
                <button onclick="downloadCertificate()" class="px-6 py-2 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-container transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">download</span>
                    Download PDF
                </button>
                <button onclick="printCertificate()" class="px-6 py-2 rounded-xl bg-surface-container text-on-surface font-bold text-sm hover:bg-surface-container-high transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">print</span>
                    Cetak
                </button>
                <button onclick="closeCertificateModal()" class="px-6 py-2 rounded-xl bg-outline-variant/20 text-on-surface font-bold text-sm hover:bg-outline-variant/30 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])

    <!-- Global Scripts -->
    <script>
        // Search Modal
        function openSearchModal() {
            document.getElementById('search-modal').classList.remove('hidden');
            document.getElementById('search-input').focus();
        }

        function closeSearchModal() {
            document.getElementById('search-modal').classList.add('hidden');
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openSearchModal();
            }
            if (e.key === '/') {
                e.preventDefault();
                openSearchModal();
            }
            if (e.key === 'Escape') {
                closeSearchModal();
                closeHotlineModal();
                closeAtemModal();
                closeCertificateModal();
            }
        });

        // Hotline Modal
        function openHotlineModal() {
            document.getElementById('hotline-modal').classList.remove('hidden');
        }

        function closeHotlineModal() {
            document.getElementById('hotline-modal').classList.add('hidden');
        }

        // ATEM Modal
        function openAtemPortInspector() {
            document.getElementById('atem-modal').classList.remove('hidden');
        }

        function closeAtemModal() {
            document.getElementById('atem-modal').classList.add('hidden');
        }

        // Certificate Modal
        function openCertificateModal() {
            document.getElementById('certificate-modal').classList.remove('hidden');
        }

        function closeCertificateModal() {
            document.getElementById('certificate-modal').classList.add('hidden');
        }

        function downloadCertificate() {
            alert('Download PDF feature akan diimplementasikan di fase 4');
        }

        function printCertificate() {
            window.print();
        }

        // Close modals on outside click
        document.getElementById('search-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'search-modal') closeSearchModal();
        });
        document.getElementById('hotline-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'hotline-modal') closeHotlineModal();
        });
        document.getElementById('atem-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'atem-modal') closeAtemModal();
        });
        document.getElementById('certificate-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'certificate-modal') closeCertificateModal();
        });

        // Active nav pills
        document.querySelectorAll('.nav-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.nav-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
