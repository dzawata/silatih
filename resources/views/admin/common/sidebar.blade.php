  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
     <center> <img src="{{ asset('img').'/silatih.png' }}" width="45">   <b class="brand-text font-weight-light">SiLatih</b></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-flat flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Dashboard</li>
          <li class="nav-item">
            <a href="{{ URL::to('dashboard')}}" class="nav-link {{ Request::is('/') ? 'active' : ''}}  {{ Request::is('dashboard') ? 'active' : ''}} ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
    
          <li class="nav-header">Master Data </li>

          @if (auth()->user()->role == 1)
          
          <li class="nav-item">
            <a href="{{ URL::to('users/display')}}" class="nav-link {{ Request::is('users/display') ? 'active' : ''}} {{ Request::is('users/display/filter') ? 'active' : ''}}">
              <i class="far fa-user nav-icon"></i>
              <p>Data Pengguna</p>
            </a>
          </li>

          @endif
          
          <li class="nav-item">
            <a href="{{ URL::to('tingkat/display')}}" class="nav-link {{ Request::is('tingkat/display') ? 'active' : ''}}">
              <i class="fas fa-graduation-cap nav-icon"></i>
              <p>Tingkat Pendidikan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('jurusan/display')}}" class="nav-link {{ Request::is('jurusan/display') ? 'active' : ''}}">
              <i class="fas fa-chalkboard-teacher nav-icon"></i>
              <p>Pendidikan Jurusan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('kelompok/display')}}" class="nav-link {{ Request::is('kelompok/display') ? 'active' : ''}}">
              <i class="far fas fa-shapes nav-icon"></i>
              <p>Kelompok</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('pelatihan/display')}}" class="nav-link {{ Request::is('pelatihan/display') ? 'active' : ''}}">
              <i class="fas fa-chalkboard-teacher nav-icon"></i>
              <p>Pelatihan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('jenis/display')}}" class="nav-link {{ Request::is('jenis/display') ? 'active' : ''}}">
              <i class="far fa-clipboard nav-icon"></i>
              <p>Jenis Pelatihan</p>
            </a>
          </li>



          <li class="nav-header">Data Training </li>
        
          <li class="nav-item">
            <a href="{{ URL::to('sample/display')}}" class="nav-link {{ Request::is('sample/display') ? 'active' : ''}}">
              <i class="fas fa-database nav-icon"></i>
              <p>Data Sampel</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('probabilitas/display')}}" class="nav-link">
              <i class="fas fa-square-root-alt nav-icon"></i>             
              <p>Probabilitas</p>
            </a>
          </li>

          <li class="nav-header">Data Testing </li>
        
          <li class="nav-item">
            <a href="{{ URL::to('tenagakerja/display')}}" class="nav-link">
              <i class="fas fa-user-circle nav-icon"></i>
              <p>Data Tenaga Kerja</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('rekomendasi/display')}}" class="nav-link">
              <i class="fas fa-sticky-note nav-icon"></i>             
              <p>Rekomendasi</p>
            </a>
          </li>
  
          <li class="nav-header">Laporan</li>
          
          <li class="nav-item">
            <a href="{{ URL::to('laporan/display')}}" class="nav-link">
              <i class="fas fa-print nav-icon"></i>
              <p>Rekomendasi</p>
            </a>
          </li>

          <li class="nav-item">
            <br>
            <br>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
