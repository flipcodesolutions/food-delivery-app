<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .login-header {
            background: #1f1f1f; /* matches your sidebar black */
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
        }

        .login-body {
            padding: 25px;
            background: #ffffff;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-login {
            background: #1f1f1f;
            color: #fff;
            border-radius: 8px;
            width: 100%;
        }

        .btn-login:hover {
            background: #000;
            color: #fff;
        }

        .error-text {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #000; /* your footer black text style */
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="card login-card">

    <!-- Header (matches sidebar brand style) -->
    <div class="login-header">Food Delivery App
        {{-- {{ config('app.name', 'Admin Panel') }} --}}
    </div>

    <div class="login-body">

        @if(session('error'))
            <div class="error-text">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password">
            </div>

            <button type="submit" class="btn btn-login">
                Login
            </button>
        </form>

       

    </div>
</div>

</body>
</html>