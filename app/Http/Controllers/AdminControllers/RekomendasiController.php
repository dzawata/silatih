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

    // public function proses(Request $request)
    // {   
    //     $proses = true;
    //     if($proses){
    //         $sql = DB::table('probabilitas')->select('kolom','data')->get();
    //         foreach ($sql as $hsl )
    //         $data[$hsl->kolom] = json_decode($hsl->data);
    //         foreach($data as $p => $q) foreach($q->ITEM as $k => $v) $ovale[$p][$v] = $q->NILAI[$k];
    //         $mhs = DB::table('view_tenagakerja')->get();
    //         foreach ($mhs as $row) {
    //             $beasiswa = end($data)->PELATIHAN;
    //             foreach($beasiswa as $key =>$val){
    //                 foreach($data as $p => $q){
    //                     $hasil[$p][$val]['VAL'] = (array_key_exists($row->$p, $ovale[$p]))?$ovale[$p][$row->$p][$key-1]:0;
    //                         $hasil[$p][$val]['TOTAL'] = $q->TOTAL[$key-1];
    //                         $hasil[$p][$val]['NILAI'] = $hasil[$p][$val]['VAL'] / $q->TOTAL[$key-1];
    //             }
    //         }
    //         foreach($beasiswa as $key =>$val){
    //             $ping = null;
    //             foreach($data as $p => $q){
    //                 $ping[$val][] = $hasil[$p][$val]['NILAI'];
    //             }
    //             $hasil['LIKELIHOOD'][$val] = array_product($ping[$val]);
    //         }
    //         foreach($beasiswa as $key =>$val){
    //             $hasil['PROBABILITY'][$val]['TOTAL'] = array_sum($hasil['LIKELIHOOD']);
    //             if(end($beasiswa)==$val):
    //                 $hasil['PROBABILITY']['TIDAK']['TOTAL'] = array_sum($hasil['LIKELIHOOD']);
    //             endif;

    //             if(array_sum($hasil['LIKELIHOOD'])>0):
    //                 $hasil['PROBABILITY'][$val]['NILAI'] = $hasil['LIKELIHOOD'][$val] / $hasil['PROBABILITY'][$val]['TOTAL'];
    //                 if(end($beasiswa)==$val):
    //                     $hasil['PROBABILITY']['TIDAK']['NILAI'] = $hasil['LIKELIHOOD']['TIDAK'] / $hasil['PROBABILITY']['TIDAK']['TOTAL'];
    //                 endif;
    //             else:
    //                 $hasil['PROBABILITY'][$val]['NILAI'] = 0;
    //                 if(end($beasiswa)==$val):
    //                     $hasil['PROBABILITY']['TIDAK']['NILAI'] = 0;
    //                 endif;
    //             endif;
    //         }


    //         if(max($hasil['LIKELIHOOD'])>0)
    //             $hasil['REKOMENDASI'] = array_search(max($hasil['LIKELIHOOD']), $hasil['LIKELIHOOD']);
    //         else
    //             $hasil['REKOMENDASI'] = "UNKNOWN";

    //             //$result[$row->NIM] = $hasil;
    //             $rets = json_encode($hasil);
    //             $query = DB::table('rekomendasi')->where('nik', '=', $row->nik);

    //             if( $query->count() == 0)
    //             {
    //                 DB::table('rekomendasi')
    //                 ->insert(['nik' => $row->nik, 'DATA' => $rets, 'REKOMENDASI' =>$hasil['REKOMENDASI']]);
    //                 return redirect()->back()->with('delete', 'success');
    //             }
    //             else 
    //             {
    //             DB::table('rekomendasi')
    //             ->update(['DATA' => $rets, 'REKOMENDASI'=>$hasil['REKOMENDASI']]);
    //             return redirect()->back()->with('delete', 'success');
    //             }
    //         }
    //     }
    // }

    public function proses(Request $request)
    {
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
        return redirect()->back()->with('delete', 'success');
    }
}
