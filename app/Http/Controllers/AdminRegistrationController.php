<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    public function index()
    {
        // Prioritize 'waiting_confirmation', then 'pending', then others.
        // Latest first.
        $registrations = Registration::with('event')
            ->orderByRaw("FIELD(status, 'waiting_confirmation', 'pending', 'confirmed', 'rejected')")
            ->latest()
            ->get();

        return view('admin.registrations.index', compact('registrations'));
    }

    public function approve($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update(['status' => 'confirmed']);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi (Terima).');
    }

    public function reject($id)
    {
        $registration = Registration::findOrFail($id);
        
        // Optional: Return quota if rejected? 
        // For simplicity, let's just reject for now. 
        // If we wanted to be strict, we might need to increment quota back.
        // Let's increment quota back if it was previously counted.
        // Our logic on store decremented quota.
        
        $registration->update(['status' => 'rejected']);
        $registration->event->increment('quota');

        return back()->with('success', 'Pesanan berhasil ditolak & kuota dikembalikan.');
    }
}
