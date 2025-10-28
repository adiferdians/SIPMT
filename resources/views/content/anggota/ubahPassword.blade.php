 @extends('layout.master')
 @section('title', 'Ubah Password')
 @section('content')

 <div class="content-wrapper">
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card title-card">
                 <div class="card-body table-title">
                     <div class="judul">
                         <h3 class="font-weight-bold">Ubah Password</h3>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body">
                     <div class="form-group">
                         <label for="lama">Password Lama</label>
                         <input type="password" class="form-control" name="lama" id="lama" placeholder="Password Lama">
                     </div>
                     <div class="form-group">
                         <label for="baru">Password Baru</label>
                         <input type="password" class="form-control" name="passwordBaru" id="baru" placeholder="Password Baru">
                     </div>
                     <div class="form-group">
                         <label for="konfirmasi">Konfirmasi Password Baru</label>
                         <input type="password" class="form-control" name="passwordBaru_confirmation" id="konfirmasi" placeholder="Konfirmasi Password Baru">
                     </div>
                     <div class="btn-modal">
                         <button type="submit" id="change" class="btn btn-primary me-2">Ubah Password</button>
                         <button class="btn btn-warning" id="cancle">Batal</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script>
     $(function() {
         $('#lama').focus();
     });

     $('#cancle').click(async function(e) {
         $('#lama').val('');
         $('#baru').val('');
         $('#konfirmasi').val('');
         $('#lama').focus();
     });

     $('#change').click(async function(e) {
         e.preventDefault();

         const $btn = $(this); // capture button reference
         const $lama = $('#lama');
         const $baru = $('#baru');
         const $konfirmasi = $('#konfirmasi');

         const passwordLama = $lama.val().trim();
         const passwordBaru = $baru.val().trim();
         const passwordKonfirmasi = $konfirmasi.val().trim();

         // Validasi client-side awal
         if (!passwordLama || !passwordBaru || !passwordKonfirmasi) {
             Swal.fire({
                 icon: 'warning',
                 position: 'top-end',
                 title: 'Perhatian!',
                 text: 'Semua kolom password wajib diisi.',
                 showConfirmButton: false,
                 width: '400px',
                 timer: 3000
             });
             return;
         }

         if (passwordBaru !== passwordKonfirmasi) {
             Swal.fire({
                 icon: 'error',
                 position: 'top-end',
                 title: 'Gagal!',
                 text: 'Password Baru dan Konfirmasi Password tidak cocok.',
                 showConfirmButton: false,
                 width: '400px',
                 timer: 3000
             });
             $baru.val('');
             $konfirmasi.val('');
             $baru.focus();
             return;
         }

         $btn.prop('disabled', true).text('Memproses...');

         try {
             const response = await axios.post('/kirimPassword', {
                 passwordLama,
                 passwordBaru,
                 passwordKonfirmasi
             });

             const data = response?.data || {};

             if (data.success = true) {
                 await Swal.fire({
                     icon: 'success',
                     position: 'top-end',
                     title: 'Berhasil!',
                     text: data.message,
                     showConfirmButton: false,
                     width: '400px',
                     timer: 2000
                 });
                 window.location.replace('/dashboard');
             }
             console.log(data.success);

             Swal.fire({
                 icon: 'error',
                 position: 'top-end',
                 title: 'Gagal!',
                 text: data.message || 'Gagal mengubah password. Periksa kembali input Anda.',
                 showConfirmButton: false,
                 width: '400px',
                 timer: 3500
             });

         } catch (error) {
             console.error('Error saat ubah password:', error);

             const serverData = error.response?.data;

             if (error.response?.status === 422 && serverData?.errors) {
                 // gabungkan semua pesan validasi jadi satu string
                 const messages = Object.values(serverData.errors).flat().join('<br>');
                 Swal.fire({
                     icon: 'error',
                     title: 'Validasi Gagal',
                     html: messages,
                     width: '600px'
                 });
             } else {
                 // fallback: pesan server atau pesan error axios
                 const msg = serverData?.message || error.response.data.error.details || 'Terjadi kesalahan saat berkomunikasi dengan server.';
                 Swal.fire({
                     icon: 'error',
                     position: 'top-end',
                     title: 'Kesalahan Server',
                     text: msg,
                     showConfirmButton: false,
                     width: '400px',
                     timer: 3500
                 });
             }

         } finally {
             // tunggu sebentar sebelum meng-enable kembali supaya UX lebih halus
             setTimeout(() => {
                 $btn.prop('disabled', false).text('Ubah Password');
             }, 250);
         }
     });
 </script>
 @endsection