@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500">Selamat datang kembali, <span class="font-semibold">{{ Auth::user()->name ?? 'Admin' }}</span>!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <!-- Card 1: Pesanan Menunggu Cek (Teal/Green) -->
        <div class="bg-teal-600 rounded-lg shadow-lg text-white p-6 relative overflow-hidden group hover:scale-[1.02] transition transform duration-300">
            <div class="relative z-10 flex flex-col items-center justify-center text-center">
                <div class="bg-white/20 p-3 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-1">PESANAN BUTUH CEK</h3>
                <div class="text-5xl font-bold mb-2">{{ $pendingRegistrations }}</div>
                <a href="{{ route('admin.registrations.index') }}" class="text-xs font-medium hover:underline flex items-center mt-2 bg-white/10 px-3 py-1 rounded-full">
                    Segera Periksa <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            <!-- Decorative Circle -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full"></div>
        </div>

        <!-- Card 2: Event Aktif (Dark Blue) -->
        <div class="bg-slate-700 rounded-lg shadow-lg text-white p-6 relative overflow-hidden group hover:scale-[1.02] transition transform duration-300">
            <div class="relative z-10 flex flex-col items-center justify-center text-center">
                <div class="bg-white/20 p-3 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-1">EVENT SEDANG AKTIF</h3>
                <div class="text-5xl font-bold mb-2">{{ $activeEvents }}</div>
                <a href="{{ route('admin.events.table') }}" class="text-xs font-medium hover:underline flex items-center mt-2 bg-white/10 px-3 py-1 rounded-full">
                    Kelola Event <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
             <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-white/10 to-transparent"></div>
        </div>

        <!-- Card 3: Total Peserta (Blue) -->
        <div class="bg-sky-600 rounded-lg shadow-lg text-white p-6 relative overflow-hidden group hover:scale-[1.02] transition transform duration-300">
            <div class="relative z-10 flex flex-col items-center justify-center text-center">
                <div class="bg-white/20 p-3 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-1">TOTAL PESERTA</h3>
                <div class="text-5xl font-bold mb-2">{{ $totalRegistrants }}</div>
                <a href="{{ route('admin.registrations.index') }}" class="text-xs font-medium hover:underline flex items-center mt-2 bg-white/10 px-3 py-1 rounded-full">
                    Lihat Semua <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
             <div class="absolute bottom-0 left-0 w-full h-1 bg-white/20"></div>
        </div>

    </div>

    <!-- Recent Registrations Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Pendaftar Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Event</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $reg)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $reg->name }}</td>
                            <td class="px-4 py-2">{{ $reg->event->title }}</td>
                            <td class="px-4 py-2">
                                @if($reg->status == 'waiting_confirmation')
                                    <span class="text-yellow-600 font-bold text-xs">Perlu Cek</span>
                                @elseif($reg->status == 'confirmed')
                                    <span class="text-green-600 font-bold text-xs">Lunas</span>
                                @elseif($reg->status == 'pending')
                                    <span class="text-gray-400 text-xs">Pending</span>
                                @else
                                    <span class="text-red-500 text-xs">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-xs text-gray-400">{{ $reg->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-400">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
