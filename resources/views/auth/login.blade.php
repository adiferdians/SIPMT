<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="assets/css/style-custom.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="page">
        <div class="container">
            <div class="left">
                <div class="login">Log In</div>
                <div class="eula">Selamat pagi, silahkan Log In untuk mengakses aplikasi.</div>
            </div>
            <div class="right">
                <svg viewBox="0 0 320 300">
                    <defs>
                        <linearGradient
                            inkscape:collect="always"
                            id="linearGradient"
                            x1="13"
                            y1="193.49992"
                            x2="307"
                            y2="193.49992"
                            gradientUnits="userSpaceOnUse">
                            <stop
                                style="stop-color:#ff00ff;"
                                offset="0"
                                id="stop876" />
                            <stop
                                style="stop-color:#ff0000;"
                                offset="1"
                                id="stop878" />
                        </linearGradient>
                    </defs>
                    <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
                </svg>
                <div class="form">
                    <label for="email">Email</label>
                    <input type="email" id="email">
                    <label for="password">Password</label>
                    <input type="password" id="password">
                    <input type="submit" id="submit" value="Submit">
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('#submit').on('click', function(e) {
        e.preventDefault(); // 🔒 Mencegah form reload

        const email = $('#email').val();
        const password = $('#password').val();

        // 🔍 Ambil CSRF token dengan aman
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

        if (!csrfToken) {
            console.error('CSRF token tidak ditemukan di meta tag!');
            Swal.fire({
                text: 'Token keamanan tidak ditemukan. Coba reload halaman.',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }

        axios.post(
                '/auth', {
                    email,
                    password,
                }, {
                    withCredentials: true, // 🔥 agar cookie session dikirim
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                }
            )
            .then(response => {
                const data = response.data;
                console.log('Response:', data);

                if (data.OUT_STAT) {
                    Swal.fire({
                        text: data.MESSAGE || 'Login berhasil!',
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000,
                        customClass: {
                            icon: 'my-custom-icon-class'
                        },
                    }).then(() => {
                        window.location.href = "/dashboard";
                    });
                } else {
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


    var current = null;
    document.querySelector('#email').addEventListener('focus', function(e) {
        if (current) current.pause();
        current = anime({
            targets: 'path',
            strokeDashoffset: {
                value: 0,
                duration: 700,
                easing: 'easeOutQuart'
            },
            strokeDasharray: {
                value: '240 1386',
                duration: 700,
                easing: 'easeOutQuart'
            }
        });
    });
    document.querySelector('#password').addEventListener('focus', function(e) {
        if (current) current.pause();
        current = anime({
            targets: 'path',
            strokeDashoffset: {
                value: -336,
                duration: 700,
                easing: 'easeOutQuart'
            },
            strokeDasharray: {
                value: '240 1386',
                duration: 700,
                easing: 'easeOutQuart'
            }
        });
    });
    document.querySelector('#submit').addEventListener('focus', function(e) {
        if (current) current.pause();
        current = anime({
            targets: 'path',
            strokeDashoffset: {
                value: -730,
                duration: 700,
                easing: 'easeOutQuart'
            },
            strokeDasharray: {
                value: '530 1386',
                duration: 700,
                easing: 'easeOutQuart'
            }
        });
    });
</script>

</html>