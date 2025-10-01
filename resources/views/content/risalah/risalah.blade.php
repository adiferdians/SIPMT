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
                         <button type="button" id="addRisalah" class="btn btn-light"><i class="mdi mdi-account-plus"></i> Input Data</button>
                     </div>
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
                                         <h4 class="th-text">TANGGAL</h4>
                                     </th>
                                     <th>
                                         <h4 class="th-text">JAM</h4>
                                     </th>
                                     <th>
                                         <h4 class="th-text">PEREKAM</h4>
                                     </th>
                                     <th>
                                         <h4 class="th-text">RAPAT</h4>
                                     </th>
                                     <th class="center">
                                         <h4 class="th-text">STATUS</h4>
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
                                             <a class="dropdown-item center" href="#">Belum Terlaksana</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" href="#">Perekaman</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" href="#">Transkripsi</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" href="#">Pengeditan</a>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item center" href="#">Risalah OK</a>
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

     function ediddtRisalah() {
         const id = $('#id').val();
         const unit_kerja = $('#unit_kerja').val();
         const tgl = $('#tgl').val();
         const jam = $('#jam').val();
         const tempat = $('#tempat').val();
         const perekam_1 = $('#perekam_1').val();
         const perekam_2 = $('#perekam_2').val();
         const transkrip = $('#transkrip').val();
         const editor = $('#editor').val();
         const rapat = $('#rapat').val();
         const agenda = $('#agenda').val();

         axios.post('/storeRisalah/' + id, {
             unit_kerja,
             tgl,
             jam,
             tempat,
             perekam_1,
             perekam_2,
             transkrip,
             editor,
             rapat,
             agenda
         }).then((response) => {
             Swal.fire({
                 title: 'Success...',
                 position: 'top-end',
                 icon: 'success',
                 text: 'Success! Data added successfully.',
                 showConfirmButton: false,
                 width: '400px',
                 timer: 3000
             }).then((response) => {
                 location.reload();
             })
         }).catch((err) => {
             console.log(err);
             Swal.fire({
                 title: 'Error',
                 position: 'top-end',
                 icon: 'error',
                 text: err.response.data.error.details,
                 showConfirmButton: false,
                 width: '400px',
                 timer: 3000
             })
         })
     }

     function deleteRisalah(id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "The deleted data cannot be recovered!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonText: 'Delete',
             cancelButtonText: 'Cancle',
             reverseButtons: true
         }).then((result) => {
             if (result.isConfirmed) {
                 axios.post('deleteRisalah/' + id)
                     .then(() => {
                         Swal.fire({
                             title: 'Success',
                             position: 'top-end',
                             icon: 'success',
                             text: 'Data deleted successfuly!',
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