@extends('layout.master')
@section('content')
@section('Jadwal', 'active')
@section('title', 'Tabel Jadwal')

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card title-card">
                <div class="card-body table-title">
                    <div class="judul">
                        <h3 class="font-weight-bold">Masa Sidang</h3>
                    </div>
                    <div>
                        <button type="button" id="exportRisalah" class="btn btn-success export"><i class="mdi mdi-file-excel"></i>Masa Sidang I</button>
                        <button type="button" id="addRisalah" class="btn btn-light"><i class="mdi mdi-account-plus"></i>Masa Sidang II</button>
                        <button type="button" id="exportRisalah" class="btn btn-success export"><i class="mdi mdi-file-excel"></i>Masa Sidang III</button>
                        <button type="button" id="addRisalah" class="btn btn-light"><i class="mdi mdi-account-plus"></i>Masa Sidang IV</button>
                        <button type="button" id="exportRisalah" class="btn btn-success export"><i class="mdi mdi-file-excel"></i>Masa Sidang V</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div id="excel-table" style="width: 100%; height: 70vh; overflow: hidden;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('excel-table');

        fetch('/dataJadwal') // Ganti dengan URL endpoint Laravel Anda
            .then(response => response.json())
            .then(resData => {

                // FAKTA: Baris ini WAJIB ada untuk menangkap dan menampung data dari Laravel
                // Jika resData langsung berupa array, dia akan dipakai. Jika berupa object, diambil resData.data
                const dataMurni = Array.isArray(resData) ? resData : (resData.data || []);

                // Inisialisasi Handsontable (Harus berada di DALAM blok .then ini)
                const hot = new Handsontable(container, {
                    data: dataMurni, // Sekarang dataMurni sudah pasti terdefinisi di atasnya
                    rowHeaders: true,
                    colHeaders: ['UNIT KERJA', 'TANGGAL', 'JAM', 'PEREKAM', 'TEMPAT', 'TRANSKRIP', 'EDITOR', 'AGENDA', 'STATUS'],

                    autoRowSize: false,
                    rowHeights: 50,

                    columns: [{
                            data: 'unit_kerja'
                        },
                        {
                            data: 'tgl', // Menargetkan kolom tanggal Anda
                            width: 120,
                            className: 'htLeft',
                            // Menggunakan kustom renderer untuk mengubah tampilan visual teks
                            renderer: function(instance, td, row, col, prop, value, cellProperties) {
                                // Jalankan text renderer bawaan terlebih dahulu
                                Handsontable.renderers.TextRenderer.apply(this, arguments);

                                if (value) {
                                    try {
                                        // Konversi string tanggal dari database menjadi objek Date JavaScript
                                        const dateObj = new Date(value);

                                        // Cek jika konversi tanggal valid
                                        if (!isNaN(dateObj)) {
                                            // Format tanggal menggunakan standar Bahasa Indonesia (Hari, Tanggal Bulan Tahun)
                                            const opsiFormat = {
                                                weekday: 'long',
                                                day: '2-digit',
                                                month: 'short',
                                            };
                                            const tanggalFormatIndo = new Intl.DateTimeFormat('id-ID', opsiFormat).format(dateObj);

                                            // Masukkan hasil format ke dalam tampilan sel
                                            td.innerText = tanggalFormatIndo;
                                        }
                                    } catch (e) {
                                        console.error("Gagal memformat tanggal: ", e);
                                    }
                                }
                                return td;
                            }
                        },
                        {
                            data: 'jam'
                        },
                        {
                            data: 'perekam_1'
                        },
                        {
                            data: 'tempat'
                        },
                        {
                            data: 'transkrip'
                        },
                        {
                            data: 'editor'
                        },
                        {
                            data: 'agenda',
                            width: 200,
                            renderer: function(instance, td, row, col, prop, value, cellProperties) {
                                Handsontable.renderers.TextRenderer.apply(this, arguments);
                                td.classList.add('kolom-agenda');
                                return td;
                            }
                        },
                        {
                            data: 'status',
                        }
                    ],

                    // Hooks untuk expand kolom agenda yang kita buat sebelumnya
                    afterSelectionEnd: function(row, col) {
                        const expandedCells = container.querySelectorAll('.agenda-expanded');
                        expandedCells.forEach(cell => cell.classList.remove('agenda-expanded'));

                        if (col === 5) { // Indeks kolom agenda
                            const selectedCell = this.getCell(row, col);
                            if (selectedCell) {
                                selectedCell.classList.add('agenda-expanded');
                            }
                        }
                    },
                    afterDeselect: function() {
                        const expandedCells = container.querySelectorAll('.agenda-expanded');
                        expandedCells.forEach(cell => cell.classList.remove('agenda-expanded'));
                    },

                    width: '100%',
                    height: '100%',
                    licenseKey: 'non-commercial-and-evaluation'
                });

            })
            .catch(error => {
                console.error('Gagal memuat data:', error);
            });
    });
</script>
@endsection