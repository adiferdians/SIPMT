                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="exampleInputUsername1">Username</label>
                                      <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Email address</label>
                                      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Password</label>
                                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputConfirmPassword1">Confirm Password</label>
                                      <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                                  </div>
                              </div>
                          </div>
                          <div class="card">
                              <div class="card-body">
                                  <div class="form-group">
                                      <label for="exampleInputUsername1">Username</label>
                                      <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Email address</label>
                                      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Password</label>
                                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputConfirmPassword1">Confirm Password</label>
                                      <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
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

                          const companyName = $('#compName').val();
                          const address = $('#address').val();
                          const pic = $('#pic').val();
                          const picContact = $('#picContact').val();
                          const contact = $('#contact').val();
                          const service = $('#service').val();

                          const projName = $('#projName').val();
                          const startDate = $('#startDate').val();
                          const certStandard = $('#certStandard').val();
                          const certBody = $('#certBody').val();
                          const certPrice = $('#certPrice').val();
                          const certStandard_2 = $('#certStandard_2').val();
                          const certBody_2 = $('#certBody_2').val();
                          const certPrice_2 = $('#certPrice_2').val();
                          const certStandard_3 = $('#certStandard_3').val();
                          const certBody_3 = $('#certBody_3').val();
                          const certPrice_3 = $('#certPrice_3').val();
                          const certStandard_4 = $('#certStandard_4').val();

                          axios.post('/client/send', {
                              companyName,
                              address,
                              pic,
                              picContact,
                              contact,
                              service,
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