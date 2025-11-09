 @extends('layout.master')
 @section('Pendukung', 'active')
 @section('unit', 'active')
 @section('title', 'Unit Kerja')
 @section('content')

 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card title-card">
                 <div class="card-body table-title">
                     <div class="judul">
                         <h3 class="font-weight-bold">Data Unit Kerja</h3>
                     </div>
                     <div>
                         @if (session('role') === 'admin')
                         <button type="button" id="addAnggota" class="btn btn-light"><i class="mdi mdi-account-plus"></i> Input Data</button>
                         @endif
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
                                     <th><h5 class="th-text">No</h5></th>
                                     <th><h5 class="th-text">Nama</h5></th>
                                     <th><h5 class="th-text">Deskripsi</h5></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($unit as $item)
                                 <tr>
                                     <td class="font-weight-bold">{{ $unit->firstItem() + $loop->index }}</td>
                                     <td class="font-weight-bold">{{$item->nama}}</td>
                                     <td class="font-weight-bold">{{$item->deskripsi}}</td>
                                     @if (session('role') === 'admin')
                                     <td style="display: flex; justify-content: center;">
                                         <button type="button" class="btn btn-outline-info" onclick="editRuangRapat({{$item->id}})"><i class="mdi mdi-pencil"></i></button>
                                         <button type="button" class="btn btn-outline-danger" onclick="deleteAnggota({{$item->id}})"><i class="mdi mdi-delete-forever"></i></button>
                                     </td>
                                     @endif
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                         {{ $unit->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script>
     $('#addAnggota').click(function() {
         axios.get('/create-unit-kerja')
             .then(function(response) {
                 $('.modal-title').html("Tambahkan Unit Kerja");
                 $(".modal-dialog");
                 $('.modal-body').html(response.data);
                 $('#myModal').modal('show');
             })
             .catch(function(error) {
                 console.log(error);
             });
     })

     function editRuangRapat(id) {
         axios.get('/edit-unit-kerja/' + id)
             .then(function(response) {
                 $('.modal-title').html("Data Unit Kerja");
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
             confirmButtonText: 'Hapus',
             cancelButtonText: 'Batal',
             reverseButtons: true
         }).then((result) => {
             if (result.isConfirmed) {
                 axios.post('delete-unit-kerja/' + id)
                     .then(() => {
                         Swal.fire({
                             title: 'Berhasil',
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