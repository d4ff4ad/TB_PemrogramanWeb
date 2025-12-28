@extends('layouts.app')

@section('content')

    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Jelajahi Event Seru</h1>
        <p class="text-gray-500 mb-6">Temukan berbagai kegiatan menarik di sekitarmu</p>
        
        <!-- Search Form -->
        <form action="{{ route('home') }}" method="GET" class="max-w-xl mx-auto flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event atau nama kota (contoh: Bandung)..." class="w-full px-4 py-3 rounded-l-full border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition shadow-sm" style="border-right: none;">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-r-full hover:bg-indigo-700 transition font-medium shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Cari
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @forelse($events as $event)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col h-full border border-gray-100">
                
                <div class="relative h-48 bg-gray-200">
                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://placehold.co/600x400/indigo/white?text=Event' }}" 
                         alt="{{ $event->title }}" 
                         class="w-full h-full object-cover">
                    
                    <div class="absolute top-4 right-4">
                        @if($event->price == 0)
                            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">GRATIS</span>
                        @else
                            <span class="bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 hover:text-indigo-600 transition">
                        <a href="{{ route('public.events.show', $event->id) }}">{{ $event->title }}</a>
                    </h3>

                    <div class="text-sm text-gray-500 space-y-2 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }} WIB
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-xs text-gray-400">Sisa Kuota: {{ $event->quota }}</span>
                        <a href="{{ route('public.events.show', $event->id) }}" class="text-indigo-600 font-semibold text-sm hover:underline">Lihat Detail →</a>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-span-1 md:col-span-3 text-center py-20">
                <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada event</h3>
                <p class="text-gray-500 mb-6">Nantikan event seru kami selanjutnya!</p>
            </div>
        @endforelse

    </div>

@endsection
