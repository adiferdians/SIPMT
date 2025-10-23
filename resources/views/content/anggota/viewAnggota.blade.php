                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td>Nama</td>
                                              <td>{{$anggota[0]->nama}}</td>
                                          </tr>
                                          <tr>
                                              <td>NIP</td>
                                              <td>{{$anggota[0]->nip}}</td>
                                          </tr>
                                          <tr>
                                              <td>Telepon</td>
                                              <td>{{$anggota[0]->telepon}}</td>
                                          </tr>
                                          <tr>
                                              <td>Email</td>
                                              <td>{{$anggota[0]->email}}</td>
                                          </tr>
                                          <tr>
                                              <td>Jenis Kelamin</td>
                                              <td>{{$anggota[0]->jk}}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td>Pangkat</td>
                                              <td>{{$anggota[0]->pangkat_golongan}}</td>
                                          </tr>
                                          <tr>
                                              <td>Jabatan</td>
                                              <td>{{$anggota[0]->jabatan}}</td>
                                          </tr>
                                          <tr>
                                              <td>Status</td>
                                              <td>{{$anggota[0]->status}}</td>
                                          </tr>
                                          <tr>
                                              <td>Role</td>
                                              <td>{{$anggota[0]->role}}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="btn-modal">
                      <button class="btn btn-secondary" id="cancle">Tutup</button>
                  </div>
                  </div>

                  <script>
                      $('#cancle').click(function() {
                          $('#myModal').modal('hide');
                      })
                  </script>