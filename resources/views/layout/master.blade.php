<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAPAN - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- 3rd Party CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/styles/ht-theme-main.min.css" />

    <!-- Template & Plugin CSS -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style-custom.css">
</head>

<body>
    <!-- Script Anti-FOUC (Mencegah kedipan sidebar saat pertama load) -->
    <script>
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-icon-only');
        }
    </script>

    <div class="container-scroller">
        <!-- Navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo me-5" href="/dashboard">
                    <img src="assets/images/logo.png" class="me-2" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="/dashboard">
                    <img src="assets/images/logo-mini.png" alt="logo">
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right ms-auto">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="assets/images/faces/user.png" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="/ubahPassword" id="seting">
                                <i class="ti-settings text-primary"></i> Settings
                            </a>
                            <a class="dropdown-item" href="#" id="logout">
                                <i class="ti-power-off text-primary"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">

                    <!-- MULAI: Papan Informasi Akun Sidebar -->
                    <li class="nav-item w-100 px-3 py-3 mb-2 border-bottom profile-panel-item">
                        <div class="sidebar-profile-panel text-center w-100">
                            <!-- Foto Profil & Status -->
                            <div class="profile-avatar-wrapper mb-1 mx-auto">
                                <img src="assets/images/faces/profil.jpg" alt="Profile" class="profile-avatar rounded-circle">
                            </div>

                            <!-- Role & Identitas -->
                            <div class="profile-role mb-2 ">
                                <span class="badge badge-pill badge-custom-purple px-3 py-2 text-white">
                                    {{ session('nama') }}
                                </span>
                            </div>
                            <h5 class="profile-name font-weight-bold mb-1 text-dark" style="font-size: 0.8rem;">{{ session('jabatan') }}</h5>
                            <p class="profile-title text-muted small mb-0" style="line-height: 1.3;">{{ session('nip') }}</p>
                        </div>
                    </li>
                    <!-- AKHIR: Papan Informasi Akun Sidebar -->

                    <li class="nav-item @yield('Dashboard')">
                        <a class="nav-link" href="/dashboard">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Risalah')">
                        <a class="nav-link" href="/risalah">
                            <i class="ti-book menu-icon"></i>
                            <span class="menu-title">Risalah</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Jadwal')">
                        <a class="nav-link" href="/allData">
                            <i class="ti-notepad menu-icon"></i>
                            <span class="menu-title">Jadwal</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Anggota')">
                        <a class="nav-link" href="/anggota">
                            <i class="ti-user menu-icon"></i>
                            <span class="menu-title">Anggota</span>
                        </a>
                    </li>

                    <!-- 1. DATA PENDUKUNG -->
                    <li class="nav-item @yield('Pendukung') menu-data-pendukung">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Data Pendukung</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item @yield('Unit')"><a class="nav-link" href="/unit-kerja">Unit Kerja</a></li>
                                <li class="nav-item @yield('Ruang')"><a class="nav-link" href="/ruang-rapat">Ruang Rapat</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- 2. MENU TERPISAH -->
                    <li class="nav-item @yield('Unit') menu-standalone-sub">
                        <a class="nav-link" href="/unit-kerja" title="Unit Kerja">
                            <i class="ti-layout-grid2 menu-icon"></i>
                            <span class="menu-title">Unit Kerja</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Ruang') menu-standalone-sub">
                        <a class="nav-link" href="/ruang-rapat" title="Ruang Rapat">
                            <i class="ti-location-pin menu-icon"></i>
                            <span class="menu-title">Ruang Rapat</span>
                        </a>
                    </li>
                </ul>
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block footer">
                    © 2026 Risalah - Setjen DPD RI
                </span>
            </nav>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">Modal title</h3>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="main-panel">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- 3rd Party Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <!-- Template Scripts -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>

    <!-- Custom Logic -->
    <script>
        $(function() {
            const body = $('body');
            const tooltipText = $('#toggleTooltipText');

            // Fungsi Update Teks Tooltip
            const updateTooltipText = () => {
                if (tooltipText.length) {
                    tooltipText.text(body.hasClass('sidebar-icon-only') ? 'Buka sidebar' : 'Tutup sidebar');
                }
            };

            // Inisialisasi awal
            updateTooltipText();

            // GUNAKAN KODE INI
            $('[data-toggle="minimize"]').on('click', function() {
                // Beri jeda 50ms agar template.js mengeksekusi toggle class-nya lebih dulu
                setTimeout(() => {
                    const isCollapsed = $('body').hasClass('sidebar-icon-only');
                    localStorage.setItem('sidebar-collapsed', isCollapsed);
                    updateTooltipText();
                }, 50);
            });

            // Handle Logout
            $('#logout').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apa Anda yakin ingin keluar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get('/logout')
                            .then(() => window.location.href = '/l051n')
                            .catch(error => console.error(error.response?.data || error));
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>