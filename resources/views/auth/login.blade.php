<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Eventify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen px-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-indigo-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white text-center">Eventify Admin</h2>
            <p class="text-indigo-200 text-center text-sm mt-1">Silakan login untuk mengelola event</p>
        </div>

        <form action="{{ route('authenticate') }}" method="POST" class="p-8 space-y-6">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded text-sm border border-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-md">
                Masuk Dashboard
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-indigo-600">← Kembali ke Halaman Utama</a>
            </div>
        </form>
    </div>

</body>
</html>
