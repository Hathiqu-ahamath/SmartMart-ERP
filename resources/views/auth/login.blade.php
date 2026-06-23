<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartMart ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1E1B2E 0%, #7C3AED 50%, #A78BFA 100%); min-height: 100vh; display: flex; align-items: center; font-family: 'Fira Sans', sans-serif; }
        .login-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.25); overflow: hidden; border: 1px solid rgba(255,255,255,0.2); }
        .login-header { background: linear-gradient(135deg, #1E1B2E, #7C3AED); color: #fff; padding: 32px; text-align: center; }
        .login-header h3 { margin: 0; font-weight: 700; }
        .login-header h3 i { color: #A78BFA; }
        .login-header p { margin: 6px 0 0; opacity: 0.8; font-size: 0.85rem; }
        .login-body { padding: 32px; }
        .form-control { border-radius: 10px; padding: 12px 16px; border: 1.5px solid #E5E7EB; font-family: 'Fira Sans', sans-serif; transition: all 0.2s; }
        .form-control:focus { border-color: #7C3AED; box-shadow: 0 0 0 3px rgba(124,58,237,0.12); }
        .input-group-text { border-radius: 10px 0 0 10px; border: 1.5px solid #E5E7EB; border-right: none; background: #F9FAFB; color: #7C3AED; }
        .btn-login { background: linear-gradient(135deg, #7C3AED, #5B21B6); color: #fff; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; border: none; transition: all 0.2s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(124,58,237,0.35); }
        .form-check-input:checked { background-color: #7C3AED; border-color: #7C3AED; }
        a { color: #7C3AED; text-decoration: none; font-weight: 500; }
        a:hover { color: #5B21B6; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <h3><i class="bi bi-shop"></i> SmartMart ERP</h3>
                        <p>Enterprise Resource Planning System</p>
                    </div>
                    <div class="login-body">
                        @if($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first('email') }}</div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="email">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn-login">Sign In</button>
                        </form>
                        <div class="text-center mt-3">
                            <small class="text-secondary">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
