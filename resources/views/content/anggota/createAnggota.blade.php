                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="nama">Nama</label>
                                      <input type="text" class="form-control" id="nama" placeholder="Nama" value="Adi Ferdian">
                                  </div>
                                  <div class="form-group">
                                      <label for="nip">NIP</label>
                                      <input type="email" class="form-control" id="nip" placeholder="NIP" value="199608022025061004">
                                  </div>
                                  <div class="form-group">
                                      <label for="Telepon">Telepon</label>
                                      <input type="text" class="form-control" id="telepon" placeholder="Telepon" value="085943290055">
                                  </div>
                                  <div class="form-group">
                                      <label for="email">Email</label>
                                      <input type="email" class="form-control" id="email" placeholder="Email" value="adiferdian7@gmail.com">
                                  </div>

                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="Pangkat">Pangkat</label>
                                      <input type="text" class="form-control" id="pangkat" placeholder="Pangkat" value="III/a">
                                  </div>
                                  <div class="form-group">
                                      <label for="jabatan">Jabatan</label>
                                      <input type="text" class="form-control" id="jabatan" placeholder="Jabatan" value="Penata Muda">
                                  </div>
                                  <div class="form-group" style="display: flex;">
                                      <div class="col-md-6 grid-margin separasi">
                                          <label for="status">Status</label>
                                          <select class="form-select" id="status">
                                              <option value="aktif">Aktif</option>
                                              <option value="inactive">Tidak Aktif</option>
                                          </select>
                                      </div>
                                      <div class="col-md-6 grid-margin separasi">
                                          <label for="role">Role</label>
                                          <select class="form-select" id="role">
                                              <option value="admin">Admin</option>
                                              <option value="anggota">Anggota</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div style="display: flex;">
                                      <div class="form-group col-md-6 grid-margin separasi">
                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="laki" value="L">
                                          <label class="form-check-label" for="laki">
                                              Laki-Laki
                                          </label>
                                      </div>
                                      <div class="form-group col-md-6 grid-margin separasi">
                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="perempuan" value="P">
                                          <label class="form-check-label" for="perempuan">
                                              Perempuan
                                          </label>
                                      </div>
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
                          const nama = $('#nama').val();
                          const nip = $('#nip').val();
                          const telepon = $('#telepon').val();
                          const status = $('#status').val();
                          const role = $('#role').val();
                          const jk = $('input[name="flexRadioDefault"]:checked').val();
                          const pangkat = $('#pangkat').val();
                          const jabatan = $('#jabatan').val();
                          const email = $('#email').val();

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