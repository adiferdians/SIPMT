@extends('layout.master')
@section('content')
@section('Dashboard', 'active')
@section('title', 'Certificate')

<!-- partial -->
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Selamat Datang {{ session('nama') ?? 'Tamu' }}!</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card tale-bg">
                <div class="card-people mt-auto">
                    <img src="assets/images/dashboard/people.svg" alt="people">
                    <div class="weather-info">
                        <div class="d-flex">
                            <div>
                                <h2 class="mb-0 font-weight-normal"><i class="me-2"></i>{{$cuaca['main']['temp']}}<sup>C</sup></h2>
                            </div>
                            <div class="ms-2">
                                <h4 class="location font-weight-normal">{{$cuaca['name']}}</h4>
                                <h6 class="font-weight-normal">Indonesia</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Karyawan Cuti</p>
                            <p class="fs-30 mb-2">{{$cuti}} Orang</p>
                            <p>Dari Total {{$anggota}} Karyawan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Perisalah Akan Datang</p>
                            <p class="fs-30 mb-2">{{$akanDatang}}</p>
                            <p>Dalam 1-2 Minggu Kedepan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-warning">
                        <div class="card-body">
                            <p class="mb-4">Perisalah Dalam Proses</p>
                            <p class="fs-30 mb-2">{{$dalamProses}}</p>
                            <p>Yang Belum Terselesaikan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-success">
                        <div class="card-body">
                            <p class="mb-4">Perisalah Terselesaikan</p>
                            <p class="fs-30 mb-2">{{$selesai}}</p>
                            <p>Dalam Durasi 30 Hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<!-- main-panel ends -->
@endsection