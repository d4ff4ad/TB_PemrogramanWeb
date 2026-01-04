@extends('layouts.app')

@section('content')

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Pesanan</h1>
        <a href="{{ route('admin.registrations.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition shadow flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Data (.xls)
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Event</th>
                        <th scope="col" class="px-6 py-3">Pendaftar</th>
                        <th scope="col" class="px-6 py-3">Detail</th>
                        <th scope="col" class="px-6 py-3">Bukti Pembayaran</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($registrations as $registration)
                        <tr class="hover:bg-gray-50 transition {{ $registration->special_needs ? 'bg-yellow-50 border-l-4 border-yellow-400' : '' }}">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $registration->event->title }}
                                <br>
                                <span class="text-xs text-gray-400">ID: #{{ $registration->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">
                                    {{ $registration->name }}
                                    @if($registration->special_needs)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 ml-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full animate-pulse" title="Kebutuhan Khusus: {{ $registration->special_needs }}">
                                            ⚠️
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs">{{ $registration->email }}</div>
                                <div class="text-xs">{{ $registration->phone_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                <div><span class="font-semibold">Gender:</span> {{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                <div><span class="font-semibold">Usia:</span> {{ $registration->age }} Tahun</div>
                                <div><span class="font-semibold">Status:</span> {{ $registration->status_peserta }}</div>
                                @if($registration->special_needs)
                                    <div class="mt-1 p-1 bg-yellow-100 text-yellow-800 rounded font-bold border border-yellow-200">
                                        ⚠️ Note: {{ $registration->special_needs }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($registration->payment_proof)
                                    <a href="{{ asset('storage/' . $registration->payment_proof) }}" target="_blank" class="block w-20 h-14 rounded overflow-hidden border border-gray-200 hover:border-indigo-500 transition">
                                        <img src="{{ asset('storage/' . $registration->payment_proof) }}" alt="Bukti" class="w-full h-full object-cover">
                                    </a>
                                    <span class="text-xs text-blue-500 hover:underline cursor-pointer" onclick="window.open('{{ asset('storage/' . $registration->payment_proof) }}', '_blank')">Lihat Full</span>
                                @else
                                    <span class="text-gray-400 text-xs italic">Belum upload</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($registration->status == 'pending')
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Pending</span>
                                @elseif($registration->status == 'waiting_confirmation')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold animate-pulse">Perlu Cek</span>
                                @elseif($registration->status == 'confirmed')
                                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Lunas</span>
                                @elseif($registration->status == 'rejected')
                                    <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($registration->status == 'waiting_confirmation' || $registration->status == 'pending')
                                    <div class="flex justify-center space-x-2">
                                        <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST" class="approve-form">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold transition">Terima</button>
                                        </form>
                                        <form action="{{ route('admin.registrations.reject', $registration->id) }}" method="POST" class="reject-form">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold transition">Tolak</button>
                                        </form>
                                    </div>
                                @elseif($registration->status == 'confirmed')
                                    @if($registration->attended_at)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold">
                                            Hadir ✅
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500">
                                            Belum Check-in
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada pesanan masuk.
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
        // Approve Confirmation
        const approveForms = document.querySelectorAll('.approve-form');
        approveForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Terima Pesanan?',
                    text: "Status akan berubah menjadi Lunas.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981', // Green
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Terima!',
                    cancelButtonText: 'Batal',
                    position: 'center'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Reject Confirmation
        const rejectForms = document.querySelectorAll('.reject-form');
        rejectForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Tolak Pesanan?',
                    text: "Pesanan akan ditolak.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444', // Red
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal',
                    position: 'center'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Flash Message Success (Center Popup)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500,
                position: 'center'
            });
        @endif
    });
</script>
@endpush
