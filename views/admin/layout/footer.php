 <!-- jQuery -->
 <script src="/public/admin/plugins/jquery/jquery.min.js"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="/public/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
 <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
 <script>
     $.widget.bridge('uibutton', $.ui.button)
 </script>
 <!-- Bootstrap 4 -->
 <script src="/public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- ChartJS -->
 <script src="/public/admin/plugins/chart.js/Chart.min.js"></script>
 <!-- Sparkline -->
 <script src="/public/admin/plugins/sparklines/sparkline.js"></script>
 <!-- JQVMap -->
 <script src="/public/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
 <script src="/public/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
 <!-- jQuery Knob Chart -->
 <script src="/public/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
 <!-- daterangepicker -->
 <script src="/public/admin/plugins/moment/moment.min.js"></script>
 <script src="/public/admin/plugins/daterangepicker/daterangepicker.js"></script>
 <!-- Tempusdominus Bootstrap 4 -->
 <script src="/public/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
 <!-- Summernote -->
 <script src="/public/admin/plugins/summernote/summernote-bs4.min.js"></script>
 <!-- overlayScrollbars -->
 <script src="/public/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
 <!-- AdminLTE App -->
 <script src="/public/admin/dist/js/adminlte.js"></script>
 <!-- DataTables  & Plugins -->
 <script src="/public/admin/plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="/public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="/public/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="/public/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 <script src="/public/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
 <script src="/public/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
 <script src="/public/admin/plugins/jszip/jszip.min.js"></script>
 <script src="/public/admin/plugins/pdfmake/pdfmake.min.js"></script>
 <script src="/public/admin/plugins/pdfmake/vfs_fonts.js"></script>
 <script src="/public/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
 <script src="/public/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
 <script>
     $(function() {
         $("#example1").DataTable({
             "responsive": true,
             "lengthChange": false,
             "autoWidth": false,
             "buttons": ["copy", "csv", "excel", "pdf", "print"]
         }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

     });
 </script>