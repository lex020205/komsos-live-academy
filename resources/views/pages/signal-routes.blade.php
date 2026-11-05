@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Alur Sinyal</h1>
        <p class="text-on-surface-variant mb-8">Pilih setup perangkat untuk melihat diagram alur audio dan video.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 cursor-pointer hover:bg-surface-container">
                <h3 class="font-bold text-on-surface">Setup Standar Misa</h3>
                <p class="text-xs text-on-surface-variant mt-2">Kamera altar + mimbar → ATEM Mini → Youtube Live</p>
            </div>
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 cursor-pointer hover:bg-surface-container">
                <h3 class="font-bold text-on-surface">Setup Minimal</h3>
                <p class="text-xs text-on-surface-variant mt-2">1 kamera HDMI → ATEM Mini → OBS → Youtube Live</p>
            </div>
        </div>
    </div>
</div>
@endsection
