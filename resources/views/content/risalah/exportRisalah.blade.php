                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="tgl">Tanggal Mulai</label>
                                      <input type="date" class="form-control" id="start">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="tgl">Tanggal Selesai</label>
                                      <input type="date" class="form-control" id="end">
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
                      $('#store').click(function(e) {
                          e.preventDefault();

                          const start = $('#start').val();
                          const end = $('#end').val();
                          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                          if (!start || !end) {
                              Swal.fire('Error', 'Tanggal mulai dan selesai wajib diisi.', 'error');
                              return;
                          }

                          axios.post('/getExport', {
                              start,
                              end
                          }, {
                              headers: {
                                  'X-CSRF-TOKEN': csrfToken 
                              },
                              responseType: 'blob'
                          }).then((response) => {
                              const disposition = response.headers['content-disposition'];
                              let filename = 'laporan.xlsx'; // Nama default jika header tidak ditemukan
                              if (disposition) {
                                  const filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                  const matches = filenameRegex.exec(disposition);
                                  if (matches != null && matches[1]) {
                                      filename = matches[1].replace(/['"]/g, '');
                                  }
                              }

                              // 2. Buat URL sementara untuk data biner (blob)
                              const blob = new Blob([response.data], {
                                  type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                              });
                              const url = window.URL.createObjectURL(blob);

                              // 3. Buat elemen link tersembunyi
                              const a = document.createElement('a');
                              a.style.display = 'none';
                              a.href = url;
                              a.download = filename; // Atur nama file unduhan
                              document.body.appendChild(a);

                              // 4. Klik link tersebut secara otomatis untuk memulai unduhan
                              a.click();

                              // 5. Hapus elemen dan URL setelah selesai
                              window.URL.revokeObjectURL(url);
                              a.remove();
                              Swal.fire({
                                  title: 'Berhasil...',
                                  position: 'top-end',
                                  icon: 'success',
                                  text: 'Berhasil! Data Berhasil Diexport.',
                                  showConfirmButton: false,
                                  width: '400px',
                                  timer: 3000
                              })
                          }).catch((err) => {
                              console.log(err);
                              Swal.fire({
                                  title: 'Error',
                                  position: 'top-end',
                                  icon: 'error',
                                  text: "Export Gagal",
                                  showConfirmButton: false,
                                  width: '400px',
                                  timer: 3000
                              })
                          })
                      })
                  </script>