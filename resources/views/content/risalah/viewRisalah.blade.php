                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td>Unit</td>
                                              <td>{{$risalah[0]->unit_kerja}}</td>
                                          </tr>
                                          <tr>
                                              <td>Tanggal</td>
                                              <td>{{$risalah[0]->tgl}}</td>
                                          </tr>
                                          <tr>
                                              <td>Jam</td>
                                              <td>{{$risalah[0]->jam}}</td>
                                          </tr>
                                          <tr>
                                              <td>Tempat</td>
                                              <td>{{$risalah[0]->tempat}}</td>
                                          </tr>
                                          <tr>
                                              <td>Perekam 1</td>
                                              <td>{{$risalah[0]->perekam_1}}</td>
                                          </tr>
                                          <tr>
                                              <td>Perekam 2</td>
                                              <td>{{$risalah[0]->perekam_2}}</td>
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
                                              <td>Transkrip</td>
                                              <td>{{$risalah[0]->transkrip}}</td>
                                          </tr>
                                          <tr>
                                              <td>Editor</td>
                                              <td>{{$risalah[0]->editor}}</td>
                                          </tr>
                                          <tr>
                                              <td>Rapat</td>
                                              <td>{{$risalah[0]->rapat}}</td>
                                          </tr>
                                          <tr>
                                              <td>Keterangan</td>
                                              <td>{{$risalah[0]->keterangan}}</td>
                                          </tr>
                                          <tr>
                                              <td>Status</td>
                                              <td>{{$risalah[0]->status}}</td>
                                          </tr>
                                          <tr>
                                              <td>Agenda</td>
                                              <td style="white-space: normal; word-wrap: break-word;">{{$risalah[0]->agenda}}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="btn-modal">
                      <button type="submit" id="store" class="btn btn-primary me-2">Submit</button>
                      <button class="btn btn-warning">Cancel</button>
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

                          axios.post('/storerisalah', {
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
                  </script>