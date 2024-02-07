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
                    <p>Jurusan Pendidikan</p>
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
                  <i class="fas fa-chalkboard-teacher nav-icon mr-2"></i>
                  Data Jurusan
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-plus"></i> Data Jurusan </button>
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
                                    <th>Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result['jurusandata']) > 0)
                                  @php $i = $result['i']; $i < count($result['jurusandata']);  @endphp
                                    @foreach ($result['jurusandata'] as $jurusandata )
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>{{ $jurusandata->jurusan }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-xs " data-toggle="modal" data-target="#modalEdit{{$jurusandata->id_jurusan}}" ><i class="fa fa-user-edit"></i></button>
                                                <button class="btn btn-danger btn-xs " data-toggle="modal" data-target="#modalHapus{{$jurusandata->id_jurusan}}" ><i class="fas fa-trash"></i></button>
                                                
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
                {{$result['jurusandata']->appends(request()->input())->links()}}

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
              <h4 class="modal-title" id="exampleModalLabel">Tambah Jurusan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('jurusan.add') }}" method="post">
                  
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="jurusan" >Nama Jurusan</label>
                        <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan')}}"class="form-control @error("jurusan") is-invalid @enderror" placeholder="Nama Jurusan">
                        @error('jurusan')
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
  
      @foreach ($result['jurusandata'] as $jurusandata)
     
        <div class="modal fade" id="modalEdit{{$jurusandata->id_jurusan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <center>   <h3 class="modal-title" id="exampleModalLabel">Edit Jurusan</h3></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('jurusan.edit') }}" method="post">
                    <input type="hidden" name="id_jurusan" value="{{$jurusandata->id_jurusan}}">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="jurusan{{$jurusandata->id_jurusan}}" >Jurusan</label>
                        <input type="text" name="jurusan{{$jurusandata->id_jurusan}}" id="jurusan{{$jurusandata->id_jurusan}}" value="@if(!empty(old('jurusan'.$jurusandata->id_jurusan))) {{old('jurusan'.$jurusandata->id_jurusan)}}@else {{$jurusandata->jurusan}}@endif"class="form-control @error("jurusan".$jurusandata->id_jurusan) is-invalid @enderror" placeholder="Jurusan">
                        @error('jurusan'.$jurusandata->id_jurusan)
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

        <div class="modal fade" id="modalHapus{{$jurusandata->id_jurusan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <center>   <h3 class="modal-title" id="exampleModalLabel">Hapus Jurusan</h3></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('jurusan.hapus') }}" method="post">
                  <input type="hidden" name="id" value="{{$jurusandata->id_jurusan}}">
                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                  <p>Apakah anda yakin ingin menghapus data <b>{{$jurusandata->jurusan}}</b>?</p>
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
