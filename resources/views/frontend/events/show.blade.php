@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Event Detail --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://placehold.co/800x400/indigo/white?text=Event' }}" 
                     alt="{{ $event->title }}" 
                     class="w-full h-80 object-cover">
                
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                    
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">← Kembali ke Daftar Event</a>
            </div>
        </div>

        {{-- Registration Form --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-indigo-100 p-6 sticky top-24">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Daftar Event Ini</h3>

                @if($event->quota > 0)
                    <form action="{{ route('registrations.store', $event->id) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nama Anda" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="email@contoh.com" required>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                            <input type="text" name="phone_number" id="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="0812xxxx" required>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-md">
                            Daftar Sekarang
                        </button>
                    </form>
                    
                    <p class="text-xs text-center text-gray-500 mt-4">Sisa Kuota: {{ $event->quota }} Peserta</p>
                @else
                    <div class="text-center py-8">
                        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full font-bold">Kuota Habis</span>
                        <p class="text-gray-500 mt-4 text-sm">Maaf, pendaftaran untuk event ini sudah ditutup.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5',
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
            });
        @endif
    });
</script>
