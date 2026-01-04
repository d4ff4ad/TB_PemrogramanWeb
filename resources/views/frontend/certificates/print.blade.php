<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Syahadah - {{ $registration->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Pinyon+Script&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f7fafc;
        }
        .ornamental-border {
            border: 20px solid transparent;
            border-image: url('https://i.ibb.co/3sxhd9z/border-ornament.png') 30 stretch;
            position: relative;
        }
        .ornamental-border::before {
            content: "";
            position: absolute;
            top: -15px; left: -15px; right: -15px; bottom: -15px;
            border: 2px solid #D4AF37; /* Gold */
            z-index: -1;
        }
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-script { font-family: 'Pinyon Script', cursive; }
        .gold-text { color: #D4AF37; }

        /* Custom Font Scale for Print */
        @media print {
            .no-print { display: none !important; }
            body { 
                background-color: white; 
                -webkit-print-color-adjust: exact; 
                margin: 0;
                padding: 0 !important;
            }
            .certificate-container { 
                width: 100vw;
                height: 100vh;
                max-width: 100%;
                max-height: 100%;
                box-shadow: none !important;
                border: none;
                margin: 0 !important;
                zoom: 1;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen py-10">

    <div class="no-print mb-8 flex flex-col items-center gap-2">
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full font-bold shadow-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Syahadah (PDF)
        </button>
        <p class="text-sm text-gray-500">Gunakan layout "Landscape" saat mencetak.</p>
        <a href="{{ route('public.orders.index') }}" class="text-sm text-gray-400 hover:underline">Kembali</a>
    </div>

    <!-- Certificate Container -->
    <div class="certificate-container bg-white w-[297mm] h-[210mm] shadow-2xl relative flex items-center justify-center p-8 text-center text-gray-800 mx-auto overflow-hidden">
        
        <!-- Border & Background Ornament -->
        <div class="absolute inset-4 border-4 border-double border-yellow-600 pointer-events-none"></div>
        <div class="absolute inset-6 border border-yellow-700/30 pointer-events-none"></div>
        
        <!-- Corner Ornaments (CSS Shapes for simplicity without images) -->
        <div class="absolute top-8 left-8 w-16 h-16 border-t-4 border-l-4 border-yellow-600"></div>
        <div class="absolute top-8 right-8 w-16 h-16 border-t-4 border-r-4 border-yellow-600"></div>
        <div class="absolute bottom-8 left-8 w-16 h-16 border-b-4 border-l-4 border-yellow-600"></div>
        <div class="absolute bottom-8 right-8 w-16 h-16 border-b-4 border-r-4 border-yellow-600"></div>

        <div class="relative z-10 max-w-4xl w-full">
            <!-- Header -->
            <div class="mb-2">
                <div class="text-3xl font-serif text-gray-400 mb-4 font-cinzel opacity-80">﷽</div>
                <h2 class="text-2xl font-cinzel tracking-widest text-gray-600 uppercase">Syahadah Kehadiran</h2>
                <div class="h-1 w-24 bg-yellow-500 mx-auto mt-2"></div>
            </div>

            <div class="my-10">
                <p class="text-gray-500 text-lg italic">Diberikan kepada:</p>
                <h1 class="font-script text-6xl text-gray-900 mt-4 mb-2">{{ $registration->name }}</h1>
                <div class="w-1/2 border-b border-gray-300 mx-auto"></div>
                
                <p class="text-gray-600 mt-8 text-xl leading-relaxed">
                    Atas partisipasinya sebagai Peserta dalam kegiatan kajian islami:
                </p>
                <h3 class="font-bold text-3xl font-cinzel gold-text mt-2 uppercase tracking-wide">
                    {{ $registration->event->title }}
                </h3>
            </div>

            <!-- Footer / Details -->
            <div class="flex justify-between items-end mt-16 px-16">
                <div class="text-center">
                    <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($registration->event->start_time)->isoFormat('D MMMM Y') }}</p>
                    <div class="h-px w-32 bg-gray-400 mx-auto my-1"></div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Tanggal Pelaksanaan</p>
                </div>

                <div class="text-center">
                   
                    <p class="font-script text-3xl text-gray-800">Panitia Eventify</p>
                     <div class="h-px w-40 bg-gray-400 mx-auto my-1"></div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Ketua Pelaksana</p>
                </div>
            </div>
            
            <div class="absolute bottom-4 left-0 right-0 text-center">
                 <p class="text-[10px] text-gray-400">ID Sertifikat: EVT-{{ $registration->event->id }}-REG-{{ $registration->id }} • Terverifikasi Otomatis</p>
            </div>
        </div>
    </div>

</body>
</html>
