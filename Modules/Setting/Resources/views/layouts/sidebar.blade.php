  <!-- Main Sidebar Container -->
  @php
      $profile = \Modules\Setting\Entities\CompanyProfile::first();
  @endphp
  <aside class="main-sidebar elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('home') }}" class="brand-link text-center text-white" style="background-color: #007bff"
          style="text-decoration: none;">

          <span class="brand-text font-weight-bold ">{{ $profile->company_name }} </span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="">

                  <img src="{{ asset('upload/images/settings/' . $profile->logo) }}" class="w-100 img-fluid"
                      alt="User Image">
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2 mb-4">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item {{ request()->routeIs('home') ? 'menu-open' : '' }}">
                      <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard

                          </p>
                      </a>
                  </li>
                  @can('access_user_management')
                      <li
                          class="nav-item {{ request()->routeIs('users.*', 'roles.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-users"></i>
                              <p>
                                  Users Management
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('roles.index') }}"
                                      class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Roles</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.index') }}"
                                      class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Users</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.create') }}"
                                      class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create Users</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
                  @if (auth()->user()->access_type === 'Admin')
                  @else
                      @can('access_branch')
                          <li class="nav-item {{ request()->routeIs('branches.*') ? 'menu-is-opening menu-open' : '' }}">
                              <a href="#" class="nav-link" {{ request()->routeIs('branches.*') ? 'active' : '' }}>
                                  <i class="nav-icon fas fa-store"></i>
                                  <p>
                                      Office
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="{{ route('branches.index') }}"
                                          class="nav-link {{ request()->routeIs('branches.index') ? 'active' : '' }}">
                                          {{-- <i class="far fa-circle nav-icon"></i> --}}
                                          <p>Offices</p>
                                      </a>
                                  </li>

                              </ul>
                          </li>
                      @endcan
                  @endif
                  {{-- Attendance --}}
                  @can('access_attendance')
                      <li class="nav-item @if (request()->routeIs('attendance.*')) menu-is-opening menu-open @endif">
                          <a href="#" class="nav-link @if (request()->routeIs('attendance.*')) active @endif">
                              <i class="nav-icon fas fa-calendar"></i>
                              <p>
                                  Attendance
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              {{-- @if (auth()->user()->role['name'] === 'Super Admin') --}}
                              <li class="nav-item">
                                  <a href="{{ route('attendance.all') }}"
                                      class="nav-link @if (request()->routeIs('attendance.all')) active @endif">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Attendance</p>
                                  </a>
                              </li>
                              {{-- @else --}}
                              <li class="nav-item">
                                  <a href="{{ route('attendance.index') }}"
                                      class="nav-link @if (request()->routeIs('attendance.index')) active @endif">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>My Attendance</p>
                                  </a>
                              </li>
                              {{-- @endif --}}
                              <li class="nav-item">
                                  <a href="{{ route('attendance.checkin') }}"
                                      class="nav-link @if (request()->routeIs('attendance.checkin')) active @endif">

                                      <p>Check-In Request</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('attendance.checkout') }}"
                                      class="nav-link @if (request()->routeIs('attendance.checkout')) active @endif">

                                      <p>Check-Out Request</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  {{-- Payroll --}}
                  @can('access_payroll')
                      <li class="nav-item @if (request()->routeIs('setsalary.*')) menu-is-opening menu-open @endif">
                          <a href="#" class="nav-link @if (request()->routeIs('setsalary.*')) active @endif">
                              <i class="nav-icon fas fa-receipt"></i>
                              <p>
                                  Payroll
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('setsalary.index') }}"
                                      class="nav-link @if (request()->routeIs('setsalary.index')) active @endif">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Set Salary</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('setsalary.payslip.index') }}"
                                      class="nav-link @if (request()->routeIs('setsalary.payslip.index')) active @endif">

                                      <p>Payslip</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
                  {{-- Product Mgnt --}}
                  {{-- @can('access_product')
                      <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                          <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                              <i class="nav-icon fas fa-image"></i>
                              <p>
                                  Product Mgnt
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('products-categories.index') }}"
                                      class="nav-link @if (request()->routeIs('products-categories.index')) active @endif">
                                      <p>Categories</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('products-brands.index') }}"
                                      class="nav-link @if (request()->routeIs('products-brands.index')) active @endif">
                                      <p>Brands</p>
                                  </a>
                              </li>
                               <li class="nav-item">
                                  <a href="{{ route('products-units.index') }}"
                                      class="nav-link @if (request()->routeIs('products-units.index')) active @endif">
                                      <p>Units</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('products.index') }}"
                                      class="nav-link @if (request()->routeIs('products.index')) active @endif">
                                      <p>Products</p>
                                  </a>
                              </li>

                              <li class="nav-item">
                                  <a href="{{ route('products-accessories.index') }}"
                                      class="nav-link @if (request()->routeIs('products-accessories.index')) active @endif">
                                      <p>Accessories</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('technicaltools.index') }}"
                                      class="nav-link {{ request()->routeIs('technicaltools.index') ? 'active' : '' }}">
                                      <p>Technical Tools</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan --}}

                  {{-- Inventory --}}
                  <li
                      class="nav-item {{ request()->routeIs('inventory.*', 'suppliers.*', 'purchases.*', 'sales.*', 'stock-transfers.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->routeIs('inventory.*', 'suppliers.*', 'purchases.*', 'sales.*', 'stock-transfers.*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-boxes"></i>
                          <p>
                              Inventory
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('suppliers.index') }}"
                                  class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                                  <p>Suppliers</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('device-purchases.index') }}"
                                  class="nav-link {{ request()->routeIs('device-purchases.index') ? 'active' : '' }}">
                                  <p>Device Purchases</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('inventries') }}"
                                  class="nav-link {{ request()->routeIs('inventries') ? 'active' : '' }}">
                                  <p>Inventries</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ route('sales.index') }}"
                                  class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                                  <p>Sales</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('stock-transfers.index') }}"
                                  class="nav-link {{ request()->routeIs('stock-transfers.index') ? 'active' : '' }}">
                                  <p>Stock Transfer</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ route('stock-issue.index') }}"
                                  class="nav-link {{ request()->routeIs('stock-issue.index') ? 'active' : '' }}">
                                  <p>stock issue</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  @can('access_expense')
                      <li class="nav-item {{ request()->routeIs('expenses.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('expenses.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-newspaper"></i>
                              <p>
                                  Expenses
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('expenses-categories.index') }}"
                                      class="nav-link {{ request()->routeIs('expenses-categories.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Category</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('expenses.index') }}"
                                      class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Expenses</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan
                   {{-- Leaves --}}
                  @can('access_leaves')
                      <li class="nav-item {{ request()->routeIs('leave.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('leave.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-newspaper"></i>
                              <p>
                                  Leaves
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('leave-types.index') }}"
                                      class="nav-link {{ request()->routeIs('leave-types.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Types</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('leaves.index') }}"
                                      class="nav-link {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Leaves</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan
                  {{-- Teams --}}
                  @can('access_teams')
                      <li class="nav-item {{ request()->routeIs('teams.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('teams.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-globe"></i>
                              <p>
                                  Manage Website
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('teams.index') }}"
                                      class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-users"></i>
                                      <p>Teams</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('faqs.index') }}" class="nav-link"
                                      {{ request()->routeIs('faqs.*') ? 'active' : '' }}>
                                      <i class="nav-icon fas fa-question-circle"></i>
                                      <p>
                                          FAQs

                                      </p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('testimonials.index') }}"
                                      class="nav-link {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-comment"></i>
                                      <p>Testimonials</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('vacancies.index') }}"
                                      class="nav-link {{ request()->routeIs('vacancies.index') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-briefcase"></i>
                                      <p>Vacancies</p>
                                  </a>
                              </li>
                              @can('access_gallery')
                                  <li class="nav-item">
                                      <a href="{{ route('galleries.index') }}"
                                          class="nav-link {{ request()->routeIs('galleries.index') ? 'active' : '' }}">
                                          <i class="far fa-image nav-icon"></i>
                                          <p>Gallery</p>
                                      </a>
                                  </li>
                              @endcan
                              @can('access_inquiries')
                                  <li class="nav-item">
                                      <a href="{{ route('inquires.index') }}"
                                          class="nav-link {{ request()->routeIs('inquires.index') ? 'active' : '' }}">
                                          <i class="far fa-address-book nav-icon"></i>
                                          <p>Inquiries</p>
                                      </a>
                                  </li>
                              @endcan
                          </ul>
                      </li>
                  @endcan
                  {{-- Inquiries --}}


                  @can('access_settings')
                      <li class="nav-item {{ request()->routeIs('company.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('company.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-cogs"></i>
                              <p>
                                  Setting
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('company.index') }}"
                                      class="nav-link {{ request()->routeIs('company.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Company Profile</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('whyus.index') }}"
                                      class="nav-link {{ request()->routeIs('whyus.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Why Choose Us</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
