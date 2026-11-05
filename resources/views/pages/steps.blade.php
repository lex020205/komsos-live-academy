@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Langkah Setup (SOP)</h1>
        <p class="text-on-surface-variant mb-8">Panduan 12 langkah setup AV liturgi dari awal hingga siaran live.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @for ($i = 1; $i <= 12; $i++)
                <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/20">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-sm flex-shrink-0">{{ $i }}</div>
                        <div>
                            <h3 class="font-bold text-on-surface">Langkah {{ $i }}: Setup Audio Mixer</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Konfigurasi input mikrofon dan level audio...</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection
