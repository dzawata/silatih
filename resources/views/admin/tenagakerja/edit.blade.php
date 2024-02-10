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
                                    <li class="breadcrumb-item active">Data Tenaga Kerja</li>
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
                                {{ $result['judul'] }}
                                <br>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('tenagakerja.update') }}" method="post">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" name="nik" id="nik" value="{{ $data->nik }}" class="form-control @error(" nik") is-invalid @enderror" placeholder="Nomor Induk Kependudukan">
                                            @error('nik')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Lengkap</label>
                                            <input type="text" name="nama" id="nama" value="{{ $data->nama }}" class="form-control @error(" nama") is-invalid @enderror" placeholder="Nama Lengkap">
                                            @error('nama')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <input type="text" name="jenis_kelamin" id="jenis_kelamin" value="{{ $data->jenis_kelamin }}" class="form-control @error(" jenis_kelamin") is-invalid @enderror" placeholder="Jenis Kelamin">
                                            @error('jenis_kelamin')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">No. HP</label>
                                            <input type="text" name="hp" id="hp" value="{{ $data->hp  }}" class="form-control @error(" hp") is-invalid @enderror" placeholder="Np. HP" autocomplete="off">
                                            @error('hp')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" value="{{ $data->email  }}" class="form-control @error(" email") is-invalid @enderror" placeholder="Email" autocomplete="off">
                                            @error('email')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="alamat" name="alamat" id="alamat" value="{{ $data->alamat  }}" class="form-control @error(" alamat") is-invalid @enderror" placeholder="Alamat" autocomplete="off">
                                            @error('alamat')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="tingkat">Tingkat Pendidikan</label>
                                            <select name="tingkat" class="form-control @error(" tingkat") is-invalid @enderror">
                                                @foreach ($tingkat_data as $tingkat_data)
                                                <option value="{{$tingkat_data->id_tingkat}}" @if ($data->id_tingkat ==$tingkat_data->id_tingkat) selected @endif>{{$tingkat_data->tingkat}}</option>
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
                                                @foreach ($jurusan_data as $jurusan_data)
                                                <option value="{{$jurusan_data->id_jurusan}}" @if ($data->id_jurusan ==$jurusan_data->id_jurusan) selected @endif>{{$jurusan_data->jurusan}}</option>
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
                                                @foreach ($kelompok_data as $kelompok_data)
                                                <option value="{{$kelompok_data->id_kelompok}}" @if ($data->id_kelompok ==$kelompok_data->id_kelompok) selected @endif>{{$kelompok_data->kelompok}}</option>
                                                @endforeach
                                            </select>
                                            @error('kelompok')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                </div>
                                <a type="button" href="{{ route('tenagakerja.display') }}" class="btn btn-danger">Kembali</a>&nbsp;
                                <input type="submit" class="btn btn-success" id="submit" value="Simpan">
                                </form>
                            </div>
                        </div>

                    </div>

            </div>
            <!-- /.card -->

    </section>

</div>

</div><!-- /.container-fluid -->
</section>