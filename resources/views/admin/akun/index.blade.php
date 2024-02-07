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
                  <div class="col-sm-9">
                    <p>{{$result['deskripsi']}}</p>
                  </div>
                  <div class="col-sm-3">
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
{{-- alert --}}

          <div>
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
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan!!</strong> Data gagal diubah.
                    </div> 
                </div>
            </div>
            @endif

            @if ( session()->has('delete') AND session('delete')['success'] == "0")
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan!!</strong> {{session('delete')['pesan']}}.
                    </div> 
                </div>
            </div>
            @endif

            @if ( session()->has('delete') AND session('delete')['success'] == "1")
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{session('delete')['pesan']}}.
                    </div> 
                </div>
            </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
        
        </div>

        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
      
                
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    {{$result['judul']}}
                  <br>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah" > <i class="fas fa-plus"></i> Tambah data Gedung</button>
                </div>
              </div>
              <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                      <form action="{{ route('akun_listrik.filter') }}" method="get">
                        <div class="input-group">
                            <select class="form-control-sm bg-secondary mr-1" name="by">
                                <option value="semua"  @if ($by =='semua' )  selected  @endif>Semua</option>
                            </select>
                            
                            <input type="text" class="form-control-sm input-sm" name="parameter" placeholder="Cari" required value="@if(!empty($_GET['parameter'])){{$_GET['parameter']}}@endif">
                            <button type="submit" class="btn btn-sm btn-primary ml-1"><i class="fas fa-search"></i></button>
                            @if (isset($_GET['by']) ) 
                                <a class="btn btn-danger btn-sm  ml-1" href="{{ URL::to('akun_listrik/display')}}"><i class="far fa-times-circle"></i></a>
                            @endif
                        
                        </div>
                      </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="p-1 border align-middle text-center bg-light " rowspan="2">#</th>
                                    <th class="p-1 border align-middle text-center bg-light " rowspan="2">@sortablelink('opd_kdx','OPD')</th>
                                    <th class="p-1 border align-middle text-center bg-light " rowspan="2">@sortablelink('nama_gedung','Nama Gedung')</th>
                                    <th class="p-1 border align-middle text-center bg-light " colspan="4">Luas Bangunan</th>
                                    <th class="p-1 border align-middle text-center bg-light " colspan="3">Jam Kerja</th>
                                    <th class="p-1 border align-middle text-center bg-light " rowspan="2">@sortablelink('jumlah_orang','Jumlah pengguna OPD')</th>
                                    <th class="p-1 border align-middle text-center bg-light " rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                  <th class="p-1 border align-middle text-center bg-light ">@sortablelink('luas_bangunan_ac',' Ber-AC')</th>
                                  <th class="p-1 border align-middle text-center bg-light ">@sortablelink('luas_bangunan_tanpa_ac',' Tanpa AC')</th>
                                  <th class="p-1 border align-middle text-center bg-light ">@sortablelink('luas_bangunan','Total')</th>
                                  <th class="p-1 border align-middle text-center bg-light ">Kriteria</th>
                                  <th class="p-1 border align-middle text-center bg-light ">@sortablelink('jam_kerja_senin_kamis','Senin - Kamis')</th>
                                  <th class="p-1 border align-middle text-center bg-light ">@sortablelink('jam_kerja_jumat','Jumat')</th>
                                  <th class="p-1 border align-middle text-center bg-light ">@sortablelink('jam_kerja_sabtu_minggu','Sabtu - Minggu')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result['dataakun']) > 0)
                                    @php $i = 1+(($result['page']-1) * $result['dataakun']->count()); $i < count($result['dataakun']);  @endphp
                                    @foreach ($result['dataakun'] as $d)
                                        <tr>
                                          @php
                                          $rasio = 0;
                                          if ($d->luas_bangunan_ac > 0) {
                                             $rasio = $d->luas_bangunan_ac/$d->luas_bangunan;
                                          } 
                                          if ($rasio > 0.89) {
                                            $kriteria = "Ber AC";
                                          } else if($rasio < 0.10){
                                            $kriteria = "Tanpa AC";
                                          } else {
                                            $kriteria = "Semi AC";
                                          }
                                          @endphp
                                            <td class="p-1 border">{{$i++}}</td>
                                            <td class="p-1 border">{{ $d->nama}}</td>
                                            <td class="p-1 border">{{ $d->nama_gedung}}</td>
                                            <td class="p-1 border">{{ number_format($d->luas_bangunan_ac,2,',','.') }} M<sup>2</sup>({{number_format($rasio,2,',','.')}}%)</td>
                                            <td class="p-1 border">{{ number_format($d->luas_bangunan - $d->luas_bangunan_ac,2,',','.') }} M<sup>2</sup> ({{number_format(100-$rasio,2,',','.')}}%)</td>
                                            <td class="p-1 border">{{ number_format($d->luas_bangunan,2,',','.') }} M<sup>2</sup> (100%)</td>
                                            <td class="p-1 border"> Bangunan {{$kriteria}}</td>
                                            <td class="p-1 border"> {{$d->jam_kerja_senin_kamis}} Jam</td>
                                            <td class="p-1 border"> {{$d->jam_kerja_jumat}} Jam</td>
                                            <td class="p-1 border"> {{$d->jam_kerja_sabtu_minggu}} Jam</td>
                                            <td class="p-1 border">{{ $d->jumlah_orang }} Orang</td>
                                            <td class="p-1 border">
                                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalEdit{{$d->id_akun}}" ><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalHapus{{$d->id_akun}}" ><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>   
                                    @endforeach 
                                @else 
                                <tr>
                                    <td colspan="9" class="text-center bg-secondary">Data Kosong</td>  
                                </tr>        
                                @endif                               
                            </tbody>
                        </table>
                    </div>
                </div>
                  
              </div>
              <div class="modal-footer">
                    {{$result['dataakun']->appends(request()->input())->links()}}
              </div>
              
            </div>
            <!-- /.card -->
       
          </section>
      
        </div>
      
      </div><!-- /.container-fluid -->
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah {{$result['judul']}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('akun_listrik.add') }}" method="POST">
      @csrf

      <div class="modal-body">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label>OPD :</label>
                  <select name="opd" class="form-control @error('opd') is-invalid @enderror" readonly>
                    @foreach ($result['opddata'] as $opddata)
                      <option value="{{$opddata->kdx}}" @if(old('opd') == $opddata->kdx ) selected @endif>{{$opddata->nm_unor}}</option>
                    @endforeach
                  </select>
                  @error('opd')
                      <small class="text-danger">{{$message}}</small>
                  @enderror
              </div>

              <div class="form-group">
                <label for="">Nama Gedung</label>
                <input type="text" name="nama_gedung" class="form-control @error('nama_gedung')is-invalid @enderror" placeholder="Nama Gedung" value="{{old('nama_gedung')}}">
                @error('nama_gedung')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="">Alamat Gedung</label>
                <input type="text" name="alamat" class="form-control @error('alamat')is-invalid @enderror" placeholder="Alamat Gedung" value="{{ old('alamat')}}">
                @error('alamat')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="">Telp/Fax</label>
                <input type="text" name="telp" class="form-control @error('telp')is-invalid @enderror" placeholder="No. Telp/Fax" value="{{old('telp')}}">
                @error('telp')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="">Kontak Person</label>
                <input type="text" name="hp" class="form-control @error('hp')is-invalid @enderror" placeholder="Kontak Person"  value="{{old('hp')}}">
                @error('hp')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="luas_bangunan">Luas Bangunan :</label>
                <div class="input-group">
                    <input type="text" class="form-control @error('luas_bangunan') is-invalid @enderror" placeholder="Luas Bangunan" name="luas_bangunan" value="{{old('luas_bangunan')}}">
                    <span class="input-group-text" id="basic-addon1">M<sup>2</sup></span>
                </div>
                @error('luas_bangunan')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="luas_bangunan_ac">Luas Lantai Ber-AC:</label>
                <div class="input-group">
                  <input type="text" class="form-control @error('luas_bangunan_ac') is-invalid @enderror" placeholder="Luas Bangunan AC" name="luas_bangunan_ac" value="{{old('luas_bangunan_ac')}}">
                  <span class="input-group-text" id="basic-addon1">M<sup>2</sup></span>
                </div>
                @error('luas_bangunan_ac')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="jam_senin">Jam Kerja Senin - Kamis :</label>
                <div class="input-group">
                    <input type="time" class="form-control @error('jam_senin_awal') is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_senin_awal" value="{{ old('jam_senin_awal')}}">
                    <span class="input-group-text" id="basic-addon1">Sampai</span>
                    <input type="time" class="form-control @error('jam_senin_akhir') is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_senin_akhir" value="{{ old('jam_senin_akhir') }}">
                </div>
                @error('jam_senin_awal')
                  <small class="text-danger">{{ $message }}</small>
                @enderror 
                @error('jam_senin_akhir')
                  <br>
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="jam_jumat">Jam Kerja Jumat :</label>
                <div class="input-group">
                    <input type="time" class="form-control @error('jam_jumat_awal') is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_jumat_awal" value="{{ old('jam_jumat_awal')}}">
                    <span class="input-group-text" id="basic-addon1">Sampai</span>
                    <input type="time" class="form-control @error('jam_jumat_akhir') is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_jumat_akhir" value="{{ old('jam_jumat_akhir')}}">
                </div>
                @error('jam_jumat_awal')
                  <small class="text-danger">{{ $message }}</small>
                @enderror 
                @error('jam_jumat_akhir')
                  <br>
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="jam_sabtu">Jam Kerja Sabtu - Minggu :</label>
                <div class="input-group">
                    <input type="time" class="form-control @error('jam_sabtu_awal') is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_sabtu_awal" value="{{ old('jam_sabtu_awal')}}">
                    <span class="input-group-text" id="basic-addon1">Jam</span>
                    <input type="time" class="form-control @error('jam_sabtu_akhir') is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_sabtu_akhir" value="{{ old('jam_sabtu_akhir') }}">
                </div>
                @error('jam_sabtu_awal')
                  <small class="text-danger">{{ $message }}</small>
                @enderror 
                @error('jam_sabtu_akhir')
                  <br>
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Jumlah Pengguna (Pegawai, staf, siswa, dll)</label>
                <div class="input-group">
                  <input type="text" class="form-control @error('jumlah_orang') is-invalid @enderror" placeholder="Jumlah Pengguna (Pegawai, staf, siswa, dll)" name="jumlah_orang" value="{{ old('jumlah_orang')}}">
                  <span class="input-group-text" id="basic-addon1">Orang</span>
                </div>
                @error('jumlah_orang')
                  <small class="text-danger">{{$message}}</small> 
                @enderror
              </div>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
@foreach ($result['dataakun'] as $dataakun)

<div class="modal fade" id="modalEdit{{$dataakun->id_akun}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit {{$result['judul']}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('akun_listrik.edit') }}" method="POST">
        @csrf
        <input type="hidden" value="{{$dataakun->id_akun}}" name="id">
        <div class="modal-body">
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>OPD :</label>
                    <select name="opd_ed{{$dataakun->id_akun}}" class="form-control @error('opd_ed'.$dataakun->id_akun) is-invalid @enderror" readonly>
                        <option value="{{$dataakun->kdx}}">{{$dataakun->nama}}</option>
                    </select>
                    @error('opd_ed'.$dataakun->id_akun)
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                  <label for="">Nama Gedung</label>
                  <input type="text" name="nama_gedung_ed{{$dataakun->id_akun}}" class="form-control @error('nama_gedung_ed'.$dataakun->id_akun)is-invalid @enderror" placeholder="Nama Gedung" value="{{$dataakun->nama_gedung}}">
                  @error('nama_gedung_ed'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="">Alamat Gedung</label>
                  <input type="text" name="alamat_ed{{$dataakun->id_akun}}" class="form-control @error('alamat_ed'.$dataakun->id_akun)is-invalid @enderror" placeholder="Alamat Gedung" value="{{$dataakun->alamat}}">
                  @error('alamat_ed'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="">Telp/Fax</label>
                  <input type="text" name="telp{{$dataakun->id_akun}}" class="form-control @error('telp'.$dataakun->id_akun)is-invalid @enderror" placeholder="No. Telp/Fax" value="{{$dataakun->telp}}">
                  @error('telp'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="">Kontak Person</label>
                  <input type="text" name="hp{{$dataakun->id_akun}}" class="form-control @error('hp'.$dataakun->id_akun)is-invalid @enderror" placeholder="Kontak Person" value="{{$dataakun->hp}}">
                  @error('hp'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="luas_bangunan_ed{{$dataakun->id_akun}}">Luas Bangunan :</label>
                  <div class="input-group">
                      <input type="text" class="form-control @error('luas_bangunan_ed'.$dataakun->id_akun) is-invalid @enderror" placeholder="Luas Bangunan" name="luas_bangunan_ed{{$dataakun->id_akun}}" value="{{$dataakun->luas_bangunan}}">
                      <span class="input-group-text" id="basic-addon1">M<sup>2</sup></span>
                  </div>
                  @error('luas_bangunan_ed'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="luas_bangunan_ac_ed{{$dataakun->id_akun}}">Luas Lantai Ber-AC:</label>
                  <div class="input-group">
                    <input type="text" class="form-control @error('luas_bangunan_ac_ed'.$dataakun->id_akun) is-invalid @enderror" placeholder="Luas Bangunan AC" name="luas_bangunan_ac_ed{{$dataakun->id_akun}}" value="{{$dataakun->luas_bangunan_ac}}">
                    <span class="input-group-text" id="basic-addon1">M<sup>2</sup></span>
                  </div>
                  @error('luas_bangunan_ac_ed'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="jam_senin{{$dataakun->id_akun}}">Jam Kerja Senin - Kamis :</label>
                  <div class="input-group">
                      <input type="time" class="form-control @error('jam_senin_awal'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_senin_awal{{$dataakun->id_akun}}" value="{{ $dataakun->jam_senin_awal }}">
                      <span class="input-group-text" id="basic-addon1">Sampai</span>
                      <input type="time" class="form-control @error('jam_senin_akhir'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_senin_akhir{{$dataakun->id_akun}}" value="{{ $dataakun->jam_senin_akhir }}">
                  </div>
                  @error('jam_senin_awal'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror 
                  @error('jam_senin_akhir'.$dataakun->id_akun)
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="jam_jumat{{$dataakun->id_akun}}">Jam Kerja Jumat :</label>
                  <div class="input-group">
                      <input type="time" class="form-control @error('jam_jumat_awal'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_jumat_awal{{$dataakun->id_akun}}" value="{{ $dataakun->jam_jumat_awal }}">
                      <span class="input-group-text" id="basic-addon1">Sampai</span>
                      <input type="time" class="form-control @error('jam_jumat_akhir'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_jumat_akhir{{$dataakun->id_akun}}" value="{{ $dataakun->jam_jumat_awal }}">
                  </div>
                  @error('jam_jumat_awal'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror 
                  @error('jam_jumat_akhir'.$dataakun->id_akun)
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="jam_sabtu{{$dataakun->id_akun}}">Jam Kerja Sabtu - Minggu :</label>
                  <div class="input-group">
                      <input type="time" class="form-control @error('jam_sabtu_awal'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_sabtu_awal{{$dataakun->id_akun}}" value="{{ $dataakun->jam_sabtu_awal }}">
                      <span class="input-group-text" id="basic-addon1">Jam</span>
                      <input type="time" class="form-control @error('jam_sabtu_akhir'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jam Kerja per-Hari"  name="jam_sabtu_akhir{{$dataakun->id_akun}}" value="{{ $dataakun->jam_sabtu_akhir }}">
                  </div>
                  @error('jam_sabtu_awal'.$dataakun->id_akun)
                    <small class="text-danger">{{ $message }}</small>
                  @enderror 
                  @error('jam_sabtu_akhir'.$dataakun->id_akun)
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
                
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jumlah Pengguna (Pegawai, staf, siswa, dll)</label>
                  <div class="input-group">
                    <input type="text" class="form-control @error('jumlah_orang_ed'.$dataakun->id_akun) is-invalid @enderror" placeholder="Jumlah Pengguna (Pegawai, staf, siswa, dll)" name="jumlah_orang_ed{{$dataakun->id_akun}}" value="{{$dataakun->jumlah_orang}}">
                    <span class="input-group-text" id="basic-addon1">Orang</span>
                  </div>
                  @error('jumlah_orang_ed'.$dataakun->id_akun)
                    <small class="text-danger">{{$message}}</small> 
                  @enderror
                </div>
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-sm btn-success">Ubah</button>
        </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalHapus{{$dataakun->id_akun}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus {{$result['judul']}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('akun_listrik.hapus') }}" method="POST">
        @csrf
        <input type="hidden" value="{{$dataakun->id_akun}}" name="id">
        <div class="modal-body">
          <p>Anda yakin untuk menhapus data akun ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
        </form>
        </div>
      </div>
    </div>
</div>

@endforeach
@endsection