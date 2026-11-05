@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Bantuan & Troubleshooting</h1>
        <p class="text-on-surface-variant mb-8">Solusi cepat untuk masalah yang sering terjadi.</p>
        <div class="space-y-3">
            @foreach (['Tidak ada sinyal HDMI', 'Audio putus saat siaran', 'Kamera tidak terbaca', 'OBS tidak rekam'] as $issue)
                <div class="bg-surface-container-low rounded-lg p-4 border border-outline-variant/20 cursor-pointer hover:bg-surface-container">
                    <h3 class="font-bold text-on-surface">{{ $issue }}</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Solusi dan langkah-langkah pemecahan masalah...</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
