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
                <p>Data Tenaga Kerja</p>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ URL::to('/dashboard')}}">Data Testing</a></li>
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
                <i class="fas fa-user-circle nav-icon mr-2"></i>
                Data Tenaga Kerja
                <br>
              </h3>
              <div class="card-tools">
                <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modalTambah"> <i class="fas fa-plus"></i> Data Tenaga Kerja </button>
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
                        <th>HP/Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Pendidikan</th>
                        <th>Jurusan</th>
                        <th>Status Pekerjaan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if (count($result['tenagakerjadata']) > 0)
                      @php $i = $result['i']; $i < count($result['tenagakerjadata']); @endphp @foreach ($result['tenagakerjadata'] as $tenagakerjadata ) <tr>
                        <th>{{ $i++ }}</th>
                        <td>{{ $tenagakerjadata->nik }}<br>
                          <b>{{ $tenagakerjadata->nama }}</b><br>
                          {{ $tenagakerjadata->alamat }}
                        </td>
                        <td>{{ $tenagakerjadata->hp }}<br>{{ $tenagakerjadata->email }}</td>
                        <td>{{ $tenagakerjadata->jenis_kelamin }}</td>
                        <td>{{ $tenagakerjadata->tingkat }}</td>
                        <td>{{ $tenagakerjadata->jurusan }}</td>
                        <td>{{ $tenagakerjadata->kelompok }}</td>
                        <td>
                          <a class="btn btn-primary btn-xs " href="{{ route('tenagakerja.edit', $tenagakerjadata->id) }}"><i class="fa fa-user-edit"></i></a>
                          <a class="btn btn-danger btn-xs " href="{{ route('tenagakerja.hapus', $tenagakerjadata->id) }}" onclick="return confirm('Data dihapus?')"><i class="fas fa-trash"></i></a>

                        </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="6">
                            <center><strong>Tidak Ada Data</strong></center>
                          </td>
                        </tr>
                        @endif
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <div class="card-footer">
              {{$result['tenagakerjadata']->appends(request()->input())->links()}}
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
          <form action="{{ route('tenagakerja.add') }}" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="text" name="nik" id="nik" value="{{ old('nik')}}" class="form-control @error(" nik") is-invalid @enderror" placeholder="Nomor Induk Kependudukan">
              @error('nik')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>
            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input type="text" name="nama" id="nama" value="{{ old('nama')}}" class="form-control @error(" nama") is-invalid @enderror" placeholder="Nama Lengkap">
              @error('nama')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>
            <div class="form-group">
              <label for="kelamin">Jenis Kelamin</label>
              <input type="text" name="kelamin" id="kelamin" value="{{ old('kelamin')}}" class="form-control @error(" kelamin") is-invalid @enderror" placeholder="Jenis Kelamin">
              @error('kelamin')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">No. HP</label>
              <input type="text" name="hp" id="hp" value="{{ old('hp') }}" class="form-control @error(" hp") is-invalid @enderror" placeholder="Np. HP" autocomplete="off">
              @error('hp')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error(" email") is-invalid @enderror" placeholder="Email" autocomplete="off">
              @error('email')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="alamat" name="alamat" id="alamat" value="{{ old('alamat') }}" class="form-control @error(" alamat") is-invalid @enderror" placeholder="Alamat" autocomplete="off">
              @error('alamat')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>

            <div class="form-group">
              <label for="tingkat">Tingkat Pendidikan</label>
              <select name="tingkat" class="form-control @error(" jenis") is-invalid @enderror">
                @foreach ($result['tingkat'] as $tingkat_data)
                <option value="{{$tingkat_data->id_tingkat}}" @if (old('tingkat')==$tingkat_data->id_tingkat) selected @endif>{{$tingkat_data->tingkat}}</option>
                @endforeach
              </select>
              @error('tingkat')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>

            <div class="form-group">
              <label for="jurusan">Jurusan Pendidikan</label>
              <select name="jurusan" class="form-control @error(" jurusan") is-invalid @enderror">
                @foreach ($result['jurusan_data'] as $jurusan_data)
                <option value="{{$jurusan_data->id_jurusan}}" @if (old('jurusan')==$jurusan_data->id_jurusan) selected @endif>{{$jurusan_data->jurusan}}</option>
                @endforeach
              </select>
              @error('jurusan')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>


            <div class="form-group">
              <label for="kelompok">Kelompok Pelatihan</label>
              <select name="kelompok" class="form-control @error(" kelompok") is-invalid @enderror">
                @foreach ($result['kelompok_data'] as $kelompok_data)
                <option value="{{$kelompok_data->id_kelompok}}" @if (old('kelompok')==$kelompok_data->id_kelompok) selected @endif>{{$kelompok_data->kelompok}}</option>
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

  <!-- /.content -->

</div>

<script>

</script>
@endsection