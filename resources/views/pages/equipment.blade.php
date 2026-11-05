@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Alat & Kabel</h1>
        <p class="text-on-surface-variant mb-8">Katalog lengkap peralatan, konektor, dan kabel yang digunakan.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach (['Kabel XLR Audio' => 'mic', 'HDMI 2.1 Video' => 'videocam', 'Audio Mixer Kecil' => 'speaker', 'Switcher ATEM Mini' => 'developer_board', 'Kamera PTZ' => 'videocam', 'Monitor Layar'] as $item => $icon)
                <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/20">
                    <span class="material-symbols-outlined text-secondary text-[32px]">{{ $icon }}</span>
                    <h3 class="font-bold text-on-surface mt-2">{{ $item }}</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Spesifikasi dan penggunaan...</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
