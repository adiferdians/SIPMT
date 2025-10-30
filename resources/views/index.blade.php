@extends('layout.master')
@section('content')
@section('Dashboard', 'active')
@section('title', 'Dashboard')

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
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Jumlah Karyawan Cuti</p>
                            <p class="fs-30 mb-2">{{$cuti}} Orang</p>
                            <p>Dari Total {{$anggota}} Karyawan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Risalah Hari Ini</p>
                            <p class="fs-30 mb-2">{{$akanDatang}} Risalah</p>
                            <p> </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-warning">
                        <div class="card-body">
                            <p class="mb-4">Risalah Dalam Proses</p>
                            <p class="fs-30 mb-2">{{$dalamProses}} Risalah</p>
                            <p>Yang Belum Terselesaikan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-success">
                        <div class="card-body">
                            <p class="mb-4">Risalah Terselesaikan</p>
                            <p class="fs-30 mb-2">{{$selesai}} Risalah</p>
                            <p>Dalam Durasi 30 Hari Terakhir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
<script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            displayEventTime: false,
            events: '{{ route("kalender.agenda") }}',
            selectable: true,
            dateClick: function(info) {
                const tgl = info.dateStr;
                axios.get('/createRisalah', {
                        params: {
                            tgl_agenda: tgl
                        }
                    }).then(function(response) {
                        $('.modal-title').html("Tambahkan Risalah");
                        $(".modal-dialog");
                        $('.modal-body').html(response.data);
                        $('#myModal').modal('show');
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                var risalahId = info.event.id;

                axios.get('/viewRisalah/' + risalahId)
                    .then(function(response) {
                        $('.modal-title').html("Data Risalah");
                        $(".modal-dialog");
                        $('.modal-body').html(response.data);
                        $('#myModal').modal('show');
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        });

        calendar.render();
    });
</script>
@endpush
@endsection