 @extends('layout.master')
 @section('content')
 @section('Risalah', 'active')
 @section('title', 'Risalah')
 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body">
                     <h3 class="font-weight-bold">Perisalah</h3>
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
                                     <th>Tempat</th>
                                     <th>Perekam 1</th>
                                     <th>Rapat</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td>Search Engine Marketing</td>
                                     <td class="font-weight-bold">$362</td>
                                     <td>21 Sep 2018</td>
                                     <td>Search Engine Marketing</td>
                                     <td class="font-weight-bold">$362</td>
                                     <td class="font-weight-medium">
                                         <div class="badge badge-success">Completed</div>
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 @endsection