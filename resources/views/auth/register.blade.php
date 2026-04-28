<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

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

        .register-wrapper {
            width: 100%;
            max-width: 980px;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .08);
        }

        /* KIRI (FORM) */
        .register-left {
            padding: 3rem;
        }

        .register-left h3 {
            font-weight: 700;
            color: #222;
        }

        .register-left p {
            color: #777;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.15rem rgba(55, 144, 128, .25);
        }

        /* KANAN (GAMBAR) */
        .register-right {
            background: linear-gradient(135deg, #e6f4f1, #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-right img {
            max-width: 100%;
            height: auto;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .register-right {
                display: none;
            }

            .register-left {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="register-wrapper row g-0">

        <!-- LEFT -->
        <div class="col-md-6 register-left">
            <h3 class="mb-2">Buat Akun</h3>
            <p class="mb-4">Lengkapi data berikut untuk membuat akun baru</p>

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}">
                @csrf

                {{-- NAMA --}}
                <div class="form-floating mb-3">
                    <input type="text"
                        name="name"
                        class="form-control"
                        placeholder="Nama Lengkap"
                        value="{{ old('name') }}"
                        required>
                    <label>Nama Lengkap</label>
                </div>

                {{-- EMAIL --}}
                <div class="form-floating mb-3">
                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="name@example.com"
                        value="{{ old('email') }}"
                        required>
                    <label>Email</label>
                </div>

                {{-- PASSWORD --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password"
                                name="password"
                                class="form-control"
                                placeholder="Password"
                                required>
                            <label>Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Konfirmasi Password"
                                required>
                            <label>Konfirmasi Password</label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <select name="role" id="role-select" class="form-select" required>
                        <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    <label>Daftar Sebagai</label>
                </div>

                {{-- FORM TOKEN GURU (DISEMBUNYIKAN SECARA DEFAULT) --}}
                <div class="form-floating mb-3" id="token-wrapper" style="display: none;">
                    <input type="text"
                        name="guru_token"
                        id="guru_token"
                        class="form-control"
                        placeholder="Token Registrasi Guru"
                        value="{{ old('guru_token') }}">
                    <label>Token Registrasi Guru</label>
                    <div class="form-text text-muted small px-1">Dapatkan token pendaftaran dari Admin.</div>
                </div>
                {{-- AKHIR TAMBAHAN --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success py-2">
                        Daftar
                    </button>
                </div>

                <div class="d-grid">
                    <a href="/" class="btn btn-outline-primary py-2">
                        Kembali ke Beranda
                    </a>
                </div>
            </form>

            <div class="text-center small mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="fw-semibold">
                    Masuk di sini
                </a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6 register-right">
            <!-- GANTI SRC DENGAN FOTO MILIKMU -->
            <img src="{{ asset("/images/ornamen_register.png") }}" alt="Ilustrasi Register">
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const roleSelect = document.getElementById("role-select");
            const tokenWrapper = document.getElementById("token-wrapper");
            const tokenInput = document.getElementById("guru_token");

            function toggleTokenForm() {
                if (roleSelect.value === "guru") {
                    tokenWrapper.style.display = "block";
                    tokenInput.setAttribute("required", "required");
                } else {
                    tokenWrapper.style.display = "none";
                    tokenInput.removeAttribute("required");
                    tokenInput.value = ""; // Kosongkan token jika pengguna batal memilih guru
                }
            }

            // Dengarkan perubahan pada dropdown
            roleSelect.addEventListener("change", toggleTokenForm);

            // Jalankan sekali saat halaman dimuat (berguna untuk mempertahankan form jika ada error validasi)
            toggleTokenForm();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>