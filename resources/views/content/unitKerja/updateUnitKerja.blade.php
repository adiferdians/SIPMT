                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="nama">Nama Unit Kerja</label>
                                      <input type="text" id="id" value="{{$unit[0]->id}}" hidden>
                                      <input type="text" class="form-control" id="nama" placeholder="Nama Unit Kerja" value="{{$unit[0]->nama}}">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="deskripsi">Deskripsi</label>
                                      <input type="text" class="form-control" id="deskripsi" placeholder="Deskripsi" value="{{$unit[0]->deskripsi}}">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="btn-modal">
                          <button type="submit" id="store" class="btn btn-primary me-2">Kirim</button>
                          <button class="btn btn-warning" id="cancle">Batal</button>
                      </div>
                  </div>

                  <script>
                      $('#cancle').click(function() {
                          $('#myModal').modal('hide');
                      })

                      $('#store').click(function() {
                          const id = $('#id').val();
                          const nama = $('#nama').val();
                          const deskripsi = $('#deskripsi').val();

                          axios.post('/store-unit-kerja', {
                              id,
                              nama,
                              deskripsi,
                          }).then((response) => {
                              Swal.fire({
                                  title: 'Berhasil...',
                                  position: 'top-end',
                                  icon: 'success',
                                  text: 'Berhasil! Data Berhasil Diubah.',
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
                                  text: err.response.data.messages,
                                  showConfirmButton: false,
                                  width: '400px',
                                  timer: 3000
                              })
                          })
                      })
                  </script>