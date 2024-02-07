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
                    <p>Data Sample</p>
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
                  <i class="fas fa-database nav-icon mr-2"></i>
                  Data Sample
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-plus"></i> Data Sample </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-sm-6">
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK/Nama/Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Jurusan</th>
                                    <th>Status Pekerjaan</th>
                                    <th>Rekomendasi Pelatihan</th>
                                    <th>Jenis Pelatihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result['sampledata']) > 0)
                                  @php $i = $result['i']; $i < count($result['sampledata']);  @endphp
                                    @foreach ($result['sampledata'] as $sampledata )
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>{{ $sampledata->nik }}<br>
                                            <b>{{ $sampledata->nama }}</b><br>
                                            {{ $sampledata->alamat }}
                                            </td>
                                            <td>{{ $sampledata->jenis_kelamin }}</td>
                                            <td>{{ $sampledata->tingkat }}</td>
                                            <td>{{ $sampledata->jurusan }}</td>
                                            <td>{{ $sampledata->kelompok }}</td>
                                            <td>{{ $sampledata->pelatihan }}</td>
                                            <td>{{ $sampledata->jenis }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-xs " data-toggle="modal" data-target="#modalEdit{{$sampledata->id}}" ><i class="fa fa-user-edit"></i></button>
                                                <button class="btn btn-danger btn-xs " data-toggle="modal" data-target="#modalHapus{{$sampledata->id}}" ><i class="fas fa-trash"></i></button>
                                                
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
                {{$result['sampledata']->appends(request()->input())->links()}}

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
              <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('sample.add') }}" method="post">
                  
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="nik" >NIK</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik')}}"class="form-control @error("nik") is-invalid @enderror" placeholder="Nomor Induk Kependudukan">
                        @error('nik')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="nama" >Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama')}}"class="form-control @error("nama") is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="kelamin" >Jenis Kelamin</label>
                        <input type="text" name="kelamin" id="kelamin" value="{{ old('kelamin')}}"class="form-control @error("kelamin") is-invalid @enderror" placeholder="Jenis Kelamin">
                        @error('kelamin')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="email">No. HP</label>
                      <input type="text" name="hp" id="hp" value="{{ old('hp') }}" class="form-control @error("hp") is-invalid @enderror" placeholder="Np. HP" autocomplete="off">
                      @error('hp')
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
                        <label for="alamat">Alamat</label>
                        <input type="alamat" name="alamat" id="alamat" value="{{ old('alamat') }}" class="form-control @error("alamat") is-invalid @enderror" placeholder="Alamat" autocomplete="off">
                        @error('alamat')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="jenis">Jenis Pelatihan</label>
                      <select name="jenis" class="form-control @error("jenis") is-invalid @enderror">
                        @foreach ($result['jenis_data'] as $jenis_data)
                          <option value="{{$jenis_data->id_jenis}}" @if (old('jenis') == $jenis_data->id_jenis) selected @endif>{{$jenis_data->jenis}}</option>
                        @endforeach
                      </select>
                      @error('jenis')
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="jurusan">Jurusan Pendidikan</label>
                      <select name="jurusan" class="form-control @error("jurusan") is-invalid @enderror">
                        @foreach ($result['jurusan_data'] as $jurusan_data)
                          <option value="{{$jurusan_data->id_jurusan}}" @if (old('jurusan') == $jurusan_data->id_jurusan) selected @endif>{{$jurusan_data->jurusan}}</option>
                        @endforeach
                      </select>
                      @error('jurusan')
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                    </div> 


                    <div class="form-group" >
                      <label for="kelompok">Kelompok Pelatihan</label>
                      <select name="kelompok" class="form-control @error("kelompok") is-invalid @enderror">
                        @foreach ($result['kelompok_data'] as $kelompok_data)
                          <option value="{{$kelompok_data->id_kelompok}}" @if (old('kelompok') == $kelompok_data->id_kelompok) selected @endif>{{$kelompok_data->kelompok}}</option>
                        @endforeach
                      </select>
                      @error('kelompok')
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
  
      @foreach ($result['sampledata'] as $sampledata)
     
        <div class="modal fade" id="modalEdit{{$sampledata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="id" value="{{$sampledata->id}}">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="nama{{$sampledata->id}}" >Nama Lengkap</label>
                        <input type="text" name="nama{{$sampledata->id}}" id="nama{{$sampledata->id}}" value="@if(!empty(old('name'.$sampledata->id))) {{old('nama'.$sampledata->id)}}@else {{$sampledata->name}}@endif"class="form-control @error("nama".$sampledata->id) is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama'.$sampledata->id)
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                        <label for="email{{$sampledata->id}}">Email</label>
                        <input type="email" name="email{{$sampledata->id}}" id="email{{$sampledata->id}}" value="@if(!empty(old('email'.$sampledata->id))){{ old('email'.$sampledata->id) }} @else {{$sampledata->email}}@endif" class="form-control @error("email".$sampledata->id) is-invalid @enderror" placeholder="Email" autocomplete="off">
                        @error('email'.$sampledata->id)
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="password1_{{$sampledata->id}}">Password</label>
                      <input type="password" name="password1_{{$sampledata->id}}" value="@if(!empty(old('password1_'.$sampledata->id))) {{ old('password1_'.$sampledata->id)}} @endif" id="password1_{{$sampledata->id}}" class="form-control @error("password1_".$sampledata->id) is-invalid @enderror" placeholder="Password">
                      @error('password1_'.$sampledata->id)
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                  </div> 
                  <div class="form-group" >
                    <label for="password2_{{$sampledata->id}}">Verifikasi Password</label>
                    <input type="password" name="password2_{{$sampledata->id}}" value="{{ old('password2_'.$sampledata->id)}}" id="password2" class="form-control @error("password2_".$sampledata->id) is-invalid @enderror" placeholder="Verifikasi Password">
                    @error('password2_'.$sampledata->id)
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

        <div class="modal fade" id="modalHapus{{$sampledata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <input type="hidden" name="id" value="{{$sampledata->id}}">
                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                  <p>Apakah anda yakin ingin menghapus data <b>{{$sampledata->name}}</b>?</p>
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
