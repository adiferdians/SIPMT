 @extends('layout.master')
 @section('content')
 @section('Risalah', 'active')
 @section('title', 'Risalah')
 <div class="content-wrapper">
     <div class="row" style="padding-bottom: 10px;">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card-body table-title">
                 <div class="judul">
                     <h3 class="font-weight-bold">Data Risalah</h3>
                     <h5 class="font-weight-bold">Kelola Data Risalah Setjen DPD RI</h5>
                 </div>
                 <div>
                     <button type="button" id="exportRisalah" class="btn btn-outline-success"><i class="mdi mdi-file-excel"></i> Export Data</button>
                     <button type="button" id="addRisalah" class="btn btn-info export"><i class="mdi mdi-account-plus"></i> Input Data</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body" style="padding: 15px 20px 0px 20px;">
                     <form method="GET" action="{{ route('risalah.index') }}" class="mb-3 d-flex gap-2 align-items-center">
                         <input type="text" name="search" value="{{ request('search') }}"
                             class="form-control" placeholder="Cari rapat atau perekam..." style="min-width: 500px; height:10px">
                         <select name="status" class="form-select filter" style="min-width: 200px;">
                             <option value="">Semua Status</option>
                             <option value="Belum Terlaksana" {{ request('status')=='Belum Terlaksana' ? 'selected' : '' }}>Belum Terlaksana</option>
                             <option value="Perekaman" {{ request('status')=='Perekaman' ? 'selected' : '' }}>Perekaman</option>
                             <option value="Transkripsi" {{ request('status')=='Transkripsi' ? 'selected' : '' }}>Transkripsi</option>
                             <option value="Risalah Sementara" {{ request('status')=='Risalah Sementara' ? 'selected' : '' }}>Risalah Sementara</option>
                             <option value="Risalah Validasi" {{ request('status')=='Risalah Validasi' ? 'selected' : '' }}>Risalah Validasi</option>
                         </select>
                         <button type="submit" class="btn btn-outline-info"><i class="mdi mdi-filter-outline" style="display: flex;"> Filter</i></button>
                         <a href="{{ route('risalah.index') }}" class="btn btn-outline-primary"><i class="mdi mdi-undo-variant" style="display: flex;"> Reset</i></a>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body">
                     <div class="table-responsive">
                         <table class="table table-striped table-borderless">
                             <thead>
                                 <tr>
                                     <th></th>
                                     <th>
                                         <h5 class="th-text">TANGGAL</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">JAM</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">PEREKAM</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">RAPAT</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">UNIT KERJA</h5>
                                     </th>
                                     <th class="center">
                                         <h5 class="th-text">STATUS</h5>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($risalah as $item)
                                 <tr>
                                     <td class="text-center align-middle">
                                         <div class="d-flex justify-content-center align-items-center">

                                             {{-- Edit --}}
                                             <button
                                                 type="button"
                                                 class="btn btn-action btn-outline-primary mr-2"
                                                 onclick="editRisalah({{ $item->id }})"
                                                 title="Edit">
                                                 <i class="mdi mdi-pencil-outline"></i>
                                             </button>

                                             {{-- More --}}
                                             <div class="dropdown">
                                                 <button
                                                     class="btn btn-action btn-outline-secondary"
                                                     type="button"
                                                     data-toggle="dropdown"
                                                     aria-haspopup="true"
                                                     aria-expanded="false">
                                                     <i class="mdi mdi-dots-vertical"></i>
                                                 </button>

                                                 <div class="dropdown-menu dm-risalah dropdown-menu-right shadow-sm">

                                                     {{-- Detail --}}
                                                     <a class="dropdown-item di-risalah"
                                                         href="javascript:void(0)"
                                                         onclick="viewRisalah({{ $item->id }})">
                                                         <i class="mdi mdi-eye-outline mr-2 text-secondary"></i>
                                                         Lihat Detail
                                                     </a>

                                                     @if(session('role') === 'admin')

                                                     {{-- Share --}}
                                                     <a class="dropdown-item"
                                                         target="_blank"
                                                         href="https://api.whatsapp.com/send?text={{ 
                                                                urlencode(
                                                                    'Teman-teman, menginformasikan kegiatan Perekaman *'.$item->rapat."* pada:\n\n".
                                                                    'Hari/Tgl : '.\Carbon\Carbon::parse($item->tgl)->locale('id')->dayName.
                                                                    ', '.\Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('DD MMM YYYY')."\n".
                                                                    'Perekam : '.$item->perekam_1.
                                                                    (isset($item->perekam_2) ? ' & '.$item->perekam_2 : '')."\n".
                                                                    'Pukul : '.$item->jam." WIB s.d. Selesai.\n".
                                                                    'Tempat : Ruang Rapat '.$item->tempat.' '.$item->nama_gedung."\n\n".
                                                                    'Agenda : '."\n".strip_tags($item->agenda)
                                                                )
                                                            }}">
                                                         <i class="mdi mdi-share-variant-outline mr-2 text-success"></i>
                                                         Bagikan
                                                     </a>

                                                     <div class="dropdown-divider"></div>

                                                     {{-- Delete --}}
                                                     <a class="dropdown-item text-danger"
                                                         href="javascript:void(0)"
                                                         onclick="deleteRisalah({{ $item->id }})">
                                                         <i class="mdi mdi-delete-outline mr-2"></i>
                                                         Hapus
                                                     </a>

                                                     @endif

                                                 </div>
                                             </div>

                                         </div>
                                     </td>
                                     <td class="table-text">{{ \Carbon\Carbon::parse($item->tgl)->locale('id')->dayName }},
                                         {{ \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('DD MMM') }}
                                     </td>
                                     <td class="table-text">{{$item->jam}}</td>
                                     <td class="table-text">
                                         @if ($item->perekam_2)
                                         {{$item->perekam_1}} & <br> {{$item->perekam_2}}
                                         @else
                                         {{$item->perekam_1}}
                                         @endif
                                     </td>
                                     <td class="table-text">{{$item->rapat}}</td>
                                     <td>{{$item->unit_kerja}}</td>
                                     <td>
                                         <button type="button" class="btn 
                                         {{$item->status == 'Risalah Validasi' ? 'btn btn-outline-success' : 
                                            ($item->status == 'Risalah Sementara' ? 'btn btn-outline-info' : 
                                            ($item->status == 'Transkripsi' ? 'btn btn-outline-warning' : 
                                            ($item->status == 'Perekaman' ? 'btn btn-outline-primary' : 
                                            'btn btn-outline-secondary')))
                                            }} dropdown-toggle"
                                             type="button" data-bs-toggle="dropdown" aria-expanded="false">{{$item->status}}
                                         </button>
                                         <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                                             <a class="dropdown-item" onclick="changeStatus('Belum Terlaksana', '{{$item->id}}')">Belum Terlaksana</a>
                                             <a class="dropdown-item" onclick="changeStatus('Perekaman', '{{$item->id}}')">Perekaman</a>
                                             <a class="dropdown-item" onclick="changeStatus('Transkripsi', '{{$item->id}}')">Transkripsi</a>
                                             <a class="dropdown-item" onclick="changeStatus('Risalah Sementara', '{{$item->id}}')">Risalah Sementara</a>
                                             @if(session('role') === 'admin')
                                             <a class="dropdown-item" onclick="changeStatus('Risalah Validasi', '{{$item->id}}')">Risalah Validasi</a>
                                             @endif
                                         </div>
                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                         {{ $risalah->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

@endsection <!-- Pastikan ini penutup dari @section('content') -->

@push('scripts')
<script>
    // 1. EVENT LISTENER: Harus di dalam $(function() {}) agar menunggu jQuery dimuat
    $(function() {
        $('#addRisalah').click(function() {
            axios.get('/createRisalah')
                .then(function(response) {
                    $('.modal-title').html("Tambahkan Risalah");
                    $('.modal-body').html(response.data);
                    $('#myModal').modal('show');
                })
                .catch(function(error) {
                    console.log(error);
                });
        });

        $('#exportRisalah').click(function() {
            axios.get('/exportRisalah')
                .then(function(response) {
                    $('.modal-title').html("Export Data Risalah");
                    $('.modal-body').html(response.data);
                    $('#myModal').modal('show');
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    });

    // 2. FUNGSI GLOBAL: HARUS DI LUAR $(function() {}) agar bisa dipanggil oleh atribut onclick="" di HTML
    function viewRisalah(id) {
        axios.get('/viewRisalah/' + id)
            .then(function(response) {
                $('.modal-title').html("Data Risalah");
                $('.modal-body').html(response.data);
                $('#myModal').modal('show');
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function editRisalah(id) {
        axios.get('/editRisalah/' + id)
            .then(function(response) {
                $('.modal-title').html("Data Risalah");
                $('.modal-body').html(response.data);
                $('#myModal').modal('show');
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function changeStatus(status, id) {
        Swal.fire({
            title: 'Ubah status Risalah?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/risalah/changeStatus/' + id, { status })
                    .then(() => {
                        Swal.fire({
                            title: 'Success',
                            position: 'top-end',
                            icon: 'success',
                            text: 'Status Risalah Diubah!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => location.reload(), 1600);
                    })
                    .catch((err) => {
                        Swal.fire({
                            title: 'Error',
                            position: 'top-end',
                            icon: 'error',
                            text: err,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
            }
        });
    }

    function deleteRisalah(id) {
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Data yang dihapus tidak dapat dipulihkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('deleteRisalah/' + id)
                    .then(() => {
                        Swal.fire({
                            title: 'Success',
                            position: 'top-end',
                            icon: 'success',
                            text: 'Data berhasil dihapus!',
                            showConfirmButton: false,
                            width: '400px',
                            timer: 3000
                        });
                        setTimeout(() => location.reload(), 1600);
                    })
                    .catch((err) => {
                        Swal.fire({
                            title: 'Error',
                            position: 'top-end',
                            icon: 'error',
                            text: err,
                            showConfirmButton: false,
                            width: '400px',
                            timer: 3000
                        });
                    });
            }
        });
    }
</script>
@endpush
 @endsection