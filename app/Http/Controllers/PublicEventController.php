<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        $events = $query->latest()->get();
        return view('frontend.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('frontend.events.show', compact('event'));
    }

    public function checkOrders()
    {
        return view('frontend.chk_orders.form');
    }

    public function indexOrders(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:registrations,email',
        ], [
            'email.exists' => 'Email ini belum pernah digunakan untuk mendaftar event apapun.',
        ]);

        $registrations = \App\Models\Registration::with('event')
                            ->where('email', $request->email)
                            ->latest()
                            ->get();

        return view('frontend.chk_orders.index', compact('registrations'));
    }

    public function printTicket($id)
    {
        $registration = \App\Models\Registration::with('event')->findOrFail($id);

        if ($registration->status !== 'confirmed') {
            return abort(403, 'Tiket belum tersedia. Status pesanan belum lunas.');
        }

        return view('frontend.tickets.print', compact('registration'));
    }
}
