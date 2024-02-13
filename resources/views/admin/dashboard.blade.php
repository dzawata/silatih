@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
       
        @if ($errors->any())
        <br>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
       
        @if (session('insert') == "success")
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Data telah ditambahkan.
                </div> 
            </div>
        </div>
        @endif
        
        @if (session('insert') == "failed")
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong> Data gagal ditambahkan.
                </div> 
            </div>
        </div>
        @endif

        @if (session('update') == "success")
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Data telah diubah.
                </div> 
            </div>
        </div>
        @endif
        
        @if (session('capsa') == "fail")
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!!</strong> Capsa tidak sesuai.
                </div> 
            </div>
        </div>
        @endif

        @if (session('nominal') == "fail")
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!!</strong> Nominal tidak sesuai atau terlalu melebihi kekurangan pembayaran.
                </div> 
            </div>
        </div>
        @endif

        @if (session('transaksi') == "success")
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!!</strong> Pembayaran berhasil dilakukan.
                </div> 
            </div>
        </div>
        @endif

        <br>
        <div class="row">
          <!-- Left col -->
          <div class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-md-1 d-flex p-2">
                        <img src="{{ asset('img').'/silatih.png' }}" width="70">
                    </div>
                    <div class="col-md-4" style="margin-top: 20px !important">
                    <h4 style="margin-bottom: -3px !important;">DINAS TENAGA KERJA</h4>
                        <h4 style="margin-bottom: -3px !important;">KABUPATEN MAGETAN</h4>
                        <p><b>(Silatih)</b> Sistem Informasi Pelatihan Tenaga Kerja</p>
                    </div>
                </div>
            </div>
          </div>
        </div>

       
          
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h5><b><span id="pengguna">{{number_format($result['pengguna'],0,',','.')}}</span></b> Orang</h5>
          
                          <p>Pengguna</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-user-alt"></i>
                        </div>
                        <a href="{{URL::to('users/display')}}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>


                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h5><b><span id="pelatihan">{{number_format($result['pelatihan'],0,',','.')}}</span></b> Pelatihan</h5>
          
                          <p>Pelatihan</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <a href="{{URL::to('pelatihan/display')}}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    

                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h5><b><span id="pengguna">{{number_format($result['sample'],0,',','.')}}</span></b>Data Sampel</h5>
          
                          <p>Sample</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-database"></i>
                        </div>
                        <a href="{{URL::to('sample/display')}}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>


                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                        <div class="inner">
                          <h5><b><span id="pengguna">{{number_format($result['rekomendasi'],0,',','.')}}</span></b> Data Rekomendasi</h5>
          
                          <p>Rekomendasi</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-database"></i>
                        </div>
                        <a href="{{URL::to('rekomendasi/display')}}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
      
          
      </div>
    </section>
</div>
@endsection
