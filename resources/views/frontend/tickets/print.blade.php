<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $registration->event->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-4xl w-full flex flex-col md:flex-row print:shadow-none print:w-full print:max-w-none">
        
        <!-- Left Side: Event Details (70%) -->
        <div class="w-full md:w-3/4 p-8 relative">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 tracking-tight mb-2">{{ $registration->event->title }}</h1>
                    <p class="text-indigo-600 font-semibold uppercase tracking-wide text-sm">Event Ticket</p>
                </div>
                <div class="text-right">
                    <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Status</div>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">CONFIRMED</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Tanggal & Waktu</div>
                    <div class="text-gray-800 font-bold text-lg">
                        {{ \Carbon\Carbon::parse($registration->event->start_time)->format('d M Y') }}
                    </div>
                    <div class="text-gray-600">
                        {{ \Carbon\Carbon::parse($registration->event->start_time)->format('H:i') }} WIB
                    </div>
                </div>
                <div>
                    <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Lokasi</div>
                    <div class="text-gray-800 font-bold text-lg leading-tight">
                        {{ $registration->event->location }}
                    </div>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-300 my-6"></div>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Nama Peserta</div>
                    <div class="text-gray-800 font-bold text-xl">{{ $registration->name }}</div>
                    <div class="text-gray-500 text-sm mt-1">{{ $registration->email }}</div>
                </div>
                <div>
                    <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Kode Booking</div>
                    <div class="text-gray-800 font-mono font-bold text-xl">#{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
            
            <!-- Watermark -->
            <div class="absolute bottom-4 right-4 text-gray-100 font-bold text-6xl opacity-20 pointer-events-none select-none z-0">
                Eventify
            </div>
        </div>

        <!-- Right Side: Barcode & Actions (30%) -->
        <div class="w-full md:w-1/4 bg-gray-900 text-white p-8 flex flex-col items-center justify-between relative print:bg-white print:text-black print:border-l print:border-gray-200">
            <!-- Cut Line -->
            <div class="absolute left-0 top-4 bottom-4 border-l-2 border-dashed border-gray-600 hidden md:block print:block print:border-gray-300"></div>
            
            <div class="text-center w-full z-10 flex flex-col items-center">
                <div class="bg-white p-2 text-black rounded mb-4 inline-block max-w-full overflow-hidden">
                     <svg id="barcode" class="w-full h-auto"></svg>
                </div>
                <div class="text-xs text-gray-400 uppercase tracking-widest print:text-gray-600">Scan di pintu masuk</div>
            </div>

            <div class="mt-8 text-center space-y-4 w-full z-10 no-print">
                <button onclick="window.print()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-bold shadow-lg transition transform hover:-translate-y-0.5">
                    🖨️ Cetak Tiket
                </button>
                <a href="{{ route('public.orders.index', ['email' => $registration->email]) }}" class="block w-full text-center text-gray-400 hover:text-white text-sm transition">
                    &larr; Kembali
                </a>
            </div>
        </div>

    </div>

    <script>
        JsBarcode("#barcode", "EVT-{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}", {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 50,
            displayValue: true
        });
    </script>
</body>
</html>
