                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <input type="text" id="idAnggota" value="{{$anggota[0]->id}}" hidden>
                                  <div class="form-group">
                                      <label for="nama">Nama</label>
                                      <input type="text" class="form-control" id="nama" placeholder="Nama" value="{{$anggota[0]->nama}}">
                                  </div>
                                  <div class="form-group">
                                      <label for="nip">NIP</label>
                                      <input type="email" class="form-control" id="nip" placeholder="NIP" value="{{$anggota[0]->nip}}">
                                  </div>
                                  <div class="form-group">
                                      <label for="Telepon">Telepon</label>
                                      <input type="text" class="form-control" id="telepon" placeholder="Telepon" value="{{$anggota[0]->telepon}}">
                                  </div>
                                  <div class="form-group">
                                      <label for="email">Email</label>
                                      <input type="email" class="form-control" id="email" placeholder="Email" value="{{$anggota[0]->email}}">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="Pangkat">Pangkat</label>
                                      <input type="text" class="form-control" id="pangkat" placeholder="Pangkat" value="{{$anggota[0]->pangkat_golongan}}">
                                  </div>
                                  <div class="form-group">
                                      <label for="jabatan">Jabatan</label>
                                      <input type="text" class="form-control" id="jabatan" placeholder="Jabatan" value="{{$anggota[0]->jabatan}}">
                                  </div>
                                  <div class="form-group" style="display: flex;">
                                      <div class="col-md-6 grid-margin separasi">
                                          <label for="status">Status</label>
                                          <select class="form-select" id="status">
                                              <option value="aktif" {{$anggota[0]->status=="aktif" ? "selected" : ""}}>Aktif</option>
                                              <option value="inactive" {{$anggota[0]->status=="inactive" ? "selected" : ""}}>Tidak Aktif</option>
                                          </select>
                                      </div>
                                      <div class="col-md-6 grid-margin separasi">
                                          <label for="role">Role</label>
                                          <select class="form-select" id="role">
                                              <option value="admin" {{$anggota[0]->role=="admin" ? "selected" : ""}}>Admin</option>
                                              <option value="anggota" {{$anggota[0]->role=="anggota" ? "selected" : ""}}>Anggota</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div style="display: flex;">
                                      <div class="form-group col-md-6 grid-margin separasi">
                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="laki" value="L" {{$anggota[0]->jk=="L" ? "checked" : ""}}>
                                          <label class="form-check-label" for="laki">
                                              Laki-Laki
                                          </label>
                                      </div>
                                      <div class="form-group col-md-6 grid-margin separasi">
                                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="perempuan" value="P" {{$anggota[0]->jk=="P" ? "checked" : ""}}>
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
                          <button class="btn btn-warning" id="cancle">Cancel</button>
                      </div>
                  </div>

                  <script>
                      $('#store').click(function() {
                          const id = $('#idAnggota').val();
                          const nama = $('#nama').val();
                          const nip = $('#nip').val();
                          const telepon = $('#telepon').val();
                          const status = $('#status').val();
                          const role = $('#role').val();
                          const jk = $('input[name="flexRadioDefault"]:checked').val();
                          const pangkat = $('#pangkat').val();
                          const jabatan = $('#jabatan').val();
                          const email = $('#email').val();

                          axios.post('/storeAnggota/' + id, {
                              id,
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