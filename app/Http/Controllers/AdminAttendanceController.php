<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index()
    {
        // List events that are active (or all events).
        // Maybe sort by date DESC.
        $events = Event::withCount(['registrations' => function ($query) {
            $query->where('status', 'confirmed');
        }])->whereDate('start_time', '>=', now()->today())->latest('start_time')->get();

        return view('admin.attendance.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        
        // Get only confirmed participants for this event
        $registrations = Registration::where('event_id', $id)
            ->where('status', 'confirmed')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.attendance.show', compact('event', 'registrations'));
    }

    public function store($id)
    {
        $registration = Registration::findOrFail($id);
        
        // Logika Toggle: Kalau sudah hadir, cancel. Kalau belum, hadir.
        // Biar bisa undo kalau salah pencet.
        if ($registration->attended_at) {
            $registration->update(['attended_at' => null]);
            return back()->with('success', 'Check-in dibatalkan (Reset).');
        } else {
            $registration->update(['attended_at' => now()]);
            return back()->with('success', 'Peserta berhasil check-in (Hadir).');
        }
    }
}
