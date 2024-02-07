<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIALIR  | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="shortcut icon" type="image/jpg" href="{{ asset('img').'/logo-kab-madiun.png' }}"/>
  <link rel="stylesheet" href="{{asset('template')}}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card">
        <div class="card-body login-card-body">
        <div class="login-logo">
            <img src="{{ asset('img').'/logo-kab-madiun.png' }}"width="100" alt="" title="">
        </div>
            
        <p class="login-box-msg">SiAlir v.1</p>
        

        @if (session('registration') == "failed")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong> Registrasi gagal.
                </div> 
            </div>
        </div>
        @endif

        @if (session('opd') == "failed")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong> OPD sudah memiliki operator.
                </div> 
            </div>
        </div>
        @endif
        
        <form method="POST" action="{{ route('pendaftaran') }}">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            @csrf


            <div class="input-group mb-3">
                <input type="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap" id="nama" name="nama" value="{{old('nama')}}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>

            @error('nama')
                <div style="margin:  -15px 0 20px 10px">
                    <span>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    </span>
                </div>
            @enderror
            
            <div class="input-group mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{old('email')}}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

            @error('email')
                <div style="margin:  -15px 0 20px 10px">
                    <span>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    </span>
                </div>
            @enderror
            
            <div class="input-group mb-3">
                <input type="text" class="form-control @error('telp') is-invalid @enderror" placeholder="No. Telp" id="telp" name="telp" value="{{old('telp')}}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                    </div>
                </div>
            </div>

            @error('telp')
                <div style="margin:  -15px 0 20px 10px">
                    <span>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    </span>
                </div>
            @enderror

            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            @error('password')
                <div style="margin:  -15px 0 20px 10px">
                    <span>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    </span>
                </div>
            @enderror
            
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Verifikasi Password" name="password2" required >
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            @error('password2')
                <div style="margin:  -15px 0 20px 10px">
                    <span>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    </span>
                </div>
            @enderror

            
            <div class="input-group mb-3">
                <select name="opd" id="opd" class="form-control">
                    <option value="">== PILIH OPD ==</option>
                    @foreach ($result['opd'] as $opd)
                        <option value="{{$opd->kdx}}" @if( old('opd') == $opd->kdx) selected @endif >{{$opd->nm_unor}}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-building"></span>
                    </div>
                </div>
            </div>

            @error('opd')
                <div style="margin:  -15px 0 20px 10px">
                    <span>
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    </span>
                </div>
            @enderror

            
            <div class="row">
            {{-- <div class="col-8">
                <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                    Remember Me
                </label>
                </div>
            </div> --}}
            <!-- /.col -->
            <div class="col-12">
                <button type="submit" class="btn btn-success btn-block">Register</button>
            </div>
            <!-- /.col -->
            </div>
        </form>   
      <br>
      <div class="row">
        <div class="col-sm-12 text-center">
          <a href="{{ URL::to('login')}}">Sudah memiliki Akun?</a>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-12 text-center">
            Copyright © @php
                echo date('Y')
            @endphp All rights reserved | Pemerintah Kabupaten Madiun
            <br>
            Dikembang oleh : <a href="">TIM PRANATA KOMPUTER</a>
        </div>
      </div>
      {{-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> --}}
      <!-- /.social-auth-links -->

      {{-- <p class="mb-1">
        <a href="">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="" class="text-center">Register a new membership</a>
      </p> --}}
    </div>
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('template')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('template')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('template')}}/dist/js/adminlte.min.js"></script>
</body>
</html>
