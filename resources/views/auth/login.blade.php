<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Masuk</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        :root {
            --primary: #379080;
            --light: #f6fdfc;
        }

        body {
            min-height: 100vh;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        }

        .login-wrapper {
            width: 100%;
            max-width: 980px;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,.08);
        }

        /* KIRI (FORM) */
        .login-left {
            padding: 3rem;
        }

        .login-left h3 {
            font-weight: 700;
            color: #222;
        }

        .login-left p {
            color: #777;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.15rem rgba(55,144,128,.25);
        }

        /* KANAN (GAMBAR) */
        .login-right {
            background: linear-gradient(135deg, #e6f4f1, #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-right img {
            max-width: 100%;
            height: auto;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .login-right {
                display: none;
            }

            .login-left {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper row g-0">

    <!-- LEFT -->
    <div class="col-md-6 login-left">
        <h3 class="mb-2">Masuk</h3>

        {{-- ERROR LOGIN --}}
        @if ($errors->has('email'))
            <div class="alert alert-danger small">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            {{-- TAMBAHAN: DROPDOWN ROLE --}}
            <div class="form-floating mb-3">
                <select name="role" class="form-select" required>
                    <option value="siswa" selected>Siswa</option>
                    <option value="guru">Guru</option>
                </select>
                <label>Masuk Sebagai</label>
            </div>
            {{-- AKHIR TAMBAHAN --}}

            <div class="form-floating mb-3">
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="name@example.com"
                       value="{{ old('email') }}"
                       required autofocus>
                <label>Email</label>
            
            </div>
                <div class="form-floating mb-3 position-relative">
                    <input type="password"
                        name="password"
                        class="form-control pe-5"
                        id="password"
                        placeholder="Password"
                        required>

                    <label for="password">Password</label>

                    <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3"
                    id="togglePassword"
                    style="cursor: pointer; z-index: 10;"></i>
                </div>



            {{-- Sisa kode (checkbox remember me, tombol, dll) biarkan sama... --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-success py-2">
                    Masuk
                </button>
            </div>

            <div class="d-grid mb-3">
                <a href="/" class="btn btn-outline-primary py-2">
                    Kembali ke Beranda
                </a>
            </div>
        </form>

        <div class="text-center small mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="fw-semibold">
                Daftar di sini
            </a>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-md-6 login-right">
        <img src="{{ asset("/images/ornamen_login.png") }}" alt="Ilustrasi Login">
    </div>

</div>

<script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const password = document.getElementById("password");
    const icon = this;

    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        password.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
