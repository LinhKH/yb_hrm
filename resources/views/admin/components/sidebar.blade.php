<!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            @if(isset($siteInfo))
                <a href="javascript:void(0)" class="brand-link">
                    <img src="{{asset('company/'.$siteInfo[0]->com_logo)}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">{{$siteInfo[0]->com_name}}</span>
                </a>
            @else
                <a href="index3.html" class="brand-link">
                    <img src="{{asset('/images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">AdminLTE</span>
                </a>
            @endif
            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                
                <div class="info">
                    <a href="javascript:void(0)" class="d-block">{{session()->get('admin_name')}}</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{url('admin/dashboard')}}" class="nav-link {{(Request::path() == 'admin/dashboard')? 'active':''}}">
                            <i class="nav-icon fas fa-home"></i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/employees' || Request::path() == 'admin/departments' || Request::path() == 'admin/designations')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fas fa-user"></i>
                           <p> People <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('admin/employees')}}" class="nav-link {{(Request::path() == 'admin/employees')? 'active bg-primary':''}}">
                                  <i class="fas fa-user nav-icon"></i>
                                  <p>Employees</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/departments')}}" class="nav-link {{(Request::path() == 'admin/departments')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-briefcase"></i>
                                    <p>Departments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/designations')}}" class="nav-link {{(Request::path() == 'admin/designations')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-briefcase"></i>
                                    <p>Designations</p>
                                </a>
                            </li>
                        </ul> 
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/attendance' || Request::path() == 'admin/attendance/create' || Request::path() == 'admin/leave_type' || Request::path() == 'admin/leave_application')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fas fa-users"></i>
                           <p> Attendance <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('admin/attendance/create')}}" class="nav-link {{(Request::path() == 'admin/attendance/create')? 'active bg-primary':''}}">
                                  <i class="fas fa-check nav-icon"></i>
                                  <p>Mark Attendance</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/attendance')}}" class="nav-link {{(Request::path() == 'admin/attendance')? 'active bg-primary':''}}">
                                  <i class="far fa-eye nav-icon"></i>
                                 <p>View Attendance</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/leave_type')}}" class="nav-link {{(Request::path() == 'admin/leave_type')? 'active bg-primary':''}}">
                                  <i class="fa fa-cubes nav-icon"></i>
                                 <p>Leave Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/leave_application')}}" class="nav-link {{(Request::path() == 'admin/leave_application')? 'active bg-primary':''}}">
                                  <i class="fas fa-rocket nav-icon"></i>
                                 <p>Leave Applications</p>
                                </a>
                            </li>
                        </ul> 
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/notice_board' || Request::path() == 'admin/expenses' || Request::path() == 'admin/awards' || Request::path() == 'admin/holidays')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fas fa-briefcase"></i>
                           <p> Manage <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('admin/notice_board')}}" class="nav-link {{(Request::path() == 'admin/notice_board')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-paste"></i>
                                    <p>Notice Board</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/expenses')}}" class="nav-link {{(Request::path() == 'admin/expenses')? 'active bg-primary':''}}">
                                    <i class="nav-icon far fa-money-bill-alt"></i>
                                    <p>Expense</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/awards')}}" class="nav-link {{(Request::path() == 'admin/awards')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-trophy"></i>
                                    <p>Awards</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/holidays')}}" class="nav-link {{(Request::path() == 'admin/holidays')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-paper-plane"></i>
                                    <p>Holidays </p>
                                </a>
                            </li>
                        </ul> 
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/general-settings' || Request::path() == 'admin/profile-settings')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fas fa-cogs"></i>
                           <p>Setting <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="{{url('admin/general-settings')}}" class="nav-link {{(Request::path() == 'admin/general-settings')? 'active bg-primary':''}}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>General Settings</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{url('admin/profile-settings')}}" class="nav-link {{(Request::path() == 'admin/profile-settings')? 'active bg-primary':''}}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Profile Settings</p>
                            </a>
                          </li>
                        </ul> 
                    </li>
                </ul>
             <!--  </li>
                </ul> -->
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Control Sidebar -->