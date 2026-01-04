@extends('layouts.app')

@section('content')

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center text-sm text-gray-500 mb-1">
                <a href="{{ route('admin.attendance.index') }}" class="hover:text-indigo-600 transition">Absensi</a>
                <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ $event->title }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Check-in Peserta</h1>
        </div>
        <div>
            <input type="text" id="search" placeholder="Cari nama peserta..." class="w-full md:w-64 px-4 py-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm shadow-sm">
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($registrations->isEmpty())
            <div class="p-8 text-center text-gray-500">
                Belum ada peserta yang statusnya Lunas (Confirmed).
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-700">
                        <tr>
                            <th class="px-6 py-4">Nama Peserta</th>
                            <th class="px-6 py-4">Status Absensi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="participant-list">
                        @foreach($registrations as $reg)
                            <tr class="hover:bg-gray-50 transition participant-row">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 text-base participant-name">{{ $reg->name }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $reg->id }} • {{ $reg->email }}</div>
                                    @if($reg->special_needs)
                                        <div class="mt-1 inline-block px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs rounded-full font-bold">
                                            ⚠️ {{ $reg->special_needs }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($reg->attended_at)
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Hadir {{ $reg->attended_at->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-semibold">
                                            Belum Hadir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.attendance.store', $reg->id) }}" method="POST">
                                        @csrf
                                        @if($reg->attended_at)
                                            <button type="submit" class="text-sm text-gray-400 hover:text-red-500 underline decoration-dotted">
                                                Batal Check-in
                                            </button>
                                        @else
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-bold shadow-md transform active:scale-95 transition-all text-sm">
                                                ✅ Check-in
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
    // Simple Client-side Search
    document.getElementById('search').addEventListener('keyup', function() {
        let query = this.value.toLowerCase();
        let rows = document.querySelectorAll('.participant-row');
        
        rows.forEach(row => {
            let name = row.querySelector('.participant-name').innerText.toLowerCase();
            if (name.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Auto-focus search on load
    document.getElementById('search').focus();
</script>
@endpush
