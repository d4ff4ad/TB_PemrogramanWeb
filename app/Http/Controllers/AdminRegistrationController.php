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
        
        $registration->update(['status' => 'rejected']);
        $registration->event->increment('quota');

        return back()->with('success', 'Pesanan berhasil ditolak & kuota dikembalikan.');
    }

    public function checkIn($id)
    {
        $registration = Registration::findOrFail($id);
        
        $registration->update(['attended_at' => now()]);

        return back()->with('success', 'Peserta berhasil check-in (Hadir).');
    }

    public function export()
    {
        $registrations = Registration::with('event')->latest()->get();

        $filename = "data_peserta_".date('Y-m-d_H-i-s').".xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $content = "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event</th>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Status Peserta</th>
                    <th>Pernah Ikut</th>
                    <th>Kebutuhan Khusus</th>
                    <th>Status Reg</th>
                    <th>Waktu Hadir</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>";
            
        foreach ($registrations as $reg) {
            $prev = $reg->previous_participation ? 'Ya' : 'Tidak';
            $attended = $reg->attended_at ? $reg->attended_at->format('Y-m-d H:i') : '-';
            $content .= "<tr>
                <td>{$reg->id}</td>
                <td>{$reg->event->title}</td>
                <td>{$reg->name}</td>
                <td>{$reg->email}</td>
                <td>'{$reg->phone_number}</td>
                <td>{$reg->gender}</td>
                <td>{$reg->age}</td>
                <td>{$reg->status_peserta}</td>
                <td>{$prev}</td>
                <td>{$reg->special_needs}</td>
                <td>{$reg->status}</td>
                <td>{$attended}</td>
                <td>{$reg->created_at}</td>
            </tr>";
        }
        
        $content .= "</tbody></table>";

        return response($content, 200, $headers);
    }
}
