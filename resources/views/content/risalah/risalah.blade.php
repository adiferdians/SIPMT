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
                             <option value="Pengeditan" {{ request('status')=='Pengeditan' ? 'selected' : '' }}>Pengeditan</option>
                             <option value="Risalah OK" {{ request('status')=='Risalah OK' ? 'selected' : '' }}>Risalah OK</option>
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
                                     <th class="center">
                                         <h5 class="th-text">STATUS</h5>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($risalah as $item)
                                 <tr>
                                     <td class="table-text">{{ \Carbon\Carbon::parse($item->tgl)->locale('id')->dayName }},
                                         {{ \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('DD MMM') }}
                                     </td>
                                     <td class="table-text">{{$item->jam}}</td>
                                     <td class="table-text">{{$item->perekam_1}}</td>
                                     <td class="table-text">{{$item->rapat}}</td>
                                     <td class="center table-text">
                                         <button type="button" class="btn 
                                         {{$item->status == 'Risalah OK' ? 'btn-success' : 
                                            ($item->status == 'Pengeditan' ? 'btn-info' : 
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
                                             <a class="dropdown-item center" onclick="changeStatus('Pengeditan', '{{$item->id}}')">Pengeditan</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" onclick="changeStatus('Risalah OK', '{{$item->id}}')">Risalah OK</a>
                                         </div>
                                     </td>
                                     <td style="display: flex; justify-content: center;">
                                         <button type="button" class="btn btn-outline-info"
                                             onclick="editRisalah({{$item->id}})"><i class="mdi mdi-pencil"></i></button>
                                         <button type="button" class="btn btn-outline-secondary"
                                             onclick="viewRisalah({{$item->id}})"><i class="mdi mdi-book-open-variant"></i></button>
                                         <button type="button" class="btn btn-outline-danger"
                                             onclick="deleteRisalah({{$item->id}})"><i class="mdi mdi-delete-forever"></i></button>
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