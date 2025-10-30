 @extends('layout.master')
 @section('content')
 @section('Laporan', 'active')
 @section('title', 'Laporan Harian')

 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card title-card">
                 <div class="card-body table-title">
                     <div class="judul">
                         <h3 class="font-weight-bold">Laporan Harian</h3>
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
                         <h3 class="font-weight-bold">Filter Laporan</h3>
                     </div>
                     <div>
                         <form method="GET" action="{{ route('laporan.index') }}" class="mb-3 d-flex gap-2 align-items-center">
                             <input type="text" name="search" value="{{ request('search') }}"
                                 class="form-control" placeholder="Cari nama, tugas, atau deskripsi..." style="max-width: 250px;">

                             <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                                 class="form-control" style="max-width: 180px;">

                             <button type="submit" class="btn btn-primary">Filter</button>
                             <a href="{{ route('laporan.index') }}" class="btn btn-warning">Reset</a>
                         </form>

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
                                         <h5 class="th-text">Nama</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">Tugas Harian</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">Jam</h5>
                                     </th>
                                     <th>
                                         <h5 class="th-text">Deskripsi</h5>
                                     </th>
                                     <th></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($laporan as $item)
                                 <tr>
                                     <td class="font-weight-bold">{{$item->nama}}</td>
                                     <td class="font-weight-bold tugas">{{$item->tugas}}</td>
                                     <td>
                                         {{ \Carbon\Carbon::parse($item->tgl)->locale('id')->dayName }},
                                         {{ \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('DD MMM') }}
                                     </td>
                                     <td class="tugas">{{$item->deskripsi}}</td>
                                     <td style="display: flex; justify-content: center;">
                                         @if (session('role') === 'admin')
                                         <button type="button" class="btn btn-outline-info" onclick="editlaporan({{$item->id}})"><i class="mdi mdi-pencil"></i></button>
                                         @endif
                                         <button type="button" class="btn btn-outline-secondary" onclick="viewKegiatan({{$item->id}})"><i class="mdi mdi-book-open-variant"></i></button>
                                         @if (session('role') === 'admin')
                                         <button type="button" class="btn btn-outline-danger" onclick="deleteKegiatan({{$item->id}})"><i class="mdi mdi-delete-forever"></i></button>
                                         @endif
                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                         {{ $laporan->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection