<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PythaLearn</title>

    <!-- Font & Bootstrap (mengikuti contoh) -->
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'PT Sans', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: #ffffff;
            color: #1f2937;
        }

        .info-card .card-header {
            background: #fff;
            border-bottom: 0;
        }

        .info-title {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .info-table td {
            vertical-align: top;
            padding: .25rem .75rem;
        }

        .profile-box img {
            max-width: 160px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #379080;
        }

        /* responsive tweak */
        @media (max-width: 767px) {
            .profile-box {
                margin-top: 1rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <main class="d-flex flex-column py-4">
        <div class="container">

            <a href="{{ url('/') }}" class="btn btn-outline-primary mb-3" style="border-radius:10px;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h2>Informasi Media</h2>

            <div class="row">
                <div class="col-12">
                    <div class="card info-card shadow-sm">
                        <div class="card-body p-4">
                            <p class="text-center mb-4">
                                Media pembelajaran ini dibuat untuk memenuhi persyaratan dalam menyelesaikan studi di program Strata-1 Pendidikan Komputer dengan judul:
                            </p>
                            <h1 class="text-center mb-4"><strong>
                                Penerapan Gamifikasi pada Web Pembelajaran Interaktif Teorema Pythagoras dengan Metode <i>Drill and Practice</i>
                            </strong></h1>
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="width:160px;"><strong>Nama</strong></td>
                                                <td>: <span class="text-muted">Muhammad Nur Fadhillah</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dosen Pembimbing 1</strong></td>
                                                <td>: <span class="text-muted">Dr. R. Ati Sukmawati, M.Kom.,</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dosen Pembimbing 2</strong></td>
                                                <td>: <span class="text-muted">Novan Alkaf Bahraini Saputra, S.Kom., M.T.,</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td>: <span class="text-muted"><a href="mailto:mnurfadhillah20@gmail.com">mnurfadhillah20@gmail.com</a></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jurusan</strong></td>
                                                <td>: <span class="text-muted">Pendidikan Komputer</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Fakultas</strong></td>
                                                <td>: <span class="text-muted">Fakultas Keguruan dan Ilmu Pendidikan</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Institusi</strong></td>
                                                <td>: <span class="text-muted">Universitas Lambung Mangkurat</span></td>
                                            </tr>
                                            <!-- Tambahkan baris lain jika perlu -->
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="mt-2">Daftar Pustaka</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card info-card shadow-sm">
                        <div class="card-body p-4">
                            <p class="mb-4">
                               Anam, A.C., As’ari,A.R., Taufiq, I., Tohir, M. (2022). Matematika untuk SMP/MTs Kelas VIII. Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi.
                            </p>
                            <p class="mb-4">
                                As’ari, A.R., Tohir, M., Valentino,E., Imron.Z., Taufiq, I. (2017). Buku Siswa Matematika Kelas VIII SMP/MTs Kurikulum 2013. Kementerian Pendidikan dan Kebudayaan
                            </p>
                            <p class="mb-4">
                                Nuharini, D., & Wahyuni, T. (2008). Matematika Konsep dan Aplikasinya: Untuk SMP/MTs Kelas VIII. Jakarta: Pusat Perbukuan, Departemen Pendidikan Nasional.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Optional: Bootstrap JS (jika diperlukan untuk komponen) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
