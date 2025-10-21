                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="nama">Nama Ruangan</label>
                                      <input type="text" id="id" value="{{$ruang[0]->id}}" hidden>
                                      <input type="text" class="form-control" id="nama" placeholder="Nama Ruangan" value="{{$ruang[0]->nama}}">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="Pangkat">Lantai</label>
                                      <input type="text" class="form-control" id="lantai" placeholder="Lantai" value="{{$ruang[0]->lantai}}">
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
                      $('#cancle').click(function() {
                          $('#myModal').modal('hide');
                      })

                      $('#store').click(function() {
                          const id = $('#id').val();
                          const nama = $('#nama').val();
                          const lantai = $('#lantai').val();

                          axios.post('/store-ruang-rapat', {
                              id,
                              nama,
                              lantai,
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