@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Simulator Kamera PTZ</h1>
        <p class="text-on-surface-variant mb-8">Simulasikan kontrol Pan-Tilt-Zoom untuk kamera remote.</p>
        <div class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/20 text-center">
            <span class="material-symbols-outlined text-primary text-[64px] block mb-4">videocam</span>
            <p class="text-on-surface-variant">Simulator interaktif akan dimuat di sini...</p>
            <div class="mt-4 flex gap-2 justify-center">
                <button class="px-4 py-2 rounded-lg bg-primary text-white text-sm font-bold">← Pan Left</button>
                <button class="px-4 py-2 rounded-lg bg-primary text-white text-sm font-bold">Tilt Up →</button>
                <button class="px-4 py-2 rounded-lg bg-secondary text-white text-sm font-bold">Zoom In/Out</button>
            </div>
        </div>
    </div>
</div>
@endsection
