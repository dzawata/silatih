@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="invoice p-3 mb-1">
              <div class="row">
                  <div class="col-sm-6">
                    <p>Daftar pengguna</p>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ URL::to('/dashboard')}}">Data Master</a></li>
                      <li class="breadcrumb-item active">{{$result['judul']}}</li>
                    </ol>
                  </div>
              </div>
          </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        
        @if (session('insert') == "success")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Data telah ditambahkan.
                </div> 
            </div>
        </div>
        @endif

        @if (session('insert') == "failed")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong> Data gagal ditambahkan.
                </div> 
            </div>
        </div>
        @endif

        @if (session('update') == "success")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Data telah diubah.
                </div> 
            </div>
        </div>
        @endif
         
        @if (session('update') == "failed")
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!!</strong> Data gagal diubah.
                </div> 
            </div>
        </div>
        @endif

        @if (session('delete') == "success")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Data telah dihapus.
                </div> 
            </div>
        </div>
        @endif

        @if (session('delete') == "failed")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong> Data gagal dihapus.
                </div> 
            </div>
        </div>
        @endif
        
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-user mr-2"></i>
                  Data Pengguna
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-plus"></i> Data Pengguna </button>
                </div>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Lengakap</th>
                                    <th>No. Telp</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result['userdata']) > 0)
                                  @php $i = $result['i']; $i < count($result['userdata']);  @endphp
                                    @foreach ($result['userdata'] as $userdata )
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>{{ $userdata->name }}</td>
                                            <td>{{ $userdata->telp }} </td>
                                            <td>{{ $userdata->email }} </td>
                                            <td>
                                                <button class="btn btn-primary btn-xs " data-toggle="modal" data-target="#modalEdit{{$userdata->id}}" ><i class="fa fa-user-edit"></i></button>
                                                <button class="btn btn-danger btn-xs " data-toggle="modal" data-target="#modalHapus{{$userdata->id}}" ><i class="fas fa-trash"></i></button>
                                                
                                            </td> 
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><center><strong>Tidak Ada Data</strong></center></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                  </div>
                  
              </div>
              <div class="card-footer">
                {{$result['userdata']->appends(request()->input())->links()}}

              </div>
              
            </div>
            <!-- /.card -->

          </section>
      
        </div>
      
      </div><!-- /.container-fluid -->
    </section>

      <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Tambah Data Pengguna</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('user.add') }}" method="post">
                  
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="nama" >Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama')}}"class="form-control @error("nama") is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                   
                    <div class="form-group" >
                      <label for="email">No. Telp</label>
                      <input type="text" name="telp" id="telp" value="{{ old('telp') }}" class="form-control @error("telp") is-invalid @enderror" placeholder="Np. Telp" autocomplete="off">
                      @error('telp')
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                    </div> 

                    <div class="form-group" >
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error("email") is-invalid @enderror" placeholder="Email" autocomplete="off">
                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="password1">Password</label>
                      <input type="password" name="password1" value="{{ old('password1')}}" id="password1" class="form-control @error("password1") is-invalid @enderror" placeholder="Password">
                      @error('password1')
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                  </div> 
                  <div class="form-group" >
                    <label for="password2">Verifikasi Password</label>
                    <input type="password" name="password2" value="{{ old('password2')}}" id="password2" class="form-control @error("password2") is-invalid @enderror" placeholder="Verifikasi Password">
                    @error('password2')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div> 


                  
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-success" id="submit" value="Tambah">
            </form>

            </div>
          </div>
        </div>
      </div>
  
      @foreach ($result['userdata'] as $userdata)
     
        <div class="modal fade" id="modalEdit{{$userdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <center>   <h3 class="modal-title" id="exampleModalLabel">Edit Pengguna</h3></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('user.edit') }}" method="post">
                    <input type="hidden" name="id" value="{{$userdata->id}}">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="nama{{$userdata->id}}" >Nama Lengkap</label>
                        <input type="text" name="nama{{$userdata->id}}" id="nama{{$userdata->id}}" value="@if(!empty(old('name'.$userdata->id))) {{old('nama'.$userdata->id)}}@else {{$userdata->name}}@endif"class="form-control @error("nama".$userdata->id) is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama'.$userdata->id)
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                        <label for="email{{$userdata->id}}">Email</label>
                        <input type="email" name="email{{$userdata->id}}" id="email{{$userdata->id}}" value="@if(!empty(old('email'.$userdata->id))){{ old('email'.$userdata->id) }} @else {{$userdata->email}}@endif" class="form-control @error("email".$userdata->id) is-invalid @enderror" placeholder="Email" autocomplete="off">
                        @error('email'.$userdata->id)
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="password1_{{$userdata->id}}">Password</label>
                      <input type="password" name="password1_{{$userdata->id}}" value="@if(!empty(old('password1_'.$userdata->id))) {{ old('password1_'.$userdata->id)}} @endif" id="password1_{{$userdata->id}}" class="form-control @error("password1_".$userdata->id) is-invalid @enderror" placeholder="Password">
                      @error('password1_'.$userdata->id)
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                  </div> 
                  <div class="form-group" >
                    <label for="password2_{{$userdata->id}}">Verifikasi Password</label>
                    <input type="password" name="password2_{{$userdata->id}}" value="{{ old('password2_'.$userdata->id)}}" id="password2" class="form-control @error("password2_".$userdata->id) is-invalid @enderror" placeholder="Verifikasi Password">
                    @error('password2_'.$userdata->id)
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div> 
     
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-success" id="submit" value="Simpan">
              </form>

              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalHapus{{$userdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <center>   <h3 class="modal-title" id="exampleModalLabel">Edit Pengguna</h3></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('user.hapus') }}" method="post">
                  <input type="hidden" name="id" value="{{$userdata->id}}">
                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                  <p>Apakah anda yakin ingin menghapus data <b>{{$userdata->name}}</b>?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-danger" id="submit" value="Hapus">
              </form>

              </div>
            </div>
          </div>
        </div>

      @endforeach

    <!-- /.content -->

  </div>
  
<script>    
   
</script>
@endsection
