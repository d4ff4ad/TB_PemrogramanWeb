@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Absensi Hari-H</h1>
        <p class="text-gray-600 mt-2">Pilih event yang sedang berlangsung untuk membuka halaman check-in.</p>
    </div>

    @if($events->isEmpty())
        <div class="p-8 bg-white rounded-xl shadow-sm border border-gray-100 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-medium text-gray-900">Belum ada event.</h3>
            <p class="text-gray-500">Buat event baru terlebih dahulu.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="h-32 bg-gray-200 relative">
                        @if($event->banner_image)
                            <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-700 shadow-sm">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-1">{{ $event->title }}</h3>
                        <div class="text-sm text-gray-500 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="text-xs text-gray-500">
                                <span class="font-bold text-green-600 block text-sm">{{ $event->registrations_count }}</span>
                                Peserta Lunas
                            </div>
                            <a href="{{ route('admin.attendance.show', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition flex items-center">
                                Buka Absensi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
