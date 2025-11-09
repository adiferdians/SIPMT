 @extends('layout.master')
 @section('content')
 @section('Risalah', 'active')
 @section('title', 'Risalah')
 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card title-card">
                 <div class="card-body table-title">
                     <div class="judul">
                         <h3 class="font-weight-bold">Data Risalah</h3>
                     </div>
                     <div>
                         <button type="button" id="exportRisalah" class="btn btn-success export"><i class="mdi mdi-file-excel"></i> Export Data</button>
                         <button type="button" id="addRisalah" class="btn btn-light"><i class="mdi mdi-account-plus"></i> Input Data</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card title-card" style="background-color: #cfcfcf;">
                 <div class="card-body table-title" style="padding: 10px 20px 0px 20px;">
                     <div class="judul">
                         <h3 class="font-weight-bold">Filter Data</h3>
                     </div>
                     <form method="GET" action="{{ route('risalah.index') }}" class="mb-3 d-flex gap-2 align-items-center">
                         <input type="text" name="search" value="{{ request('search') }}"
                             class="form-control" placeholder="Cari rapat atau perekam..." style="max-width: 250px;">

                         <select name="status" class="form-select" style="max-width: 180px;">
                             <option value="">-- Semua Status --</option>
                             <option value="Belum Terlaksana" {{ request('status')=='Belum Terlaksana' ? 'selected' : '' }}>Belum Terlaksana</option>
                             <option value="Perekaman" {{ request('status')=='Perekaman' ? 'selected' : '' }}>Perekaman</option>
                             <option value="Transkripsi" {{ request('status')=='Transkripsi' ? 'selected' : '' }}>Transkripsi</option>
                             <option value="Risalah Sementara" {{ request('status')=='Risalah Sementara' ? 'selected' : '' }}>Risalah Sementara</option>
                             <option value="Risalah Validasi" {{ request('status')=='Risalah Validasi' ? 'selected' : '' }}>Risalah Validasi</option>
                         </select>

                         <button type="submit" class="btn btn-primary">Filter</button>
                         <a href="{{ route('risalah.index') }}" class="btn btn-warning">Reset</a>
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
                                     <td style="display: grid; justify-content: center;">
                                         <div>
                                             <button type="button" class="btn btn-risalah btn-outline-info"
                                                 onclick="editRisalah({{$item->id}})"><i class="mdi mdi-pencil"></i></button>
                                             <button type="button" class="btn btn-risalah btn-outline-secondary"
                                                 onclick="viewRisalah({{$item->id}})"><i class="mdi mdi-book-open-variant"></i></button>
                                         </div>
                                         @if(session('role') === 'admin')
                                         <div>
                                             <button type="button" class="btn btn-risalah btn-outline-danger"
                                                 onclick="deleteRisalah({{$item->id}})"><i class="mdi mdi-delete-forever"></i></button>
                                             <a href="whatsapp://send?text={{ 
                                                    urlencode(
                                                        'Teman-teman, menginformasikan kegiatan Perekaman ' . $item->rapat . " pada:\n\n" .
                                                        'Hari/Tgl'. "\t: " . \Carbon\Carbon::parse($item->tgl)->locale('id')->dayName . 
                                                        ', ' . \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('DD MMM YYYY') . "\n" .
                                                        'Perekam'. "\t: " . $item->perekam_1 . 
                                                        (isset($item->perekam_2) ? ' & ' . $item->perekam_2 : '') . "\n" .
                                                        'Pukul'. "\t: ". $item->jam . ' WIB s.d. Selesai.' . "\n" .
                                                        'Tempat'. "\t: ".'Ruang Rapat ' . $item->tempat . $item->nama_gedung . "\n\n" .
                                                        'Agenda:' . "\n" . $item->agenda
                                                    )
                                                    }}"
                                                 data-action="share/whatsapp/share"
                                                 target="_blank"
                                                 class="btn-risalah btn-outline-success mx-1"
                                                 style="text-decoration: none;">

                                                 <button type="button" class="btn btn-share btn-outline-success" style="padding: 10px;">
                                                     <i class="mdi mdi-share"></i>
                                                 </button>
                                             </a>
                                         </div>
                                         @endif
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
                                     <td class="center table-text">
                                         <button type="button" class="btn 
                                         {{$item->status == 'Risalah Validasi' ? 'btn-success' : 
                                            ($item->status == 'Risalah Sementara' ? 'btn-info' : 
                                            ($item->status == 'Transkripsi' ? 'btn-warning' : 
                                            ($item->status == 'Perekaman' ? 'btn-primary' : 
                                            'btn-secondary')))
                                            }} dropdown-toggle dropdown-text"
                                             type="button" data-bs-toggle="dropdown" aria-expanded="false">{{$item->status}}
                                         </button>
                                         <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                                             <a class="dropdown-item center" onclick="changeStatus('Belum Terlaksana', '{{$item->id}}')">Belum Terlaksana</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" onclick="changeStatus('Perekaman', '{{$item->id}}')">Perekaman</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" onclick="changeStatus('Transkripsi', '{{$item->id}}')">Transkripsi</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" onclick="changeStatus('Risalah Sementara', '{{$item->id}}')">Risalah Sementara</a>
                                             @if(session('role') === 'admin')
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" onclick="changeStatus('Risalah Validasi', '{{$item->id}}')">Risalah Validasi</a>
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


 <script>
     $('#addRisalah').click(function() {
         axios.get('/createRisalah')
             .then(function(response) {
                 $('.modal-title').html("Tambahkan Risalah");
                 $(".modal-dialog");
                 $('.modal-body').html(response.data);
                 $('#myModal').modal('show');
             })
             .catch(function(error) {
                 console.log(error);
             });
     })

     $('#exportRisalah').click(function() {
         axios.get('/exportRisalah')
             .then(function(response) {
                 $('.modal-title').html("Export Data Risalah");
                 $(".modal-dialog");
                 $('.modal-body').html(response.data);
                 $('#myModal').modal('show');
             })
             .catch(function(error) {
                 console.log(error);
             });
     })

     function viewRisalah(id) {
         axios.get('/viewRisalah/' + id)
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

     function editRisalah(id) {
         axios.get('/editRisalah/' + id)
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

     function changeStatus(status, id) {
         console.log(status, id);

         Swal.fire({
             title: 'Ubah status Risalah?',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Ubah'
         }).then((result) => {
             if (result.isConfirmed) {
                 if (result.isConfirmed) {
                     axios.post('/risalah/changeStatus/' + id, {
                             status,
                         }).then(() => {
                             Swal.fire({
                                 title: 'Success',
                                 position: 'top-end',
                                 icon: 'success',
                                 text: 'Status Risalah Diubah!',
                                 showConfirmButton: false,
                                 timer: 1500
                             });
                             setTimeout(() => {
                                 location.reload();
                             }, 1600);
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
             }
         })
     };

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
                         setTimeout(() => {
                             location.reload();
                         }, 1600);
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
 @endsection