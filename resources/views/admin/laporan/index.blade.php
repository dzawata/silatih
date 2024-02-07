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
                    <p>Laporan</p>
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
        <div>

            @if (session('tidak_ada') == true)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Data yang diinginkan tidak ada</strong>
                    </div> 
                </div>
            </div>
            @endif

        </div>
        
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-print mr-2"></i>
                    {{$result['judul']}}
                  <br>
                </h3>
              </div>
              <div class="card-body">
                
                <form action="{{  route('laporan.rekomendasi')}}" method="post">
                    @csrf
                <div class="form-group">
                    <label for="akun" >Nama Pelatihan</label> 
                    <select class="form-control select2 @error('pelatihan') is-invalid @enderror" name="pelatihan" id="select_the_pelatihan" style="width: 100%;">
                    <option value="" selected>Pilih Nama Pelatihan</option>
                            @foreach ($result["pelatihandata"]  as $pelatihandata)
                                @if ($pelatihandata-> pelatihan != 'LAIN-LAIN')
                                <option value="{{$pelatihandata->id_pelatihan}}" @if(old('pelatihan') == $pelatihandata->id_pelatihan) selected @endif>{{$pelatihandata->pelatihan}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('pelatihandata')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    
                </div>

              </div>
              
              <div class="card-footer text-right">
                    <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-file-pdf mr-2"></i>Cetak PDF</button>
              </div>
            </form>
            </div>
            <!-- /.card -->
          </section>
      
        </div>
      
      </div><!-- /.container-fluid -->
    </section>
  </div>

@endsection
