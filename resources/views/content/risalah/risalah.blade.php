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
                                     <th>Tanggal</th>
                                     <th>Jam</th>
                                     <th>Perekam 1</th>
                                     <th>Rapat</th>
                                     <th>Status</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($risalah as $item)
                                 <tr>
                                     <td>{{ \Carbon\Carbon::parse($item->tgl)->locale('id')->dayName }},
                                         {{ \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('DD MMM') }}
                                     </td>
                                     <td class="font-weight-bold">{{$item->jam}}</td>
                                     <td class="font-weight-bold">{{$item->perekam_1}}</td>
                                     <td class="font-weight-bold">{{$item->rapat}}</td>
                                     <td class="font-weight-medium">
                                         <div class="badge badge-success">{{$item->status}}</div>
                                     </td>
                                     <td>

                                     <td style="display: flex; justify-content: center;">
                                         <button type="button" class="btn btn-outline-info"
                                             onclick="editRisalah({{$item->id}})"><i class="mdi mdi-pencil"></i></button>
                                         <button type="button" class="btn btn-outline-secondary"
                                             onclick="viewRislah({{$item->id}})"><i class="mdi mdi-book-open-variant"></i></button>
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
     function viewRislah(id) {
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