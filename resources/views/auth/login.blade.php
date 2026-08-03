<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - SIMAPAN</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <div class="login-container">
        <!-- Kolom Kiri -->
        <div class="login-left">
            <h1> SIMAPAN</h1>
            <p class="welcome-text">Sistem Informasi Manajemen & Penjadwalan Risalah DPD RI</a></p>

            <form id="loginForm">
                <!-- Label diubah ke Email menyesuaikan script js sebelumnya -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" required>
                </div>
                <br><br>
                <button type="submit" class="btn-submit" id="submit">Sign In</button>
            </form>
        </div>

        <!-- Kolom Kanan -->
        <div class="login-right">
            <!-- Ganti src di bawah dengan path aset gambar ilustrasi Anda -->
            <img src="assets/images/illustration2.jpg" alt="Login Illustration">
        </div>
    </div>

    <!-- Script Logika Auth (Dioptimalkan dari kode sebelumnya) -->
    <script>
        $(function() {
            $('#email').focus();

            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const email = $('#email').val();
                const password = $('#password').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (!csrfToken) {
                    return Swal.fire({
                        text: 'Token keamanan tidak ditemukan. Coba reload halaman.',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }

                const $submitBtn = $('#submit');
                const originalBtnText = $submitBtn.text();
                $submitBtn.prop('disabled', true).text('Loging In...');

                axios.post('/auth', { email, password }, {
                    withCredentials: true,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                .then(response => {
                    const data = response.data;
                    
                    if (data.OUT_STAT) {
                        Swal.fire({
                            text: data.MESSAGE || 'Login berhasil!',
                            position: 'top-end',
                            icon: 'success',
                            width: '300px',
                            showConfirmButton: false,
                            timer: 2000,
                            background: '#18ba2a',
                            color: '#ffff',
                        }).then(() => {
                            window.location.href = "/dashboard";
                        });
                    } else {
                        $submitBtn.prop('disabled', false).text(originalBtnText);
                        Swal.fire({
                            text: data.MESSAGE || 'Email atau password salah!',
                            position: 'top-end',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500,
                            width: '400px',
                        });
                    }
                })
                .catch(error => {
                    $submitBtn.prop('disabled', false).text(originalBtnText);
                    console.error('Error:', error.response || error);
                    Swal.fire({
                        text: 'Terjadi kesalahan saat menghubungi server.',
                        position: 'top-end',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500,
                        width: '400px',
                    });
                });
            });
        });
    </script>
</body>

</html>