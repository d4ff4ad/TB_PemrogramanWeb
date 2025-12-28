<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Pesanan Butuh Cek (Waiting Confirmation)
        $pendingRegistrations = Registration::where('status', 'waiting_confirmation')->count();

        // 2. Event Aktif (Waktu mulai > sekarang)
        $activeEvents = Event::where('start_time', '>', now())->count();

        // 3. Total Peserta (All Registrations)
        $totalRegistrants = Registration::count();

        // Optional: Data tambahan untuk tabel preview atau grafik
        // Misalnya 5 Pendaftar Terbaru
        $recentRegistrations = Registration::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact('pendingRegistrations', 'activeEvents', 'totalRegistrants', 'recentRegistrations'));
    }
}
