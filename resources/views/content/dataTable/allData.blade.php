@extends('layout.master')
@section('content')
@section('Jadwal', 'active')
@section('title', 'Tabel Jadwal')

<style>
    /* Memaksa Zebra Striping (Baris Genap = Biru Muda) */
    .handsontable tbody tr:nth-child(even)>td {
        background-color: #cfcfcf !important;
        color: #000000 !important;
    }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body table-title d-flex justify-content-between align-items-center">
                    <div class="judul">
                        <h3 class="font-weight-bold mb-0">Masa Sidang</h3>
                        <p class="text-muted mb-0 small">Filter jadwal berdasarkan masa sidang</p>
                    </div>

                    <!-- Perbaikan UI Tombol: Menggunakan Button Group agar lebih rapi -->
                    <div class="btn-group" role="group" aria-label="Filter Masa Sidang">
                        <button type="button" class="btn btn-info"><i class="mdi mdi-calendar-text mr-1"></i> I</button>
                        <button type="button" class="btn btn-outline-info"><i class="mdi mdi-calendar-blank mr-1"></i> II</button>
                        <button type="button" class="btn btn-outline-info"><i class="mdi mdi-calendar-blank mr-1"></i> III</button>
                        <button type="button" class="btn btn-outline-info"><i class="mdi mdi-calendar-blank mr-1"></i> IV</button>
                        <button type="button" class="btn btn-outline-info"><i class="mdi mdi-calendar-blank mr-1"></i> V</button>
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

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('excel-table');

        // Mengambil data dari server
        fetch('/dataJadwal')
            .then(response => response.json())
            .then(resData => {
                // Menampung data
                const dataMurni = Array.isArray(resData) ? resData : (resData.data || []);

                // Inisialisasi Handsontable
                const hot = new Handsontable(container, {
                    data: dataMurni,
                    rowHeaders: true,
                    colHeaders: ['UNIT KERJA', 'TANGGAL', 'JAM', 'PEREKAM', 'TEMPAT', 'TRANSKRIP', 'EDITOR', 'AGENDA', 'STATUS'],

                    // Konfigurasi tabel umum
                    stretchH: 'all',
                    readOnly: true,
                    wordWrap: false,
                    autoRowSize: false,
                    rowHeights: 45,
                    className: 'htMiddle',
                    stretchH: 'all',
                    columns: [{
                            data: 'unit_kerja'
                        },
                        {
                            data: 'tgl',
                            width: 140,
                            className: 'htLeft htMiddle',
                            renderer: function(instance, td, row, col, prop, value, cellProperties) {
                                Handsontable.renderers.TextRenderer.apply(this, arguments);
                                if (value) {
                                    try {
                                        const dateObj = new Date(value);
                                        if (!isNaN(dateObj)) {
                                            const opsiFormat = {
                                                weekday: 'long',
                                                day: '2-digit',
                                                month: 'short'
                                            };
                                            td.innerText = new Intl.DateTimeFormat('id-ID', opsiFormat).format(dateObj);
                                        }
                                    } catch (e) {
                                        console.error("Gagal memformat tanggal: ", e);
                                    }
                                }
                                return td;
                            }
                        },
                        {
                            data: 'jam',
                            className: 'htCenter htMiddle',
                            width: 80
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
                            width: 250,
                            renderer: function(instance, td, row, col, prop, value, cellProperties) {
                                let cleanHTML = value ? String(value).replace(/<[^>]*>?/gm, '') : '';
                                Handsontable.renderers.TextRenderer.apply(this, [instance, td, row, col, prop, cleanHTML, cellProperties]);
                                td.classList.add('kolom-agenda');
                                td.title = cleanHTML;
                                return td;
                            }
                        },
                        {
                            data: 'status',
                            className: 'htCenter htMiddle',
                            width: 120
                        }
                    ],

                    afterSelectionEnd: function(row, col) {
                        const expandedCells = container.querySelectorAll('.agenda-expanded');
                        expandedCells.forEach(cell => cell.classList.remove('agenda-expanded'));

                        if (col === 7) {
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
@endpush