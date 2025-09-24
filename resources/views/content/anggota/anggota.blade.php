 @extends('layout.master')
 @section('Anggota', 'active')
 @section('title', 'Anggota Risalah')
 @section('content')

 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body table-title">
                    <div class="judul">
                        <h3 class="font-weight-bold">Data Anggota</h3>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary">+</button>
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
                                     <th>Nama</th>
                                     <th>NIP</th>
                                     <th>Telepon</th>
                                     <th>Status</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($anggota as $item)
                                 <tr>
                                     <td>{{ $loop->iteration }}</td>
                                     <td class="font-weight-bold">{{$item->name}}</td>
                                     <td>{{$item->telpon}}</td>
                                     <td class="font-weight-medium">
                                         <div class="badge badge-success">{{$item->status}}</div>
                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                         {{ $anggota->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 @endsection