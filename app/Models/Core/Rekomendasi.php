<?php

namespace App\Models\Core;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Rekomendasi extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'rekomendasi';

    public $sortable = ['rekomendasi'];
    protected $fillable = ['rekomendasi'];

    public function rekomendasi_display()
    {
        $rekomendasi = $this
            ->Join('tenagakerja', 'tenagakerja.nik', '=', 'rekomendasi.nik')
            ->Join('tingkat', 'tingkat.id_tingkat', '=', 'tenagakerja.id_tingkat')
            ->Join('jurusan', 'jurusan.id_jurusan', '=', 'tenagakerja.id_jurusan')
            ->Join('kelompok', 'kelompok.id_kelompok', '=', 'tenagakerja.id_kelompok')
            ->sortable()
            ->orderBy('rekomendasi.id')
            ->paginate(10);

        return $rekomendasi;
    }


    public function alljenis()
    {
        $jenis = DB::table('jenis')->get();
        return $jenis;
    }

    public function alljurusan()
    {
        $jurusan = DB::table('jurusan')->get();
        return $jurusan;
    }

    public function allkelompok()
    {
        $kelompok = DB::table('kelompok')->get();
        return $kelompok;
    }

    public function allpelatihan()
    {
        $pelatihan = DB::table('pelatihan')->get();
        return $pelatihan;
    }

    public function jurusan()
    {
        $jurusan = DB::table('rekomendasi')->get();
        return $jurusan;
    }

    public function rekomendasi()
    {
        $rekomendasi = DB::table('rekomendasi')->get();
        return $rekomendasi;
    }


    public function probabilitas()
    {
        $probabilitas = DB::table('probabilitas')->get();
        return $probabilitas;
    }

    public function tenagakerja()
    {
        $tenagakerja = DB::table('tenagakerja')->get();
        return $tenagakerja;
    }


    public function cari_pelatihan($data)
    {
        $pelatihan = $data['pelatihan'];
        //$pelatihans = $request->input('pelatihan'); 
        //$tagihan = $this->where('biaya_listrik', '>', 0)->where('id_akun', $akun)->where('poriode', 'like', '%' . $tahun . '%')->get();

        $rekomendasipelatihan = $this
            ->Join('tingkat', 'tingkat.id_tingkat', '=', 'rekomendasi.id_tingkat')
            ->Join('jurusan', 'jurusan.id_jurusan', '=', 'rekomendasi.id_jurusan')
            ->Join('kelompok', 'kelompok.id_kelompok', '=', 'rekomendasi.id_kelompok')
            ->Join('pelatihan', 'pelatihan.id_pelatihan', '=', 'rekomendasi.id_pelatihan')
            ->Join('jenis', 'jenis.id_jenis', '=', 'rekomendasi.id_jenis')
            //->where('pelatihan', 'like', '%' . $pelatihans . '%')
            ->sortable()
            ->orderBy('nama', 'desc')
            ->paginate(10);

        return $rekomendasipelatihan;
    }

    public function detail(Request $request)
    {
        $rekomendasi = $this
            ->Join('tenagakerja', 'tenagakerja.nik', '=', 'rekomendasi.nik')
            ->Join('tingkat', 'tingkat.id_tingkat', '=', 'tenagakerja.id_tingkat')
            ->Join('jurusan', 'jurusan.id_jurusan', '=', 'tenagakerja.id_jurusan')
            ->Join('kelompok', 'kelompok.id_kelompok', '=', 'tenagakerja.id_kelompok')
            ->sortable()
            ->orderBy('nama', 'desc')
            ->paginate(10);
    }

    public function getrekomendasi($id)
    {
        $rekomendasi =  DB::table('rekomendasi')
            ->Join('tenagakerja', 'tenagakerja.nik', '=', 'rekomendasi.nik')
            ->select('rekomendasi.*', 'tenagakerja.nama as nama')
            ->where('rekomendasi.id', $id)->get()->first();
        return $rekomendasi;
    }
}
