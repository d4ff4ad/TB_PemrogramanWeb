<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Check quota availability status
        if ($event->quota <= 0) {
            return back()->with('error', 'Maaf, kuota event ini sudah habis.');
        }

        $registration = Registration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'status' => 'pending',
        ]);

        // Decrease quota
        $event->decrement('quota');

        return redirect()->route('registrations.payment', $registration->id)
                         ->with('success', 'Pendaftaran berhasil! Silakan selesaikan pembayaran.');
    }

    public function payment($id)
    {
        $registration = Registration::with('event')->findOrFail($id);
        return view('frontend.registrations.payment', compact('registration'));
    }

    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $registration = Registration::findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $registration->update([
                'payment_proof' => $path,
                'status' => 'waiting_confirmation',
            ]);
        }

        return redirect()->route('registrations.payment', $id)
                         ->with('success', 'Bukti pembayaran berhasil diupload! Mohon tunggu konfirmasi admin.');
    }
}
