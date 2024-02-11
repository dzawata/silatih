<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Sample;
use App\Models\Core\rekomendasi;
use PDF;

class LaporanController extends Controller
{
    public $sample;
    public $rekomendasi;

    public function __construct(Sample $sample, rekomendasi $rekomendasi)
    {
        $this->sample = $sample;
        $this->rekomendasi = $rekomendasi;
    }

    public function display(Request $request)
    {
        $result['judul'] = "Laporan Rekomendasi Pelatihan";
        $result['pelatihandata'] = $this->sample->allpelatihan();
        return view('admin.laporan.index')->with('result', $result);
    }

    public function rekomendasi(Request $request)
    {
        $pelatihans = $request->input('pelatihan');
        $result['judul'] = "DATA LAPORAN HASIL REKOMENDASI";
        if ($pelatihans != '') {

            $pelatihan = DB::table('pelatihan')->where('id_pelatihan', $pelatihans)->first();
            $rekomendasidata = DB::table('rekomendasi as A')
                ->select(
                    'A.nik',
                    'G.nama',
                    'G.alamat',
                    'G.jenis_kelamin',
                    'A.rekomendasi',
                    'B.tingkat',
                    'C.jurusan',
                    'D.kelompok'
                )
                ->leftjoin('tenagakerja as G', function ($join) {
                    $join->on('A.nik', '=', 'G.nik');
                })
                ->leftjoin('tingkat as B', function ($join) {
                    $join->on('G.id_tingkat', '=', 'B.id_tingkat');
                })
                ->leftjoin('jurusan as C', function ($join) {
                    $join->on('G.id_jurusan', '=', 'C.id_jurusan');
                })
                ->leftjoin('kelompok as D', function ($join) {
                    $join->on('G.id_kelompok', '=', 'D.id_kelompok');
                })
                ->where('A.rekomendasi', 'like', $pelatihan->pelatihan . '%')
                ->orderBy('G.nama', 'DESC')
                ->get();


            $pdf = PDF::loadview('admin.laporan.rekomendasi_pdf', ['rekomendasidata' => $rekomendasidata, 'result' => $result])->setPaper('A4', 'landscape');
            return $pdf->stream('laporan_rekomendasi' . '' . date('H:i:s d-m-Y') . '.pdf');
        } else {
            $rekomendasidata = DB::table('rekomendasi as A')
                ->select(
                    'A.nik',
                    'G.nama',
                    'G.alamat',
                    'G.jenis_kelamin',
                    'A.rekomendasi',
                    'B.tingkat',
                    'C.jurusan',
                    'D.kelompok'
                )
                ->leftjoin('tenagakerja as G', function ($join) {
                    $join->on('A.nik', '=', 'G.nik');
                })
                ->leftjoin('tingkat as B', function ($join) {
                    $join->on('G.id_tingkat', '=', 'B.id_tingkat');
                })
                ->leftjoin('jurusan as C', function ($join) {
                    $join->on('G.id_jurusan', '=', 'C.id_jurusan');
                })
                ->leftjoin('kelompok as D', function ($join) {
                    $join->on('G.id_kelompok', '=', 'D.id_kelompok');
                })
                ->orderBy('G.nama', 'DESC')
                ->get();


            $pdf = PDF::loadview('admin.laporan.rekomendasi_pdf', ['rekomendasidata' => $rekomendasidata, 'result' => $result])->setPaper('A4', 'landscape');
            return $pdf->stream('laporan_rekomendasi' . '' . date('H:i:s d-m-Y') . '.pdf');
        }
    }
}
