<div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="unit_kerja">Unit Kerja</label>
                    <select class="form-select" id="unit_kerja">
                        <option disabled selected>Pilih Unit Kerja</option>
                        @foreach ($unit as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group split">
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="tgl">Tanggal</label>
                            <input type="date" class="form-control" id="tgl">
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <input type="time" class="form-control" id="jam">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tempat">Ruang Rapat</label>
                    <select class="form-select" id="tempat">
                        <option disabled selected>Pilih Ruang Rapat</option>
                        @foreach ($ruang as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group split">
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="perekam_1">Perekam 1</label>
                            <select class="form-select" id="perekam_1">
                                <option disabled selected>Pilih Perekam 1</option>
                                @foreach ($anggota as $item)
                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="perekam_2">Perekam 2</label>
                            <select class="form-select" id="perekam_2">
                                <option disabled selected>Pilih Perekam 2</option>
                                @foreach ($anggota as $item)
                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group split">
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="transkrip">Transkrip</label>
                            <select class="form-select" id="transkrip">
                                <option disabled selected>Pilih Transkriptor</option>
                                @foreach ($anggota as $item)
                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="editor">Editor</label>
                            <select class="form-select" id="editor">
                                <option disabled selected>Pilih Editor</option>
                                @foreach ($anggota as $item)
                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rapat">Rapat</label>
                    <input type="text" class="form-control" id="rapat" placeholder="Rapat">
                </div>
                <div class="form-group">
                    <label for="agenda">Agenda</label>
                    <div id="agenda"></div>
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
    var quill = new Quill('#agenda', {
        theme: 'snow'
    });

    $('#store').click(function() {
        const unit_kerja = $('#unit_kerja').val();
        const tgl = $('#tgl').val();
        const jam = $('#jam').val();
        const tempat = $('#tempat').val();
        const perekam_1 = $('#perekam_1').val();
        const perekam_2 = $('#perekam_2').val();
        const transkrip = $('#transkrip').val();
        const editor = $('#editor').val();
        const rapat = $('#rapat').val();
        const agenda = quill.root.innerHTML;

        axios.post('/storeRisalah', {
            unit_kerja,
            tgl,
            jam,
            tempat,
            perekam_1,
            perekam_2,
            transkrip,
            editor,
            rapat,
            agenda
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
                text: err.response.data.error.details,
                showConfirmButton: false,
                width: '400px',
                timer: 3000
            })
        })
    })
</script>