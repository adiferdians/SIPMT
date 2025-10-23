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
                          <button type="submit" id="store" class="btn btn-primary me-2">Export</button>
                          <button class="btn btn-warning" id="cancle">Batal</button>
                      </div>
                  </div>

                  <script>
                      $('#store').on('click', function(e) {
                          e.preventDefault();

                          const start = $('#start').val();
                          const end = $('#end').val();
                          const csrf = $('meta[name="csrf-token"]').attr('content');

                          if (!start || !end) {
                              return Swal.fire('Error', 'Tanggal mulai dan selesai wajib diisi.', 'error');
                          }

                          axios.post('/getExport', {
                                  start,
                                  end
                              }, {
                                  headers: {
                                      'X-CSRF-TOKEN': csrf
                                  },
                                  responseType: 'blob'
                              })
                              .then(({
                                  data,
                                  headers
                              }) => {
                                  const filename = headers['content-disposition']?.match(/filename="?([^"]+)"?/)?.[1] || 'laporan.xlsx';
                                  const url = URL.createObjectURL(new Blob([data]));
                                  $('<a>')
                                      .attr({
                                          href: url,
                                          download: filename
                                      })
                                      .appendTo('body')[0].click();
                                  URL.revokeObjectURL(url);

                                  Swal.fire({
                                      title: 'Berhasil',
                                      icon: 'success',
                                      text: 'Data berhasil diexport!',
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      width: 400,
                                      timer: 3000
                                  });
                              })
                              .catch(() => {
                                  Swal.fire({
                                      title: 'Error',
                                      icon: 'error',
                                      text: 'Export gagal',
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      width: 400,
                                      timer: 3000
                                  });
                              });
                      });

                      $('#cancle').click(function() {
                          $('#myModal').modal('hide');
                      })
                  </script>