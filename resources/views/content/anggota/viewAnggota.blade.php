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
                      <button type="submit" id="store" class="btn btn-primary me-2">Submit</button>
                      <button class="btn btn-warning" id="cancle">Cancel</button>
                  </div>
                  </div>

                  <script>
                      $('#store').click(function() {
                          console.log("sapi");

                          const nama = $('#nama').val();
                          const nip = $('#nip').val();
                          const telepon = $('#telepon').val();
                          const status = $('#status').val();
                          const role = $('#role').val();
                          const jk = $('#jk').val();

                          const pangkat = $('#pangkat').val();
                          const jabatan = $('#jabatan').val();
                          const email = $('#email').val();

                          console.log(nama, nip, telepon, status, jk);

                          axios.post('/storeAnggota', {
                              nama,
                              nip,
                              telepon,
                              email,
                              status,
                              role,
                              jk,
                              jabatan,
                              pangkat
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
                      })

                      $('#cancle').click(function() {
                          $('#myModal').modal('hide');
                      })
                  </script>