<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SISKARA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .login-container img {
            width: 80px;
            margin-bottom: 20px;
        }

        .login-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #4aa3e0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #3597d6;
        }

        .login-container a {
            display: inline-block;
            margin-top: 10px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        .signup {
            margin-top: 20px;
            font-size: 14px;
        }

        .signup a {
            color: #4aa3e0;
        }

        .signup a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="img/undip.png" alt="Undip Logo">
        <h1>SISKARA</h1>
        <form id="loginForm">
            <input type="text" id="username" placeholder="NIM/NIP/Username/Email" required>
            <input type="password" id="password" placeholder="Password" required>
            <button type="submit" id="loginBtn">LOGIN</button>
        </form>
        <a href="#" class="forgot-password">Forgot password?</a>
        <div class="signup">
            Don't have an account? <a href="#">Sign Up</a>
        </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah form submit default

            const username = document.getElementById("username").value.trim().toLowerCase();
            const password = document.getElementById("password").value;

            // Periksa username
            if (username === "bagian akademik") {
                window.location.href = "/dashboard-ba"; // Redirect ke dashboard bagian akademik
            } else if (username === "dekan") {
                window.location.href = "/dashboard-dekan"; // Redirect ke dashboard dekan
            } else {
                alert("Username atau password salah. Silakan coba lagi.");
            }
        });
    </script>

</body>
</html>
