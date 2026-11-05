@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Latihan & Kuis</h1>
        <p class="text-on-surface-variant mb-8">Simulasi interaktif dan kuis untuk menguji pengetahuan.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20">
                <span class="material-symbols-outlined text-primary text-[32px]">cable</span>
                <h3 class="font-bold text-on-surface mt-2 mb-1">Simulator Kabel</h3>
                <p class="text-xs text-on-surface-variant mb-4">Hubungkan kabel XLR, HDMI ke port yang benar</p>
                <button class="px-3 py-1 rounded-lg bg-primary text-white text-xs font-bold">Mulai →</button>
            </div>
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20">
                <span class="material-symbols-outlined text-secondary text-[32px]">developer_board</span>
                <h3 class="font-bold text-on-surface mt-2 mb-1">Port Inspector ATEM</h3>
                <p class="text-xs text-on-surface-variant mb-4">Identifikasi port HDMI input & output</p>
                <button class="px-3 py-1 rounded-lg bg-secondary text-white text-xs font-bold" onclick="openAtemPortInspector()">Buka →</button>
            </div>
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20">
                <span class="material-symbols-outlined text-tertiary text-[32px]">quiz</span>
                <h3 class="font-bold text-on-surface mt-2 mb-1">Kuis Setup AV</h3>
                <p class="text-xs text-on-surface-variant mb-4">10 pertanyaan tentang setup dan troubleshooting</p>
                <button class="px-3 py-1 rounded-lg bg-tertiary text-white text-xs font-bold">Mulai →</button>
            </div>
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20">
                <span class="material-symbols-outlined text-amber-600 text-[32px]">school</span>
                <h3 class="font-bold text-on-surface mt-2 mb-1">Ujian Akhir</h3>
                <p class="text-xs text-on-surface-variant mb-4">Uji kompetensi untuk mendapat sertifikat</p>
                <button class="px-3 py-1 rounded-lg bg-amber-600 text-white text-xs font-bold">Mulai →</button>
            </div>
        </div>
    </div>
</div>
@endsection
