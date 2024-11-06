<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login Page</title>
    <style>
        /* Background image yang diblur */
        body {
            background-image: url('/img/bglogin.jpg'); /* Ganti dengan path gambar background */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Efek blur pada background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Overlay gelap */
            backdrop-filter: blur(10px); /* Efek blur */
            z-index: -1;
        }

        /* Kotak form login di tengah */
        .login-box {
            background-color: rgba(255, 255, 255, 0.9); /* Latar belakang putih dengan opacity */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="login-box">
        <div class="flex justify-center items-center">
            <img src="img/undip.png" alt="University Logo" class="logo" width="100px">
        </div>
        <br>
        <h1 class="text-3xl mb-5 font-medium text-center leading-6 text-gray-900">SISKARA</h1>

        <!-- Tampilkan pesan error jika login gagal -->
        @if ($errors->has('login_error'))
            <div class="mb-4 text-center text-red-600">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="sm:col-span-3 mb-4">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                <div class="mt-2">
                    <input type="text" name="email" id="email" autocomplete="email"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-3 mb-4">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                <div class="mt-2">
                    <input type="password" name="password" id="password" autocomplete="current-password"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="flex flex-col justify-center">
                <button type="submit"
                        class="mb-5 w-full rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                <a href="#" class="forgot-password block text-sm text-right font-medium text-blue-700">Forgot password?</a>
            </div>
        </form>
        <br>
        <p class="block text-sm font-medium">Don't have an account? <a href="#" class="signup-link text-blue-700">Sign Up</a></p>
    </div>
</body>

</html>
