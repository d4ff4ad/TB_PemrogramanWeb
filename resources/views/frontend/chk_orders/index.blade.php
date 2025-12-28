@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pesanan Saya</h2>
        <a href="{{ route('public.orders.check') }}" class="text-sm text-indigo-600 hover:underline">Cek Email Lain</a>
    </div>

    @forelse($registrations as $registration)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition">
            <div class="p-6 md:flex justify-between items-center">
                <div class="flex-grow">
                    <div class="flex items-center space-x-3 mb-2">
                        @if($registration->status == 'pending')
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Menunggu Pembayaran</span>
                        @elseif($registration->status == 'waiting_confirmation')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold">Sedang Dicek Admin</span>
                        @elseif($registration->status == 'confirmed')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold mb-2">Lunas</span>
                            <a href="{{ route('public.orders.ticket', $registration->id) }}" target="_blank" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                                🖨️ Cetak Tiket
                            </a>
                        @elseif($registration->status == 'rejected')
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Ditolak</span>
                        @endif
                        <span class="text-xs text-gray-500">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $registration->event->title }}</h3>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ $registration->name }} • {{ number_format($registration->event->price, 0, ',', '.') }} IDR
                    </p>
                </div>
                
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <a href="{{ route('public.events.show', $registration->event->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Detail Event</a>
                    
                    @if($registration->status == 'pending')
                        <a href="{{ route('registrations.payment', $registration->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">
                            Bayar Sekarang
                        </a>
                    @elseif($registration->status == 'waiting_confirmation')
                         <a href="{{ route('registrations.payment', $registration->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-600 transition">
                            Cek Status
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500">Tidak ada riwayat pesanan ditemukan untuk email ini.</p>
        </div>
    @endforelse

</div>
@endsection
