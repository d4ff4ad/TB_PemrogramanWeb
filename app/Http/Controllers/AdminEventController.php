<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->latest()->get();
        return view('admin.events.table', compact('events'));
    }

    public function export()
    {
        $events = Event::withCount('registrations')->latest()->get();
        
        $html = '<table border="1">';
        $html .= '<thead>
                    <tr>
                        <th style="background-color: #f0f0f0; font-weight: bold;">No</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Judul Event</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Lokasi</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Waktu Mulai</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Harga</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Kuota Awal</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Total Pendaftar</th>
                        <th style="background-color: #f0f0f0; font-weight: bold;">Dibuat Pada</th>
                    </tr>
                  </thead>';
        $html .= '<tbody>';
        
        foreach ($events as $key => $event) {
            $html .= '<tr>';
            $html .= '<td>' . ($key + 1) . '</td>'; // Start from 1
            $html .= '<td>' . $event->title . '</td>';
            $html .= '<td>' . $event->location . '</td>';
            $html .= '<td>' . $event->start_time . '</td>';
            $html .= '<td>' . $event->price . '</td>';
            $html .= '<td>' . ($event->quota + $event->registrations_count) . '</td>';
            $html .= '<td>' . $event->registrations_count . '</td>';
            $html .= '<td>' . $event->created_at . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return Response::make($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="laporan_event_eventify_' . date('Y-m-d_His') . '.xls"',
        ]);
    }
}
