                  <div>
                      <div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td class="txt-bold">Unit Kerja</td>
                                              <td>{{$risalah[0]->unit_kerja}}</td>
                                          </tr>
                                          <tr>
                                              <td  class="txt-bold">Tanggal</td>
                                              <td>
                                                  {{ \Carbon\Carbon::parse($risalah[0]->tgl)->locale('id')->dayName }},
                                                  {{ \Carbon\Carbon::parse($risalah[0]->tgl)->locale('id')->isoFormat('DD MMM YYYY') }}
                                              </td>
                                          </tr>
                                          <tr>
                                              <td  class="txt-bold">Jam</td>
                                              <td>{{$risalah[0]->jam}}</td>
                                          </tr>
                                          <tr>
                                              <td  class="txt-bold">Tempat</td>
                                              <td>{{$risalah[0]->tempat}}</td>
                                          </tr>
                                          <tr>
                                              <td  class="txt-bold">Perekam 1</td>
                                              <td>{{$risalah[0]->perekam_1}}</td>
                                          </tr>
                                          <tr>
                                              <td  class="txt-bold">Perekam 2</td>
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
                                              <td class="txt-bold">Transkrip</td>
                                              <td>{{$risalah[0]->transkrip}}</td>
                                          </tr>
                                          <tr>
                                              <td class="txt-bold">Editor</td>
                                              <td>{{$risalah[0]->editor}}</td>
                                          </tr>
                                          <tr>
                                              <td class="txt-bold">Rapat</td>
                                              <td>{{$risalah[0]->rapat}}</td>
                                          </tr>
                                          <tr>
                                              <td class="txt-bold">Status</td>
                                              <td>
                                                  <button class="btn
                                                        @switch($risalah[0]->status)
                                                            @case('Risalah Validasi')
                                                                btn-success
                                                                @break
                                                            @case('Risalah Sementara')
                                                                btn-info
                                                                @break
                                                            @case('Transkripsi')
                                                                btn-warning
                                                                @break
                                                            @case('Perekaman')
                                                                btn-primary
                                                                @break
                                                            @default
                                                                btn-secondary
                                                        @endswitch
                                                         view-btn">
                                                      {{ $risalah[0]->status }}
                                                  </button>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td style="display: grid;"  class="txt-bold">Agenda</td>
                                              <td style="white-space: normal; word-wrap: break-word;">{!! $risalah[0]->agenda !!}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class=" btn-modal">
                      <button class="btn btn-secondary" id="cancle">Tutup</button>
                  </div>
                  </div>

                  <script>
                      $('#cancle').click(function() {
                          $('#myModal').modal('hide');
                      })
                  </script>