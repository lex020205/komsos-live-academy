@extends('layouts.app')

@section('content')
<div class="pt-[140px] pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-headline font-bold text-3xl text-primary mb-6">Mode Hari-H (Checklist)</h1>
        <p class="text-on-surface-variant mb-8">Checklist pelaksanaan acara: pra-acara, on-air, pasca-siaran.</p>
        <div class="space-y-4">
            <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
                <h3 class="font-bold text-amber-950 mb-3">Pra-Acara (30 menit sebelum)</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded accent-amber-600" />
                        <span class="text-sm text-amber-900">Cek power dan kabel masuk</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded accent-amber-600" />
                        <span class="text-sm text-amber-900">Test audio dan video</span>
                    </label>
                </div>
            </div>
            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                <h3 class="font-bold text-emerald-950 mb-3">On-Air (Saat Siaran)</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded accent-emerald-600" />
                        <span class="text-sm text-emerald-900">Monitor level audio</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
