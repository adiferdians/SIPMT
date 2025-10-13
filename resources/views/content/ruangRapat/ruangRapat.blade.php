 @extends('layout.master')
 @section('Anggota', 'active')
 @section('title', 'Ruang Rapat')
 @section('content')

 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card title-card">
                 <div class="card-body table-title">
                     <div class="judul">
                         <h3 class="font-weight-bold">Data Ruang Rapat</h3>
                     </div>
                     <div>
                         <button type="button" id="addAnggota" class="btn btn-light"><i class="mdi mdi-account-plus"></i> Input Data</button>
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
                                     <th>No</th>
                                     <th>Nama</th>
                                     <th>Lantai</th>
                                     <th style="display: flex; justify-content: center;">Action</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($ruang as $item)
                                 <tr>
                                     <td class="font-weight-bold">{{$item->id}}</td>
                                     <td class="font-weight-bold">{{$item->nama}}</td>
                                     <td class="font-weight-bold">{{$item->lantai}}</td>
                                     <td style="display: flex; justify-content: center;">
                                         <button type="button" class="btn btn-outline-info" onclick="editRuangRapat({{$item->id}})"><i class="mdi mdi-pencil"></i></button>
                                         <button type="button" class="btn btn-outline-danger" onclick="deleteAnggota({{$item->id}})"><i class="mdi mdi-delete-forever"></i></button>
                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                         {{ $ruang->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script>
     $('#addAnggota').click(function() {
         axios.get('/create-ruang-rapat')
             .then(function(response) {
                 $('.modal-title').html("Tambahkan Anggota");
                 $(".modal-dialog");
                 $('.modal-body').html(response.data);
                 $('#myModal').modal('show');
             })
             .catch(function(error) {
                 console.log(error);
             });
     })

     function viewAnggota(id) {
         axios.get('/viewAnggota/' + id)    
             .then(function(response) {
                 $('.modal-title').html("Data Anggota");
                 $(".modal-dialog");
                 $('.modal-body').html(response.data);
                 $('#myModal').modal('show');
             })
             .catch(function(error) {
                 console.log(error);
             });
     }

     function editRuangRapat(id) {
         axios.get('/edit-ruang-rapat/' + id)
             .then(function(response) {
                 $('.modal-title').html("Data Ruang Rapat");
                 $(".modal-dialog");
                 $('.modal-body').html(response.data);
                 $('#myModal').modal('show');
             })
             .catch(function(error) {
                 console.log(error);
             });
     }

     function deleteAnggota(id) {
         Swal.fire({
             title: 'Apakah Anda Yakin?',
             text: "Data Yang Dihapus Tidak Dapat di Pulihkan!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonText: 'Delete',
             cancelButtonText: 'Cancle',
             reverseButtons: true
         }).then((result) => {
             if (result.isConfirmed) {
                 axios.post('delete-ruang-rapat/' + id)
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