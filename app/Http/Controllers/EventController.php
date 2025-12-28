<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // <--- 1. Jangan lupa import Model Event di sini

class EventController extends Controller
{
    public function index()
    {
        // 2. Ambil semua data event dari database
        // (Bisa ganti 'all()' jadi 'paginate(10)' kalau datanya banyak)
        $events = Event::all(); 
        
        // 3. Kirim variabel $events ke view
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('banner_image')) {
            // Hapus gambar lama jika ada
            if ($event->banner_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->banner_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        if ($event->banner_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->banner_image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }
}