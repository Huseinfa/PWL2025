@php
    use App\Models\PenjualanModel;
    use App\Models\BarangModel;
@endphp

<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>
            <li class="nav-header">Data Barang</li>
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori')? 'active' : '' }} ">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Kategori Barang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')? 'active' : '' }} ">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Data Barang</p>
                </a>
            </li>
            <li class="nav-header">Data Supplier</li>
            <li class="nav-item">
                <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier')? 'active' : '' }} ">
                    <i class="nav-icon far fa-building"></i>
                    <p>Data Supplier</p>
                </a>
            </li>
            <li class="nav-header">Data Transaksi</li>
            <li class="nav-item {{ ($activeMenu == 'transactions') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ ($activeMenu == 'transactions') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cash-register"></i>
                  <p>
                      Transactions
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">{{ PenjualanModel::count() }}</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('transactions.index') }}" class="nav-link {{ (request()->routeIs('transactions.index')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>History</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('transactions.create') }}" class="nav-link {{ (request()->routeIs('transactions.create')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Create</p>
                      </a>
                  </li>
              </ul>
          </li>
            <li class="nav-item fixed-bottom mx-2">
                <a href="{{ url('/user/profile') }}" class="nav-link {{ ($activeMenu == 'profile')? 'active' : '' }} ">
                    <img src="{{ auth()->user()->user_profile_picture ? asset('storage/'.auth()->user()->user_profile_picture) : asset('storage/profiles/profile_default.png') }}" 
                class="img-circle elevation-2 mr-2" 
                alt="User Image" 
                style="width: 30px; height: 30px; object-fit: cover;">
                    <p> User Profile</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>