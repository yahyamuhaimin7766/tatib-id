<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TATIB.ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            /* Menggunakan gradient yang sama seperti sidebar untuk konsistensi */
            background-color: #1d2b64;
            background-image: linear-gradient(160deg, #1d2b64 0%, #4a54c8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 0.75rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="card login-card p-4">
        <div class="card-body text-center">

            {{-- ======================================================= --}}
            {{-- LOGO DITEMPATKAN DI SINI --}}
            {{-- ======================================================= --}}
            <img src="{{ asset('images/contohlogo.png') }}" alt="Logo Sekolah" class="login-logo">

            <h3 class="mb-1">SITATIB</h3>
            <p class="text-muted mb-4">Sistem Tata Tertib Sekolah</p>

            {{-- ======================================================= --}}
            {{-- UNTUK MENAMPILKAN PESAN ERROR JIKA LOGIN GAGAL --}}
            {{-- ======================================================= --}}
            @if (session('error'))
                <div class="alert alert-danger text-start" role="alert">
                    <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger text-start" role="alert">
                    <i class="fas fa-times-circle me-2"></i>Password yang anda masukan salah
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
