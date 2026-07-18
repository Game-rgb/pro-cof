<!DOCTYPE html>
<html>
<head>
    <title>Coffee Shop - Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5ede4 0%, #e8d5c4 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            width: 420px;
            padding: 45px 40px 35px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(44, 26, 14, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .logo {
            text-align: center;
            font-size: 60px;
            margin-bottom: 5px;
        }

        .shop-name {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: #2c1a0e;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .shop-sub {
            text-align: center;
            font-size: 13px;
            color: #8b6b4f;
            margin-bottom: 30px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .form-group { 
            margin-bottom: 22px; 
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2c1a0e;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e8ddd0;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
            background: #fcf9f7;
            transition: all 0.3s ease;
            color: #2c1a0e;
        }

        .form-group input:focus { 
            border-color: #8b4513; 
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.08);
        }

        .form-group input::placeholder {
            color: #b8a392;
            font-weight: 300;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-options label {
            font-size: 13px;
            color: #6b4f38;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .form-options input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #8b4513;
            cursor: pointer;
        }

        .form-options a {
            font-size: 13px;
            color: #8b4513;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .form-options a:hover {
            color: #5c2d0e;
            text-decoration: underline;
        }

        .alert-error {
            background-color: #fdf2f2;
            border: 1px solid #fcd5d5;
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-error p {
            margin: 2px 0;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6f3200 0%, #8b4513 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.2);
        }

        .btn-login:hover { 
            background: linear-gradient(135deg, #5c2d0e 0%, #7a3b10 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
        }

        .btn-login:active {
            transform: translateY(0px);
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #b8a392;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .footer-text span {
            color: #8b4513;
        }

        /* Demo credentials */
        .demo-creds {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0e6dc;
            text-align: center;
        }

        .demo-creds p {
            font-size: 12px;
            color: #8b6b4f;
            margin-bottom: 5px;
        }

        .demo-creds .cred {
            font-size: 12px;
            color: #6b4f38;
            font-weight: 500;
            display: inline-block;
            margin: 0 10px;
            background: #f5ede4;
            padding: 3px 10px;
            border-radius: 6px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px 25px;
                width: 100%;
            }
            
            .form-options {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="logo">☕</div>
    <div class="shop-name">Coffee Shop</div>
    <div class="shop-sub">POS System — Please login to continue</div>

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>✕ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label> Email</label>
            <input type="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   placeholder="Enter your email" 
                   autofocus
                   required>
        </div>

        <div class="form-group">
            <label> Password</label>
            <input type="password" 
                   name="password" 
                   placeholder="Enter your password"
                   required>
        </div>


        <button type="submit" class="btn-login">Login →</button>
    </form>

    <!-- Demo Credentials (remove in production) -->
    <div class="demo-creds">
        <p>Demo Credentials:</p>
        <span class="cred">admin@example.com / AdminPass123</span>
        <span class="cred">user@example.com / UserPass123</span>
    </div>

    <div class="footer-text">☕ Serving the best coffee since <span>2024</span></div>
</div>
</body>
</html>