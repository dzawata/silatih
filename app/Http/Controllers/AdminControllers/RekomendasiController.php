<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\rekomendasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class RekomendasiController extends Controller
{
    public $rekomendasi;

    function __construct(rekomendasi $rekomendasi)
    {
        $this->middleware('auth');
        $this->rekomendasi = $rekomendasi;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Tenaga Kerja';
        $result['rekomendasidata'] =   $this->rekomendasi->rekomendasi_display();
        $result['jenis_data'] = $this->rekomendasi->alljenis();
        $result['jurusan_data'] = $this->rekomendasi->alljurusan();
        $result['kelompok_data'] = $this->rekomendasi->allkelompok();

        if (isset($request->page)) {
            $result['i'] = (($request->page - 1) * 10) + 1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.rekomendasi.index')->with('result', $result);
    }


    public function detail(Request $request)
    {
        $result['judul'] = 'Data Tenaga Kerja';
        $result['rekomendasidata'] =   $this->rekomendasi->rekomendasi_display();
        $result['jenis_data'] = $this->rekomendasi->alljenis();
        $result['jurusan_data'] = $this->rekomendasi->alljurusan();
        $result['kelompok_data'] = $this->rekomendasi->allkelompok();
        $result['jurusan'] = $this->rekomendasi->jurusan();

        $result['rekomendasi'] = $this->rekomendasi->rekomendasi();

        $datarekomendasi = $this->rekomendasi->getrekomendasi($request->id);

        return view('admin.rekomendasi.detail')->with('result', $result)->with('datarekomendasi', $datarekomendasi);
    }

    public function proses(Request $request)
    {
        // start training
        $sample = DB::table('sample')
            ->select([
                'sample.nama',
                DB::raw('lower(sample.jenis_kelamin) jenis_kelamin'),
                DB::raw('lower(jurusan.jurusan) jurusan'),
                DB::raw('lower(tingkat.tingkat) tingkat'),
                DB::raw('lower(kelompok.kelompok) kelompok'),
                DB::raw('lower(pelatihan.pelatihan) pelatihan'),
                DB::raw('lower(jenis.jenis) jenis'),
            ])
            ->join('jurusan', 'jurusan.id_jurusan', 'sample.id_jurusan')
            ->join('tingkat', 'tingkat.id_tingkat', 'sample.id_tingkat')
            ->join('kelompok', 'kelompok.id_kelompok', 'sample.id_kelompok')
            ->join('pelatihan', 'pelatihan.id_pelatihan', 'sample.id_pelatihan')
            ->join('jenis', 'jenis.id_jenis', 'sample.id_jenis')
            ->orderBy('id')
            ->get();

        $pelatihan = DB::table('pelatihan')->get();

        $probabilitas = [
            'kelas' => [],
            'kriteria' => []
        ];
        foreach ($sample as $key => $vsample) {
            foreach ($pelatihan as $key => $vpelatihan) {
                if (empty($probabilitas['kelas'][strtolower($vpelatihan->pelatihan)])) {
                    $probabilitas['kelas'][strtolower($vpelatihan->pelatihan)] = [
                        'xkemunculan' => 0,
                        'nilai_prob' => 0,
                    ];
                }

                if ($vsample->pelatihan == strtolower($vpelatihan->pelatihan)) {
                    $probabilitas['kelas'][strtolower($vpelatihan->pelatihan)]['xkemunculan']++;
                }
            }
        }

        foreach ($probabilitas['kelas'] as $key => $prob) {
            $probabilitas['kelas'][$key]['nilai_prob'] = $prob['xkemunculan'] / count($sample);
        }

        $xkriteria = DB::table('x')
            ->orderBy('x')
            ->get();

        foreach ($xkriteria as $key1 => $kriteria) {
            foreach ($pelatihan as $key2 => $vpelatihan) {
                if (empty($probabilitas['kriteria'][strtolower($kriteria->x)][strtolower($kriteria->value)][strtolower($vpelatihan->pelatihan)])) {

                    $jumlah = count($sample
                        ->where(strtolower($kriteria->x), strtolower($kriteria->value))
                        ->where('pelatihan', strtolower($vpelatihan->pelatihan)));

                    $total = count($sample
                        ->where('pelatihan', strtolower($vpelatihan->pelatihan)));

                    $probabilitas['kriteria'][strtolower($kriteria->x)][strtolower($kriteria->value)][strtolower($vpelatihan->pelatihan)] = [
                        'xkemunculan' => $jumlah,
                        'nilai_prob' => $jumlah / $total,
                    ];
                }
            }
        }

        // end training
        // dd($probabilitas);


        // start testing
        $testing = DB::table('view_tenagakerja')
            ->select([
                'nik',
                'nama',
                'email',
                'alamat',
                'hp',
                DB::raw('lower(KELAMIN) jenis_kelamin'),
                DB::raw('lower(JURUSAN) jurusan'),
                DB::raw('lower(STATUS) kelompok'),
                DB::raw('lower(PENDIDIKAN) tingkat'),
            ])
            ->orderBy('id')
            ->get();

        $xkriteria = $xkriteria->unique('x');

        $hasil = [];
        foreach ($testing as $key0 => $test) {
            foreach ($pelatihan as $key1 => $vpelatihan) {
                $hasil[$test->nik][$vpelatihan->pelatihan][] = $probabilitas['kelas'][strtolower($vpelatihan->pelatihan)]['nilai_prob'];
                foreach ($xkriteria as $key2 => $kriteria) {
                    switch ($kriteria->x) {
                        case 'jenis_kelamin':
                            $hasil[$test->nik][$vpelatihan->pelatihan][] = $probabilitas['kriteria'][$kriteria->x][strtolower($test->jenis_kelamin)][strtolower($vpelatihan->pelatihan)]['nilai_prob'];
                            break;

                        case 'jurusan':
                            $hasil[$test->nik][$vpelatihan->pelatihan][] = $probabilitas['kriteria'][$kriteria->x][strtolower($test->jurusan)][strtolower($vpelatihan->pelatihan)]['nilai_prob'];
                            break;

                        case 'kelompok':
                            $hasil[$test->nik][$vpelatihan->pelatihan][] = $probabilitas['kriteria'][$kriteria->x][strtolower($test->kelompok)][strtolower($vpelatihan->pelatihan)]['nilai_prob'];
                            break;

                        case 'tingkat':
                            $hasil[$test->nik][$vpelatihan->pelatihan][] = $probabilitas['kriteria'][$kriteria->x][strtolower($test->tingkat)][strtolower($vpelatihan->pelatihan)]['nilai_prob'];
                            break;
                    }
                }
            }
        }

        $total = [];
        foreach ($hasil as $key => $value) {
            foreach ($value as $key1 => $val) {
                $total[$key1] = array_product($val);
            }

            $rekomendasi = array_search(max($total), $total);

            $query = DB::table('rekomendasi')->where('nik', '=', $key);
            if ($query->count() == 0) {
                DB::table('rekomendasi')
                    ->insert([
                        'nik' => $key,
                        'data' => json_encode($total),
                        'REKOMENDASI' => $rekomendasi

                    ]);
            } else {
                DB::table('rekomendasi')
                    ->where('nik', '=', $key)
                    ->update([
                        'data' => json_encode($total),
                        'REKOMENDASI' => $rekomendasi
                    ]);
            }
        }

        // end testing
        
        return redirect()->back()->with('delete', 'success');
    }
}
