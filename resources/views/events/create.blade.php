@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Event Baru</h2>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Event</label>
            <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" placeholder="Contoh: Metamorfosis Cinta" value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror" placeholder="Jelaskan detail event..." required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Banner Image --}}
        <div>
            <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-1">Banner Gambar (Opsional)</label>
            <input type="file" name="banner_image" id="banner_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('banner_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Date & Time --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" id="start_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('start_time') border-red-500 @enderror" value="{{ old('start_time') }}" required>
                @error('start_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" id="end_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('end_time') border-red-500 @enderror" value="{{ old('end_time') }}" required>
                @error('end_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Location --}}
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
            <input type="text" name="location" id="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('location') border-red-500 @enderror" placeholder="Contoh: Gedung Serbaguna, Jakarta" value="{{ old('location') }}" required>
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Quota & Price --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                <input type="number" name="quota" id="quota" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('quota') border-red-500 @enderror" placeholder="100" value="{{ old('quota') }}" min="1" required>
                @error('quota')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (Rp)</label>
                <input type="number" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror" placeholder="0 jika gratis" value="{{ old('price', 0) }}" min="0" required>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('events.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md">Simpan Event</button>
        </div>

    </form>
</div>
@endsection
