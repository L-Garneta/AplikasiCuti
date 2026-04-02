 <!-- Footer -->
 <footer class="sticky-footer">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <!-- <span>Created by <a href="http://adoniasite.my.id" target="_blank">Donny Kurniawan</a> @ <?= date('Y'); ?></span> -->
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Klik logout untuk mengakhiri session</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <!-- <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script> -->
 <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/ajax.js"></script>

 <script src="<?= base_url('assets/swal/'); ?>sweetalert2.all.min.js"></script>
 <script src="<?= base_url('assets/swal/'); ?>myscript.js"></script>

 <!-- datatables -->
 <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/dataTables.buttons.min.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/buttons.flash.min.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/jszip.min.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/pdfmake.min.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/vfs_fonts.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/buttons.html5.min.js"></script>
 <script src="<?= base_url('assets/'); ?>datatables/buttons.print.min.js"></script>

 <script>
     $(function() {
         $("#table-id").DataTable();
         //  $("#table-table").DataTable({
         //      dom: 'Bfrtip',
         //      buttons: [
         //          'excel', 'pdf', 'print'
         //      ]
         //  });
         $("#dataTable-id").DataTable();
         $("#datatable-id").DataTable();
         $('#id-table').DataTable();
     });
 </script>



 <script>
     $('.tombol-hapus').on('click', function(e) {

         e.preventDefault();
         const href = $(this).attr('href');

         Swal.fire({
             title: 'Yakin untuk menghapus ?',
             text: 'Data User akan dihapus',
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Hapus'
         }).then((result) => {
             if (result.value) {
                 document.location.href = href;
             }
         })
     });
 </script>


 <script>
     function sum() {
         var txtFirstNumberValue = document.getElementById('txt1').value;
         var txtSecondNumberValue = document.getElementById('txt2').value;
         var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
         if (!isNaN(result)) {
             document.getElementById('txt3').value = result;
         }
     }
 </script>

 <script type="text/javascript">
     function price() {
         var tes = document.getElementById("level").value;
         document.getElementById("harga").value = tes;
     }
 </script>
 <script>
     $('#tombol-logout').on('click', function(e) {
         e.preventDefault();
         const href = $(this).attr('href');
         Swal.fire({
             title: 'Konfirmasi Logout',
             text: 'Klik keluar untuk mengakhiri session',
             type: 'danger',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Keluar'
         }).then((result) => {
             if (result.value) {
                 document.location.href = href;
             }
         })
     });
 </script>
 <script>
     $('.tombol-reset').on('click', function(e) {

         e.preventDefault();
         const href = $(this).attr('href');

         Swal.fire({
             title: 'Yakin untuk mereset cuti ?',
             text: 'Data cuti akan dipindah ke tabel lain',
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Reset'
         }).then((result) => {
             if (result.value) {
                 document.location.href = href;
             }
         })
     });
 </script>



 </body>

 </html>