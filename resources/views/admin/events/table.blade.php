@extends('layouts.app')

@section('content')

    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center space-x-4">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Data Event</h1>
            <a href="{{ route('admin.events.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition shadow flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Laporan (.csv)
            </a>
        </div>
        <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700 transition shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Event Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Event</th>
                        <th scope="col" class="px-6 py-3">Jadwal & Lokasi</th>
                        <th scope="col" class="px-6 py-3 text-center">Pendaftar</th>
                        <th scope="col" class="px-6 py-3 text-right">Harga</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $event->title }}
                                <div class="text-xs text-gray-400 mt-1">Dibuat: {{ $event->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }} WIB</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $event->location }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-base font-bold text-indigo-600">{{ $event->registrations_count }}</div>
                                <div class="text-xs text-gray-400">Sisa Kuota: {{ $event->quota }}</div>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-900">
                                {{ $event->price == 0 ? 'Gratis' : 'Rp '.number_format($event->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('events.edit', $event->id) }}" class="text-yellow-500 hover:text-yellow-600 border border-yellow-200 bg-yellow-50 px-3 py-1.5 rounded-md text-xs font-bold transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 border border-red-200 bg-red-50 px-3 py-1.5 rounded-md text-xs font-bold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg font-medium mb-2">Belum ada event</p>
                                <p class="text-sm">Silakan buat event baru untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete Confirmation
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Hapus Event?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Flash Message Success (Center Popup)
        // User request: "popupnya di tengah lagi jangan diatas"
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500,
                position: 'center' // Explicitly center
            });
        @endif
    });
</script>
@endpush
