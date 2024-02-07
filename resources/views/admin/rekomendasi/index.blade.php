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
                    <p>Data Rekomendasi</p>
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
                    <strong>Berhasil!</strong> Data telah berhasil diproses.
                </div> 
            </div>
        </div>
        @endif

        @if (session('delete') == "failed")
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong> Data gagal diproses.
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
                  <i class="fas fa-sticky-note nav-icon mr-2"></i>
                  Data Hasil Rekomendasi Pelatihan
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-sync"></i> Data Sinc </button>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($result['rekomendasidata']) > 0)
                                  @php $i = $result['i']; $i < count($result['rekomendasidata']);  @endphp
                                    @foreach ($result['rekomendasidata'] as $rekomendasidata )
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>{{ $rekomendasidata->nik }}<br>
                                            <b>{{ $rekomendasidata->nama }}</b><br>
                                            {{ $rekomendasidata->alamat }}
                                            </td>
                                            <td>{{ $rekomendasidata->jenis_kelamin }}</td>
                                            <td>{{ $rekomendasidata->tingkat }}</td>
                                            <td>{{ $rekomendasidata->jurusan }}</td>
                                            <td>{{ $rekomendasidata->kelompok }}</td>
                                            <td bgcolor="#ffd4b8">{{ $rekomendasidata->rekomendasi }}</td>
                                            <td>
                                                <a class="btn-primary btn-xs " href="{{ URL::to('rekomendasi/detail/'.$rekomendasidata->id)}}" title="Detail"><i class="far fa-eye"></i></a>
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
                {{$result['rekomendasidata']->appends(request()->input())->links()}}

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
              <h4 class="modal-title" id="exampleModalLabel">Proses Rekomendasi Pelatihan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('rekomendasi.proses') }}" method="post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <p>Hasil Probabilitas yang paling besar yang akan menunjukkan Rekomendasi Pelatihan</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-success" id="submit" value="Proses">
            </form>

            </div>
          </div>
        </div>
      </div>
  
      @foreach ($result['rekomendasidata'] as $rekomendasidata)
     
        <div class="modal fade" id="modalEdit{{$rekomendasidata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="id" value="{{$rekomendasidata->id}}">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="nama{{$rekomendasidata->id}}" >Nama Lengkap</label>
                        <input type="text" name="nama{{$rekomendasidata->id}}" id="nama{{$rekomendasidata->id}}" value="@if(!empty(old('name'.$rekomendasidata->id))) {{old('nama'.$rekomendasidata->id)}}@else {{$rekomendasidata->name}}@endif"class="form-control @error("nama".$rekomendasidata->id) is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama'.$rekomendasidata->id)
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                        <label for="email{{$rekomendasidata->id}}">Email</label>
                        <input type="email" name="email{{$rekomendasidata->id}}" id="email{{$rekomendasidata->id}}" value="@if(!empty(old('email'.$rekomendasidata->id))){{ old('email'.$rekomendasidata->id) }} @else {{$rekomendasidata->email}}@endif" class="form-control @error("email".$rekomendasidata->id) is-invalid @enderror" placeholder="Email" autocomplete="off">
                        @error('email'.$rekomendasidata->id)
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div> 

                    <div class="form-group" >
                      <label for="password1_{{$rekomendasidata->id}}">Password</label>
                      <input type="password" name="password1_{{$rekomendasidata->id}}" value="@if(!empty(old('password1_'.$rekomendasidata->id))) {{ old('password1_'.$rekomendasidata->id)}} @endif" id="password1_{{$rekomendasidata->id}}" class="form-control @error("password1_".$rekomendasidata->id) is-invalid @enderror" placeholder="Password">
                      @error('password1_'.$rekomendasidata->id)
                          <small class="text-danger">
                              {{ $message }}
                          </small>
                      @enderror
                  </div> 
                  <div class="form-group" >
                    <label for="password2_{{$rekomendasidata->id}}">Verifikasi Password</label>
                    <input type="password" name="password2_{{$rekomendasidata->id}}" value="{{ old('password2_'.$rekomendasidata->id)}}" id="password2" class="form-control @error("password2_".$rekomendasidata->id) is-invalid @enderror" placeholder="Verifikasi Password">
                    @error('password2_'.$rekomendasidata->id)
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

        <div class="modal fade" id="modalHapus{{$rekomendasidata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <input type="hidden" name="id" value="{{$rekomendasidata->id}}">
                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                  <p>Apakah anda yakin ingin menghapus data <b>{{$rekomendasidata->name}}</b>?</p>
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
