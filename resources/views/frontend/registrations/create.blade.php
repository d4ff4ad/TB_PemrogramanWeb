@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-indigo-600 px-8 py-6 text-white">
            <h1 class="text-2xl font-bold">Form Pendaftaran Event</h1>
            <p class="opacity-90 mt-1">{{ $event->title }}</p>
        </div>
        
        <form action="{{ route('public.events.register.store', $event->id) }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Personal Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Data Diri</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Usia</label>
                        <input type="number" name="age" value="{{ old('age') }}" required min="5" class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        @error('age') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="gender" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Peserta</label>
                        <select name="status_peserta" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Status</option>
                            <option value="Umum" {{ old('status_peserta') == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Mahasiswa" {{ old('status_peserta') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Pelajar" {{ old('status_peserta') == 'Pelajar' ? 'selected' : '' }}>Pelajar</option>
                            <option value="Jamaah Tetap" {{ old('status_peserta') == 'Jamaah Tetap' ? 'selected' : '' }}>Jamaah Tetap</option>
                        </select>
                        @error('status_peserta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="space-y-4 pt-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Tambahan</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apakah pernah mengikuti event kami sebelumnya?</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="previous_participation" value="1" {{ old('previous_participation') == '1' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            <span class="ml-2 text-gray-700">Ya, Pernah</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="previous_participation" value="0" {{ old('previous_participation') == '0' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            <span class="ml-2 text-gray-700">Belum Pernah</span>
                        </label>
                    </div>
                    @error('previous_participation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kebutuhan Khusus (Opsional)</label>
                    <p class="text-xs text-gray-500 mb-2">Contoh: Disabilitas, butuh kursi depan karena mata minus, alergi makanan tertentu, dll.</p>
                    <textarea name="special_needs" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('special_needs') }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t flex justify-end">
                <a href="{{ route('public.events.show', $event->id) }}" class="mr-4 px-6 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
