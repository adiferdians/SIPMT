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
                            <input type="date" class="form-control" id="tgl" value="{{ $tanggal ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin separasi">
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <input type="time" class="form-control" id="jam" step="300">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tempat">Ruang Rapat</label>
                    <input class="form-control"
                        list="gedung_options"
                        id="tempat"
                        placeholder="Pilih atau ketik Lokasi...">

                    <datalist id="gedung_options">
                        @foreach ($ruang as $item)
                        <option value="{{ $item->nama }}">
                            @endforeach
                    </datalist>
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
        <button type="submit" id="store" class="btn btn-primary me-2">Kirim</button>
        <button class="btn btn-warning" id="cancle">Batal</button>
    </div>
</div>

<script>
    var quill = new Quill('#agenda', {
        theme: 'snow'
    });

    $('#cancle').click(function() {
        $('#myModal').modal('hide');
    })

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

    $('#jam').on('change', function() {
        let time = $(this).val();

        if (time) {
            let [hour, minute] = time.split(':').map(Number);

            // Bulatkan menit ke kelipatan 5 terdekat
            let roundedMinute = Math.round(minute / 5) * 5;
            if (roundedMinute === 60) {
                roundedMinute = 0;
                hour = (hour + 1) % 24;
            }

            // Format ulang jam 24 jam
            let formattedHour = hour.toString().padStart(2, '0');
            let formattedMinute = roundedMinute.toString().padStart(2, '0');

            // Update nilai input agar selalu format 24 jam
            $(this).val(`${formattedHour}:${formattedMinute}`);
        }
    });

    // Jika ingin memaksa tampilan awal juga 24 jam
    $('#jam').attr('inputmode', 'numeric'); // bantu agar input numerik
</script>