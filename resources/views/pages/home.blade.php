@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="font-headline font-bold text-4xl lg:text-5xl text-primary mb-4">
                Selamat Datang di Komsos Live Academy
            </h1>
            <p class="text-lg text-on-surface-variant max-w-2xl mx-auto">
                Platform pembelajaran lengkap untuk kru AV liturgi gereja. Pelajari setup kamera, audio, video, troubleshooting, dan lainnya.
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/20">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-primary text-[32px]">format_list_numbered</span>
                    <span class="text-3xl font-bold text-on-surface">12</span>
                </div>
                <p class="text-sm text-on-surface-variant">Langkah SOP</p>
            </div>
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/20">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-secondary text-[32px]">construction</span>
                    <span class="text-3xl font-bold text-on-surface">24</span>
                </div>
                <p class="text-sm text-on-surface-variant">Alat & Kabel</p>
            </div>
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/20">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-tertiary text-[32px]">quiz</span>
                    <span class="text-3xl font-bold text-on-surface">8</span>
                </div>
                <p class="text-sm text-on-surface-variant">Latihan Interaktif</p>
            </div>
            <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/20">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-amber-600 text-[32px]">help</span>
                    <span class="text-3xl font-bold text-on-surface">15</span>
                </div>
                <p class="text-sm text-on-surface-variant">Troubleshooting</p>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('steps.index') }}" class="group bg-surface-container-low hover:bg-surface-container rounded-2xl p-6 border border-outline-variant/20 transition-all hover:shadow-lg">
                <span class="material-symbols-outlined text-primary text-[48px] mb-3 block group-hover:scale-110 transition-transform">format_list_numbered</span>
                <h3 class="font-headline font-bold text-xl text-on-surface mb-2">Langkah Setup</h3>
                <p class="text-sm text-on-surface-variant">Pandu 12 langkah setup AV liturgi dari awal hingga siaran.</p>
            </a>

            <a href="{{ route('equipment.index') }}" class="group bg-surface-container-low hover:bg-surface-container rounded-2xl p-6 border border-outline-variant/20 transition-all hover:shadow-lg">
                <span class="material-symbols-outlined text-secondary text-[48px] mb-3 block group-hover:scale-110 transition-transform">construction</span>
                <h3 class="font-headline font-bold text-xl text-on-surface mb-2">Alat & Kabel</h3>
                <p class="text-sm text-on-surface-variant">Katalog lengkap peralatan, konektor, kabel XLR, HDMI, dan lainnya.</p>
            </a>

            <a href="{{ route('training.index') }}" class="group bg-surface-container-low hover:bg-surface-container rounded-2xl p-6 border border-outline-variant/20 transition-all hover:shadow-lg">
                <span class="material-symbols-outlined text-tertiary text-[48px] mb-3 block group-hover:scale-110 transition-transform">quiz</span>
                <h3 class="font-headline font-bold text-xl text-on-surface mb-2">Latihan & Kuis</h3>
                <p class="text-sm text-on-surface-variant">Simulator kabel, ATEM Mini, dan kuis interaktif.</p>
            </a>

            <a href="{{ route('signal-routes.index') }}" class="group bg-surface-container-low hover:bg-surface-container rounded-2xl p-6 border border-outline-variant/20 transition-all hover:shadow-lg">
                <span class="material-symbols-outlined text-primary text-[48px] mb-3 block group-hover:scale-110 transition-transform">schema</span>
                <h3 class="font-headline font-bold text-xl text-on-surface mb-2">Alur Sinyal</h3>
                <p class="text-sm text-on-surface-variant">Pilih perangkat, lihat diagram jalur audio video.</p>
            </a>

            <a href="{{ route('ptz.index') }}" class="group bg-surface-container-low hover:bg-surface-container rounded-2xl p-6 border border-outline-variant/20 transition-all hover:shadow-lg">
                <span class="material-symbols-outlined text-secondary text-[48px] mb-3 block group-hover:scale-110 transition-transform">videocam</span>
                <h3 class="font-headline font-bold text-xl text-on-surface mb-2">Kamera PTZ</h3>
                <p class="text-sm text-on-surface-variant">Simulator kontrol Pan-Tilt-Zoom untuk kamera remote.</p>
            </a>

            <a href="{{ route('checklist.index') }}" class="group bg-surface-container-low hover:bg-surface-container rounded-2xl p-6 border border-outline-variant/20 transition-all hover:shadow-lg">
                <span class="material-symbols-outlined text-amber-600 text-[48px] mb-3 block group-hover:scale-110 transition-transform">bolt</span>
                <h3 class="font-headline font-bold text-xl text-on-surface mb-2">Mode Hari-H</h3>
                <p class="text-sm text-on-surface-variant">Checklist pelaksanaan: pra-acara, on-air, pasca-siaran.</p>
            </a>
        </div>

        <!-- Info Banner -->
        <div class="mt-12 bg-secondary-container rounded-2xl p-6 border-2 border-secondary-container-high">
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-secondary text-[32px]">info</span>
                <div>
                    <h3 class="font-bold text-lg text-on-secondary-container mb-2">Login Opsional</h3>
                    <p class="text-sm text-on-secondary-container/80">
                        Anda bisa langsung mengakses semua materi dan latihan tanpa login. 
                        Login hanya diperlukan jika ingin menyimpan progres dan mendapat sertifikat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
