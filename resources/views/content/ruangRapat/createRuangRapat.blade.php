                  <div>
                      <div class="col-md-4 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="nama">Nama Ruangan</label>
                                      <input type="text" class="form-control" id="nama" placeholder="Nama Ruangan">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="Pangkat">Lantai</label>
                                      <input type="text" class="form-control" id="lantai" placeholder="Lantai">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="gedung">Lokasi</label>
                                      <input
                                          class="form-control"
                                          list="gedung_options"
                                          id="gedung"
                                          placeholder="Pilih atau ketik gedung...">

                                      <datalist id="gedung_options">
                                          <option value="A">
                                          <option value="B">
                                          <option value="MPR/DPD RI">
                                      </datalist>
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
                          const nama = $('#nama').val();
                          const gedung = $('#gedung').val();
                          const lantai = $('#lantai').val();

                          axios.post('/store-ruang-rapat', {
                              nama,
                              gedung,
                              lantai,
                          }).then((response) => {
                              Swal.fire({
                                  title: 'Berhasil...',
                                  position: 'top-end',
                                  icon: 'success',
                                  text: 'Berhasil! Data Berhasil Ditambahkan.',
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