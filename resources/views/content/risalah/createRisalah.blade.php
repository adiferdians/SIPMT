<div class="container-fluid px-0">
    <div class="row">
        <!-- Kolom Kiri: Informasi Pelaksanaan -->
        <div class="col-md-6 pr-md-4 border-right">
            <div class="form-group mb-3">
                <label class="font-weight-bold" for="unit_kerja">Unit Kerja</label>
                <select class="form-select form-control" id="unit_kerja">
                    <option disabled selected>Pilih Unit Kerja</option>
                    @foreach ($unit as $item)
                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold" for="tgl">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" id="tgl" value="{{ $tanggal ?? '' }}">
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold" for="jam">Jam</label>
                    <input type="time" class="form-control form-control-sm" id="jam" step="300" inputmode="numeric">
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="font-weight-bold" for="tempat">Ruang Rapat</label>
                <input class="form-control form-control-sm" list="gedung_options" id="tempat" placeholder="Pilih atau ketik Lokasi...">
                <datalist id="gedung_options">
                    @foreach ($ruang as $item)
                    <option value="{{ $item->nama }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold" for="perekam_1">Perekam 1</label>
                    <select class="form-select form-control" id="perekam_1">
                        <option disabled selected>Pilih Perekam 1</option>
                        @foreach ($anggota as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold" for="perekam_2">Perekam 2</label>
                    <select class="form-select form-control" id="perekam_2">
                        <option disabled selected>Pilih Perekam 2</option>
                        @foreach ($anggota as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail & Agenda -->
        <div class="col-md-6 pl-md-4">
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold" for="transkrip">Transkrip</label>
                    <select class="form-select form-control" id="transkrip">
                        <option disabled selected>Pilih Transkriptor</option>
                        @foreach ($anggota as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold" for="editor">Editor</label>
                    <select class="form-select form-control" id="editor">
                        <option disabled selected>Pilih Editor</option>
                        @foreach ($anggota as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="font-weight-bold" for="rapat">Rapat</label>
                <input type="text" class="form-control form-control-sm" id="rapat" placeholder="Masukkan judul rapat...">
            </div>

            <div class="form-group mb-0">
                <label class="font-weight-bold" for="agenda">Agenda</label>
                <!-- Editor Quill -->
                <div id="agenda"></div>
            </div>
        </div>
    </div>

    <!-- Bagian Footer / Tombol Aksi -->
    <div class="row mt-4 pt-3 border-top">
        <div class="col-12 text-right button-end">
            <button type="button" class="btn btn-light border mr-2 px-4" id="cancle">
                Batal
            </button>
            <button type="button" class="btn btn-primary px-4" id="store">
                <i class="mdi mdi-send mr-1"></i> Kirim
            </button>
        </div>
    </div>
</div>

<style>
    /* Mengatasi Quill Editor yang meluber (Overflow Fix) */
    .ql-toolbar.ql-snow,
    .ql-container.ql-snow {
        box-sizing: border-box;
        width: 100%;
    }
    .ql-container.ql-snow {
        height: 180px; 
    }
    .ql-editor {
        min-height: 100%;
        max-height: 200px; 
        overflow-y: auto;
    }
</style>

<script>
    // Inisialisasi Quill
    var quill = new Quill('#agenda', {
        theme: 'snow'
    });

    // Menutup Modal
    $('#cancle').click(function() {
        $('#myModal').modal('hide');
    });

    // Mengirim Data
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
            unit_kerja, tgl, jam, tempat, perekam_1, perekam_2, transkrip, editor, rapat, agenda
        }).then((response) => {
            Swal.fire({
                title: 'Success...',
                position: 'top-end',
                icon: 'success',
                text: 'Berhasil! Data Risalah Berhasil Ditambahkan.',
                showConfirmButton: false,
                width: '400px',
                timer: 3000
            }).then(() => {
                location.reload();
            });
        }).catch((err) => {
            console.log(err);
            Swal.fire({
                title: 'Error',
                position: 'top-end',
                icon: 'error',
                text: err.response?.data?.error?.details || 'Terjadi kesalahan sistem',
                showConfirmButton: false,
                width: '400px',
                timer: 3000
            });
        });
    });

    // Format Jam 24H (pembulatan 5 menit)
    $('#jam').on('change', function() {
        let time = $(this).val();
        if (time) {
            let [hour, minute] = time.split(':').map(Number);
            let roundedMinute = Math.round(minute / 5) * 5;
            if (roundedMinute === 60) {
                roundedMinute = 0;
                hour = (hour + 1) % 24;
            }
            let formattedHour = hour.toString().padStart(2, '0');
            let formattedMinute = roundedMinute.toString().padStart(2, '0');
            $(this).val(`${formattedHour}:${formattedMinute}`);
        }
    });
</script>