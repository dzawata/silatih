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
                    <p>Kelompok Pelatihan</p>
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
                  <i class="far fas fa-shapes nav-icon mr-2"></i>
                  Data Kelompok Pelatihan
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-plus"></i> Kelompok Pelatihan </button>
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
                                    <th>Kelompok Pelatihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result['kelompokdata']) > 0)
                                  @php $i = $result['i']; $i < count($result['kelompokdata']);  @endphp
                                    @foreach ($result['kelompokdata'] as $kelompokdata )
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>{{ $kelompokdata->kelompok }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-xs " data-toggle="modal" data-target="#modalEdit{{$kelompokdata->id_kelompok}}" ><i class="fa fa-user-edit"></i></button>
                                                <button class="btn btn-danger btn-xs " data-toggle="modal" data-target="#modalHapus{{$kelompokdata->id_kelompok}}" ><i class="fas fa-trash"></i></button>
                                                
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
                {{$result['kelompokdata']->appends(request()->input())->links()}}

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
                <form action="{{ route('kelompok.add') }}" method="post">
                  
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="kelompok" >Kelompok Pelatihan</label>
                        <input type="text" name="kelompok" id="kelompok" value="{{ old('kelompok')}}"class="form-control @error("kelompok") is-invalid @enderror" placeholder="Kelompok Pelatihan">
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
  
      @foreach ($result['kelompokdata'] as $kelompokdata)
     
        <div class="modal fade" id="modalEdit{{$kelompokdata->id_kelompok}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <center>   <h3 class="modal-title" id="exampleModalLabel">Edit Kelompok Pelatihan</h3></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('kelompok.edit') }}" method="post">
                    <input type="hidden" name="id_kelompok" value="{{$kelompokdata->id_kelompok}}">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="kelompok{{$kelompokdata->id_kelompok}}" >Kelompok Pelatihan</label>
                        <input type="text" name="kelompok{{$kelompokdata->id_kelompok}}" id="kelompok{{$kelompokdata->id_kelompok}}" value="@if(!empty(old('kelompok'.$kelompokdata->id_kelompok))) {{old('kelompok'.$kelompokdata->id_kelompok)}}@else {{$kelompokdata->kelompok}}@endif"class="form-control @error("kelompok".$kelompokdata->id_kelompok) is-invalid @enderror" placeholder="Kelompok Pelatihan">
                        @error('nama'.$kelompokdata->id_kelompok)
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

        <div class="modal fade" id="modalHapus{{$kelompokdata->id_kelompok}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <center>   <h3 class="modal-title" id="exampleModalLabel">Hapus Kelompok Pelatihan</h3></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('kelompok.hapus') }}" method="post">
                  <input type="hidden" name="id" value="{{$kelompokdata->id_kelompok}}">
                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                  <p>Apakah anda yakin ingin menghapus data <b>{{$kelompokdata->kelompok}}</b>?</p>
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
