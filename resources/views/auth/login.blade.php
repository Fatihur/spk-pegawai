<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Penilaian Kinerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: #f7f8fc; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-container { width: 100%; max-width: 400px; padding: 20px; }
        .login-card { 
            background: #fff; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 40px;
        }
        .login-header { text-align: center; margin-bottom: 32px; }
        .login-header h4 { font-weight: 600; color: #1a202c; margin-bottom: 8px; }
        .login-header p { color: #718096; font-size: 14px; margin: 0; }
        .form-label { font-size: 13px; font-weight: 500; color: #1a202c; }
        .form-control { 
            padding: 12px 14px; 
            border: 1px solid #d1d5db; 
            border-radius: 8px; 
            font-size: 14px;
        }
        .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .btn-primary { 
            background: #4f46e5; 
            border: none; 
            padding: 12px; 
            font-weight: 500;
            border-radius: 8px;
        }
        .btn-primary:hover { background: #4338ca; }
        .alert { border-radius: 8px; font-size: 14px; border: none; background: #fef2f2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h4>SPK Penilaian Kinerja</h4>
                <p>DISKOMINFOTIKSAN Kab. Sumbawa</p>
            </div>
            @if($errors->any())
            <div class="alert mb-4">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
