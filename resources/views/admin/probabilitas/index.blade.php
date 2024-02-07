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
                    <p>Data Probabilitas</p>
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
                  <i class="fas fa-square-root-alt nav-icon mr-2"></i>
                  Data Probabilitas
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-sync"></i> Data Sinc </button>
                </div>
              </div>
              <div class="card-body">


            <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title">Probabilitas</h3></li>
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Jenis Kelamin</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Pendidikan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Jurusan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">Status Pekerjaan</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                  <div class="row">
                    <div class="col-md-12">
                    <table class="table">
                        <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th >JENIS KELAMIN</th>
                                    @php 
                                    $data = $result['kelamin'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                  {{ _epelatihan1($json_data['PELATIHAN']) }}
                                  @endforeach
                                </tr>
                          </thead>
                          <tbody>
                                  @php 
                                    $data = $result['kelamin'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                    {{ 
                                      _enilai(
                                        $json_data['ITEM'],
                                        $json_data['NILAI'],
                                        $json_data['TOTAL']
                                        )
                                    }}
                                  @endforeach
                                
                          </tbody>
                          <tfoot>   
                          @php 
                          _ehitung("Tertinggi",  $json_data['MAX'], -1, $json_data['TOTAL']); 
                          _ehitung("Total", $json_data['TOTAL']); 
                          @endphp
				                  </tfoot>
                        </table>
                    </div>
                  </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                   
                  <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                        <thead class="thead-dark">
                        <tr>
                                    <th>#</th>
                                    <th >PENDIDIKAN</th>
                                    @php 
                                    $data = $result['pendidikan'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                    {{ _epelatihan1($json_data['PELATIHAN']) }}
                                  @endforeach
                                </tr>
                          </thead>
                          <tbody>
                          @php 
                                    $data = $result['pendidikan'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                    {{ 
                                      _enilaipendidikan(
                                        $json_data['ITEM'],
                                        $json_data['NILAI'],
                                        $json_data['TOTAL']
                                        )
                                    }}
                          @endforeach
                          </tbody>
                          <tfoot>
                          @php _ehitungpendidikan("Tertinggi",  $json_data['MAX'], -1, $json_data['TOTAL']); 
                          _ehitungpendidikan("Total", $json_data['TOTAL']); 
                          @endphp
				                  </tfoot>
                        </table>

                           

                    </div>
                  </div>


                  </div>
                  <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                    
                  <div class="row">
                    <div class="col-md-12">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                                    <th>#</th>
                                    <th >JURUSAN</th>
                                    @php 
                                    $data = $result['jurusan'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                  {{ _epelatihan1($json_data['PELATIHAN']) }}
                                  @endforeach
                                </tr>
                          </thead>
                          <tbody>
                          @php 
                                    $data = $result['jurusan'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                    {{ 
                                      _enilaijurusan(
                                        $json_data['ITEM'],
                                        $json_data['NILAI'],
                                        $json_data['TOTAL']
                                        )
                                    }}
                                  @endforeach
                          </tbody>
                          <tfoot>
                          @php _ehitungjurusan("Tertinggi",  $json_data['MAX'], -1, $json_data['TOTAL']); 
                          _ehitungjurusan("Total", $json_data['TOTAL']); 
                          @endphp
				                  </tfoot>
                        </table>

                           

                    </div>
                  </div>

                  </div>
                  <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                    
                  <div class="row">
                    <div class="col-md-12">
                    <table class="table">
                        <thead class="thead-dark">
                                < <tr>
                                    <th>#</th>
                                    <th >STATUS PEKERJAAN</th>
                                    @php 
                                    $data = $result['status'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                  {{ _epelatihan1($json_data['PELATIHAN']) }}
                                  @endforeach
                                </tr>
                          </thead>
                          <tbody>
                          @php 
                                    $data = $result['status'];
                                    @endphp
                                    @foreach ($data as $key => $data )
                                    @php $json_data = json_decode($data->data,true); @endphp
                                    {{ 
                                      _enilaistatus(
                                        $json_data['ITEM'],
                                        $json_data['NILAI'],
                                        $json_data['TOTAL']
                                        )
                                    }}
                                  @endforeach
                          </tbody>
                          <tfoot>
                          @php _ehitungstatus("Tertinggi",  $json_data['MAX'], -1, $json_data['TOTAL']); 
                          _ehitungstatus("Total", $json_data['TOTAL']); 
                          @endphp
				                  </tfoot>
                        </table>

                           

                    </div>
                  </div>

                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
 
              </div>
              <div class="card-footer">
             

              </div>
              
            </div>
            <!-- /.card -->

          </section>
      
        </div>
      
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->

  </div>
  
<script>    
   
</script>
@endsection
