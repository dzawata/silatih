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
                    <p>Detail Rekomendasi</p>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ URL::to('/dashboard')}}">Data Master</a></li>
                      <li class="breadcrumb-item active"><a href="{{ URL::to('/rekomendasi/display')}}">{{$result['judul']}}</a></li>
                    </ol>
                  </div>
              </div>
          </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-sticky-note nav-icon mr-2"></i>
                  Data Detail Rekomendasi
                  <br>
                </h3>
              </div>
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-sm-6">
                  <h4>NAMA :  <input readonly class="form-control" value="{{$datarekomendasi->nama}}"></h4>
                  <h4>NIK : <input readonly class="form-control" value="{{$datarekomendasi->nik}}"> </h4>
                  <h4>REKOMENDASI : <input readonly class="form-control" value="{{$datarekomendasi->rekomendasi}}"></h4>  
                </div>
                </div>
                  <div class="row">
                    <div class="col-md-12">
                    <table class="table">
                        <thead class="thead-dark">
                                <tr>
                                    <th>ATRIBUT</th>
                                    @php 
                                    $data = json_decode($datarekomendasi->data);
                                    @endphp
                                    @foreach(reset($data) as $a => $b)
                                      <th>{{ $a }}</th>
                                      @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            @php 
                            $data = json_decode($datarekomendasi->data);
                            $dt=0; 
                            foreach($data as $a => $b): $dt++; if($dt>4) break;
			                      switch($a){
				                    default: $item=$a; break;
			                      }
                            @endphp
                            <tr>
				                    <td>{{ $item }}</td>
                            @foreach($data->$a as $c => $d)
				                    <td>{{ number_format($d->NILAI,12,',','.') }}</td>
				                    @endforeach
                            </tr>       
                            @endforeach
                            </tbody>
                            <tfoot>
      <tr>
				<th align=center>PROBABILITY VALUE</th>
				@foreach($data->PROBABILITY as $c => $d)
				<td>{{ number_format($d->NILAI,12,',','.') }}</td>
				@endforeach
			</tr>
      </tfoot>
                        </table>
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

      
@endsection
