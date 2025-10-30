<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPMT - @yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style-custom.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo me-5" href="index.html"><img src="assets/images/logo.png" class="me-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="assets/images/faces/user.png" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" id="seting">
                                <i class="ti-settings text-primary"></i> Settings </a>
                            <a class="dropdown-item" id="logout">
                                <i class="ti-power-off text-primary"></i> Logout </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item @yield('Dashboard')">
                        <a class="nav-link" href="/dashboard">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Rislah')">
                        <a class="nav-link" href="/risalah">
                            <i class="ti-book menu-icon"></i>
                            <span class="menu-title">Risalah</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Anggota')">
                        <a class="nav-link" href="/anggota">
                            <i class="ti-user menu-icon"></i>
                            <span class="menu-title">Anggota</span>
                        </a>
                    </li>
                    <li class="nav-item @yield('Laporan')">
                        <a class="nav-link" href="/laporan-harian">
                            <i class="icon-paper menu-icon"></i>
                            <span class="menu-title">Laporan Harian</span>
                        </a>
                    </li>
                    @if (session('role') === 'admin')
                    <li class="nav-item @yield('Pendukung')">
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
                    @endif
                </ul>
            </nav>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="color: white;">
                            <h3 class="modal-title" id="exampleModalLongTitle">Modal title</h3>
                        </div>
                        <div class="modal-body">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content -->
            <div class="main-panel">
                @yield('content')

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025. Bagian Perisalah Sekretariat Jendral DPD RI</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- </div> -->

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script>
        $('#seting').click(function() {
            $(location).attr('href', '/ubahPassword');
        });


        $('#logout').click(function() {
            Swal.fire({
                title: 'Apa anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get('/logout')
                        .then(response => {
                            window.location.href = '/l051n';
                        })
                        .catch(error => {
                            console.log(error.response.data);
                        });

                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Batal',
                        'error'
                    )
                }
            })
        })
    </script>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    @stack('scripts')
</body>

</html>