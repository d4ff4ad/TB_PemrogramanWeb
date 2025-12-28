@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white text-center">Selesaikan Pembayaran</h2>
            </div>
            
            <div class="p-6 md:p-8">
                {{-- Event Info --}}
                <div class="mb-6 text-center">
                    <p class="text-gray-500 text-sm">Pembayaran untuk Event</p>
                    <h3 class="text-lg font-bold text-gray-800">{{ $registration->event->title }}</h3>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6 text-center">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Total Tagihan</p>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-2">
                        Rp {{ number_format($registration->event->price, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Bank Info --}}
                <div class="mb-8 p-4 border border-indigo-100 rounded-lg bg-indigo-50">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-700">Bank Transfer</span>
                        <span class="text-indigo-600 font-bold">BCA</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 text-sm">No. Rekening</span>
                        <code class="bg-white px-2 py-1 rounded border border-gray-300 font-mono font-bold text-gray-800">1234567890</code>
                    </div>
                    <div class="mt-2 text-center text-xs text-gray-400">a.n. Eventify Official</div>
                </div>

                {{-- Status Indicator --}}
                @if($registration->status == 'pending')
                    <div class="mb-6">
                        <form action="{{ route('registrations.updatePayment', $registration->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition cursor-pointer bg-gray-50 hover:bg-white" onclick="document.getElementById('payment_proof').click()">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <span class="relative bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload file</span>
                                            </span>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                    </div>
                                </div>
                                <input type="file" name="payment_proof" id="payment_proof" class="hidden" onchange="previewImage(event)">
                                <div id="preview-container" class="mt-2 hidden text-center">
                                    <p class="text-xs text-green-600 font-semibold mb-1">File Terpilih:</p>
                                    <img id="preview-image" src="#" alt="Preview" class="h-32 mx-auto rounded border border-gray-200 shadow-sm">
                                </div>
                            </div>
    
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-md">
                                Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                @elseif($registration->status == 'waiting_confirmation')
                    <div class="text-center py-6 bg-yellow-50 rounded-lg border border-yellow-100">
                        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">Menunggu Konfirmasi</h3>
                        <p class="text-gray-600 mt-2 text-sm px-4">Terima kasih! Bukti pembayaran Anda sedang kami cek. Mohon tunggu informasi selanjutnya.</p>
                        
                        @if($registration->payment_proof)
                            <div class="mt-4">
                                <p class="text-xs text-gray-400 mb-1">Bukti Upload Anda:</p>
                                <img src="{{ asset('storage/' . $registration->payment_proof) }}" alt="Bukti" class="h-24 mx-auto rounded shadow-sm border border-gray-200">
                            </div>
                        @endif
                    </div>
                @elseif($registration->status == 'confirmed')
                    <div class="text-center py-6 bg-green-50 rounded-lg border border-green-100">
                        <svg class="w-16 h-16 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">Pembayaran Berhasil!</h3>
                        <p class="text-gray-600 mt-2 text-sm px-4">Pendaftaran Anda telah dikonfirmasi. Tiket elektronik akan segera dikirim ke email Anda.</p>
                    </div>
                @endif

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-gray-500 text-sm hover:text-indigo-600 transition underline">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@stack('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-image');
            output.src = reader.result;
            document.getElementById('preview-container').classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
