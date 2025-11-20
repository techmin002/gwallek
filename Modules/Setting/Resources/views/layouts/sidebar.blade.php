  <!-- Main Sidebar Container -->
  @php
      $profile = \Modules\Setting\Entities\CompanyProfile::first();
  @endphp
  <style>
      /* Elegant Sidebar Styling */
      .main-sidebar {
          background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%);
          color: #e0e0e0;
          transition: all 0.3s ease;
          box-shadow: 2px 0 15px rgba(0, 0, 0, 0.3);
          border-right: 1px solid rgba(255, 255, 255, 0.05);
      }

      .brand-link {
          background: linear-gradient(90deg, #007bff, #5f27cd);
          font-weight: 600;
          font-size: 1.1rem;
          letter-spacing: 0.5px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.15);
      }

      .brand-link:hover {
          background: linear-gradient(90deg, #5f27cd, #007bff);
          text-decoration: none;
          color: #fff;
      }

      /* Sidebar user image */
      .user-panel img {
          border-radius: 10px;
          border: 2px solid rgba(255, 255, 255, 0.15);
          box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
      }

      /* Sidebar Search */
      .form-control-sidebar {
          background-color: #14213d;
          border: none;
          color: #fff;
          border-radius: 8px;
      }

      .btn-sidebar {
          background: #5f27cd;
          color: white;
      }

      /* Menu items */
      .nav-sidebar .nav-item>.nav-link {
          color: #cfd8dc;
          border-radius: 8px;
          margin: 3px 10px;
          transition: all 0.3s ease;
      }

      .nav-sidebar .nav-item>.nav-link:hover {
          background-color: rgba(255, 255, 255, 0.1);
          color: #ffffff;
          transform: translateX(3px);
      }

      /* Active link */
      .nav-sidebar .nav-item>.nav-link.active {
          background: linear-gradient(90deg, #007bff, #5f27cd);
          color: #fff !important;
          box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
      }

      /* Treeview submenu */
      .nav-treeview {
          margin-left: 10px;
          border-left: 1px solid rgba(255, 255, 255, 0.1);
      }

      .nav-treeview .nav-link {
          font-size: 0.9rem;
          color: #b0bec5;
          margin-left: 8px;
      }

      .nav-treeview .nav-link.active {
          background: rgba(95, 39, 205, 0.2);
          color: #fff;
      }

      /* Scrollbar */
      .main-sidebar::-webkit-scrollbar {
          width: 6px;
      }

      .main-sidebar::-webkit-scrollbar-thumb {
          background-color: rgba(255, 255, 255, 0.15);
          border-radius: 10px;
      }
  </style>
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
                  @can('access_messages')
                      <li class="nav-item {{ request()->routeIs('messages.index') ? 'menu-open' : '' }}">
                          <a href="{{ route('messages.index') }}"
                              class="nav-link {{ request()->routeIs('messages.index') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-envelope"></i>
                              <p>
                                  Messages
                              </p>
                          </a>
                      </li>
                  @endcan

                  @can('access_user_management')
                      <li
                          class="nav-item {{ request()->routeIs('users.*', 'roles.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link"
                              {{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}>
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
                  {{-- Service --}}
                  @can('access_services')
                      <li class="nav-item {{ request()->routeIs('services.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-newspaper"></i> {{-- Parent icon --}}
                              <p>
                                  Service
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('services.index') }}"
                                      class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}">
                                      <i class="fas fa-list-alt nav-icon"></i> {{-- Service list icon --}}
                                      <p>Service</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('services.create') }}"
                                      class="nav-link {{ request()->routeIs('services.create') ? 'active' : '' }}">
                                      <i class="fas fa-plus-square nav-icon"></i> {{-- Create service icon --}}
                                      <p>Create Service</p>
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

                  {{-- Finance --}}
                  @can('access_finance')
                      <li
                          class="nav-item {{ request()->routeIs('due.sites') || request()->routeIs('cash-counter.*') || request()->routeIs('finance.depositedetails') || request()->routeIs('banks.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ request()->routeIs('due.sites') || request()->routeIs('cash-counter.*') || request()->routeIs('finance.depositedetails') || request()->routeIs('banks.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-coins"></i>
                              <p>
                                  Finance
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              {{-- Due Project --}}
                              <li class="nav-item">
                                  <a href="{{ route('due.sites') }}"
                                      class="nav-link {{ request()->routeIs('due.sites') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                      <p>Due Project</p>
                                  </a>
                              </li>

                              {{-- Cash Counter --}}
                              <li class="nav-item">
                                  <a href="{{ route('cash-counter.index') }}"
                                      class="nav-link {{ request()->routeIs(['cash-counter.*', 'finance.depositedetails']) ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-cash-register"></i>
                                      <p>Cash Counter</p>
                                  </a>
                              </li>
                              {{-- Cash Counter --}}
                              <li class="nav-item">
                                  <a href="{{ route('banks.index') }}"
                                      class="nav-link {{ request()->routeIs('banks.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-cash-register"></i>
                                      <p>Bank</p>
                                  </a>
                              </li>
                              {{-- Due Orders --}}
                              <li class="nav-item">
                                  <a href="{{ route('due_orders.index') }}"
                                      class="nav-link {{ request()->routeIs('due_orders.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-dollar-sign"></i>
                                      <p>Due Orders</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  {{-- Product Mgnt --}}
                  @can('access_product')
                      <li
                          class="nav-item {{ request()->routeIs('units.*') || request()->routeIs('brands.*') || request()->routeIs('categories.*') || request()->routeIs('products.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ request()->routeIs('units.*') || request()->routeIs('brands.*') || request()->routeIs('categories.*') || request()->routeIs('products.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-boxes"></i>
                              <p>
                                  Product Mgnt
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>

                          <ul class="nav nav-treeview">
                              {{-- Units --}}
                              <li class="nav-item">
                                  <a href="{{ route('units.index') }}"
                                      class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-balance-scale"></i>
                                      <p>Units</p>
                                  </a>
                              </li>

                              {{-- Brands --}}
                              <li class="nav-item">
                                  <a href="{{ route('brands.index') }}"
                                      class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-trademark"></i>
                                      <p>Brands</p>
                                  </a>
                              </li>

                              {{-- Categories --}}
                              <li class="nav-item">
                                  <a href="{{ route('categories.index') }}"
                                      class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-layer-group"></i>
                                      <p>Categories</p>
                                  </a>
                              </li>

                              {{-- Products --}}
                              <li class="nav-item">
                                  <a href="{{ route('products.index') }}"
                                      class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-box"></i>
                                      <p>Products</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  {{-- Inventory --}}
                  @can('access_inventory')
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

                              {{-- <li class="nav-item">
                              <a href="{{ route('sales.index') }}"
                          class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                          <p>Sales</p>
                          </a>
                  </li> --}}
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
                  @endcan

                  {{-- Mechanical Tools --}}
                  @can('access_mechanical')
                      <li class="nav-item {{ request()->routeIs('mechanicals.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link {{ request()->routeIs('mechanicals.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-tools"></i>
                              <p>
                                  Mechanical Tools
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              {{-- Mechanical Categories --}}
                              <li class="nav-item">
                                  <a href="{{ route('mechanicals.categories.index') }}"
                                      class="nav-link {{ request()->routeIs('mechanicals.categories.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-list-alt"></i>
                                      <p> Categories</p>
                                  </a>
                              </li>

                              {{-- Mechanicals --}}
                              <li class="nav-item">
                                  <a href="{{ route('mechanicals.items.index') }}"
                                      class="nav-link {{ request()->routeIs('mechanicals.items.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-cogs"></i>
                                      <p>Mechanicals</p>
                                  </a>
                              </li>

                              {{-- Mechanical Expenses --}}
                              <li class="nav-item">
                                  <a href="{{ route('mechanicals.expenses.index') }}"
                                      class="nav-link {{ request()->routeIs('mechanicals.expenses.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                      <p>Mechanical Expenses</p>
                                  </a>
                              </li>

                              {{-- Mechanical Reports --}}
                              <li class="nav-item">
                                  <a href="{{ route('mechanicals.reports.index') }}"
                                      class="nav-link {{ request()->routeIs('mechanicals.reports.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-chart-line"></i>
                                      <p>Mechanical Reports</p>
                                  </a>
                              </li>

                              {{-- Mechanical Services --}}
                              <li class="nav-item">
                                  <a href="{{ route('mechanicals.services.index') }}"
                                      class="nav-link {{ request()->routeIs('mechanicals.services.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-wrench"></i>
                                      <p>Mechanical Services</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

                  {{-- Expenses --}}
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

                  {{-- Inquiries --}}
                  @can('access_inquiries')
                      <li
                          class="nav-item {{ request()->routeIs('customers.*') || request()->routeIs('managers.*') || request()->routeIs('sites.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ request()->routeIs('customers.*') || request()->routeIs('managers.*') || request()->routeIs('sites.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-project-diagram"></i>
                              <p>
                                  Project Manager
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              {{-- Customer --}}
                              <li class="nav-item">
                                  <a href="{{ route('customers.index') }}"
                                      class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-users"></i>
                                      <p>Customer</p>
                                  </a>
                              </li>

                              {{-- Manager  --}}
                              <li class="nav-item">
                                  <a href="{{ route('managers.index') }}"
                                      class="nav-link {{ request()->routeIs('managers.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-user-tie"></i>
                                      <p>Manager</p>
                                  </a>
                              </li>

                              {{-- Site --}}
                              <li class="nav-item">
                                  <a href="{{ route('sites.index') }}"
                                      class="nav-link {{ request()->routeIs('sites.*') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-project-diagram"></i>
                                      <p>Site</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan

                  {{-- Orders --}}
                  @can('access_orders')
                      <li class="nav-item {{ request()->routeIs('orders.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list-alt"></i>
  
                              <p>
                                  Order
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              {{-- Dashboard --}}
                              <li class="nav-item">
                                  <a href="{{ route('orders.dashboard') }}"
                                      class="nav-link {{ request()->routeIs('orders.dashboard') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-tachometer-alt"></i>
                                      <p>Orders Dashboard</p>
                                  </a>
                              </li>

                              {{-- Orders --}}
                              <li class="nav-item">
                                  <a href="{{ route('orders.index') }}"
                                      class="nav-link {{ request('status') == null ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-list"></i>
                                      <p>All Orders</p>
                                  </a>
                              </li>

                              {{-- Approved --}}
                              <li class="nav-item">
                                  <a href="{{ route('orders.index', ['status' => 'approved']) }}"
                                      class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-check-circle text-success"></i>
                                      <p>Approved</p>
                                  </a>
                              </li>

                              {{-- Pending --}}
                              <li class="nav-item">
                                  <a href="{{ route('orders.index', ['status' => 'pending']) }}"
                                      class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-clock text-warning"></i>
                                      <p>Pending</p>
                                  </a>
                              </li>
                              {{-- Dispatched --}}
                              <li class="nav-item">
                                  {{-- <a href="{{ route('orders.dispatched') }}" --}}
                                  <a href="#"
                                      class="nav-link {{ request()->routeIs('orders.dispatched') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-truck"></i>
                                      <p>Dispatched</p>
                                  </a>
                              </li>

                              {{-- Tracking --}}
                              <li class="nav-item">
                                  {{-- <a href="{{ route('orders.tracking') }}" --}}
                                  <a href="#"
                                      class="nav-link {{ request()->routeIs('orders.tracking') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-map-marker-alt"></i>
                                      <p>Tracking</p>
                                  </a>
                              </li>
                              {{-- Completed --}}
                              <li class="nav-item">
                                  <a href="{{ route('orders.index', ['status' => 'completed']) }}"
                                      class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-check text-success"></i>
                                      <p>Completed</p>
                                  </a>
                              </li>
                              {{-- Return --}}
                              <li class="nav-item">
                                  {{-- <a href="{{ route('orders.return') }}" --}}
                                  <a href="#"
                                      class="nav-link {{ request()->routeIs('orders.return') ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-undo text-danger"></i>
                                      <p>Return</p>
                                  </a>
                              </li>
                              {{-- Rejected --}}
                              <li class="nav-item">
                                  <a href="{{ route('orders.index', ['status' => 'rejected']) }}"
                                      class="nav-link {{ request('status') == 'reject' ? 'active' : '' }}">
                                      <i class="nav-icon fas fa-times-circle text-danger"></i>
                                      <p>Rejected</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
                  <li class="nav-item {{ request()->routeIs('orderss.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('orderss.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shopping-cart"></i>
        <p>
            Approved Order

            {{-- Pending Count Badge --}}
            @if($pendingCount > 0)
                <span class="badge bg-warning text-dark ms-2">
                    {{ $pendingCount }}
                </span>
            @endif

            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('orderss.index') }}"
               class="nav-link {{ request()->routeIs('orderss.index') ? 'active' : '' }}">
                <i class="fas fa-list nav-icon"></i>
                <p>All Orders</p>
            </a>
        </li>
    </ul>
</li>

                  {{-- Purchase Orders --}}
<li class="nav-item {{ request()->routeIs('purchases.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shopping-cart"></i>
        <p>
            Purchase
            <i class="right fas fa-angle-left"></i>
            
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('purchases.index') }}"
               class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}">
                <i class="fas fa-list nav-icon"></i>
                <p>Orders</p>
            </a>
        </li>
    </ul>
</li>



{{-- Payments --}}
<li class="nav-item {{ request()->routeIs('payments.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-check-alt"></i>
        <p>
            Payment
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('payments.select-project') }}"
               class="nav-link {{ request()->routeIs('payments.select-project') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>Payment</p>
            </a>
        </li>
    </ul>
</li>

{{-- Project Income --}}
<li class="nav-item {{ request()->routeIs('incomes.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('incomes.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-coins"></i>
        <p>
            Project Incomes
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('incomes.index') }}"
               class="nav-link {{ request()->routeIs('incomes.index') ? 'active' : '' }}">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Project Income</p>
            </a>
        </li>
    </ul>
</li>



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
                              @can('access_sliders')
                                  <li class="nav-item">
                                      <a href="{{ route('sliders.index') }}"
                                          class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-sliders-h"></i>
                                          <p>Sliders</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('blogs.index') }}"
                                          class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-blog"></i>
                                          <p>Blogs</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('blogscomment.index') }}"
                                          class="nav-link {{ request()->routeIs('blogscomment.*') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-comments"></i>
                                          <p>Blogs Comment</p>
                                      </a>
                                  </li>
                              @endcan

                              @can('access_teams')
                                  <li class="nav-item">
                                      <a href="{{ route('teams.index') }}"
                                          class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-users"></i>
                                          <p>Teams</p>
                                      </a>
                                  </li>
                              @endcan

                              @can('access_advisors')
                                  <li class="nav-item">
                                      <a href="{{ route('advisors.index') }}"
                                          class="nav-link {{ request()->routeIs('advisors.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-user-tie"></i>
                                          <p>Advisors</p>
                                      </a>
                                  </li>
                              @endcan
                              @can('access_clients')
                                  <li class="nav-item">
                                      <a href="{{ route('clients.index') }}"
                                          class="nav-link {{ request()->routeIs('clients.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-handshake"></i>
                                          <p>Clients</p>
                                      </a>
                                  </li>
                              @endcan

                              @can('access_faqs')
                                  <li class="nav-item">
                                      <a href="{{ route('faqs.index') }}" class="nav-link"
                                          {{ request()->routeIs('faqs.*') ? 'active' : '' }}>
                                          <i class="nav-icon fas fa-question-circle"></i>
                                          <p>
                                              FAQs
                                          </p>
                                      </a>
                                  </li>
                              @endcan

                              @can('access_testimonials')
                                  <li class="nav-item">
                                      <a href="{{ route('testimonials.index') }}"
                                          class="nav-link {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-comment"></i>
                                          <p>Testimonials</p>
                                      </a>
                                  </li>
                              @endcan

                              @can('access_vacancies')
                                  <li class="nav-item">
                                      <a href="{{ route('vacancies.index') }}"
                                          class="nav-link {{ request()->routeIs('vacancies.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-briefcase"></i>
                                          <p>Vacancies</p>
                                      </a>
                                  </li>
                              @endcan

                              {{-- @can('access_gallery')
                                  <li class="nav-item">
                                      <a href="{{ route('galleries.index') }}"
                      class="nav-link {{ request()->routeIs('galleries.index') ? 'active' : '' }}">
                      <i class="far fa-image nav-icon"></i>
                      <p>Gallery</p>
                      </a>
              </li>
              @endcan --}}
                              @can('access_inquiries')
                                  <li class="nav-item">
                                      <a href="{{ route('inquiry.index') }}"
                                          class="nav-link {{ request()->routeIs('inquiry.index') ? 'active' : '' }}">
                                          <i class="far fa-address-book nav-icon"></i>
                                          <p>Inquiries</p>
                                      </a>
                                  </li>
                              @endcan

                              {{-- Messages Form  --}}
                              @can('access_messages')
                                  <li
                                      class="nav-item {{ request()->routeIs('messages.md.index') || request()->routeIs('messages.ed.index') ? 'menu-is-opening menu-open' : '' }}">
                                      <a href="#"
                                          class="nav-link {{ request()->routeIs('messages.md.index') || request()->routeIs('messages.ed.index') ? 'active' : '' }}">
                                          <i class="nav-icon fas fa-envelope-open-text"></i>
                                          <p>
                                              Message From
                                              <i class="right fas fa-angle-left"></i>
                                          </p>
                                      </a>
                                      <ul class="nav nav-treeview">
                                          <li class="nav-item">
                                              <a href="{{ route('messages.md.index') }}"
                                                  class="nav-link {{ request()->routeIs('messages.md.index') ? 'active' : '' }}">
                                                  <i class="fas fa-user-tie nav-icon"></i> {{-- MD icon --}}
                                                  <p>MD</p>
                                              </a>
                                          </li>
                                          <li class="nav-item">
                                              <a href="{{ route('messages.ed.index') }}"
                                                  class="nav-link {{ request()->routeIs('messages.ed.index') ? 'active' : '' }}">
                                                  <i class="fas fa-user-shield nav-icon"></i> {{-- ED icon --}}
                                                  <p>ED</p>
                                              </a>
                                          </li>
                                      </ul>
                                  </li>
                              @endcan
                          </ul>
                      </li>
                  @endcan

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
