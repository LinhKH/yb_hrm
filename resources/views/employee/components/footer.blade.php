<footer class="main-footer text-center bg-light">
    @foreach($siteInfo as $footer)
      <strong>Copyright © <?php echo date('Y'); ?> <a href="https://news-portal.shop/" target="_blank">Linh Dev</a></strong>
    @endforeach
    </footer>
    <input type="hidden" value="{{url('/')}}" id="url" name="url">
  </div>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('assets/js/moment.min.js')}}"></script>
  <script src="{{asset('assets/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- InputMask -->
  <script src="{{asset('assets/js/jquery.inputmask.bundle.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('assets/js/daterangepicker.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('assets/js/adminlte.js')}}"></script>
  <!-- jquery-validation -->
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <script src="{{asset('assets/js/additional-methods.min.js')}}"></script>
  <!-- SweetAlert -->
  <script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
<!-- Main_ajax.js -->
<script src="{{asset('assets/js/main_ajax.js')}}"></script>
<script>
$(function () {
    $('#reservationdate_4').datetimepicker({
        format: 'L'
    });

    //Money Euro
    $('[data-mask]').inputmask()
});
</script>
</body>
</html>