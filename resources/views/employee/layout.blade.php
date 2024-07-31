  @include('employee.components.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('employee.components.footer  ')