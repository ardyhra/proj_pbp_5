<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded shadow-lg">
        <h2 class="text-2xl font-bold text-center">Login</h2>
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm">Email:</label>
                <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label for="password" class="block text-sm">Password:</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" class="w-full py-2 text-white bg-blue-500 rounded">Login</button>
        </form>
    </div>
</body>
</html>
