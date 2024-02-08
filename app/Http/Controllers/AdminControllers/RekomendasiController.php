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

        if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
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
        $sample = DB::table('sample')->select([
            'sample.jenis_kelamin', 
            'jenis.jenis', 
            'jurusan.jurusan', 
            'kelompok.kelompok', 
            'tingkat.tingkat', 
            'pelatihan.pelatihan'
        ])
            ->join('jenis', 'jenis.id_jenis', 'sample.id_jenis')
            ->join('jurusan', 'jurusan.id_jurusan', 'sample.id_jurusan')
            ->join('kelompok', 'kelompok.id_kelompok', 'sample.id_kelompok')
            ->join('tingkat', 'tingkat.id_tingkat', 'sample.id_tingkat')
            ->join('pelatihan', 'pelatihan.id_pelatihan', 'sample.id_pelatihan')
            ->get();
        
        $pelatihan = DB::table('pelatihan')->get();

        $probabilitas = [
            'pelatihan' => [],
            'kategori' => []
        ];
        foreach($sample as $contoh){
            foreach($pelatihan as $latih){
                if($latih->pelatihan == $contoh->pelatihan){
                    if(empty($probabilitas['pelatihan'][$latih->pelatihan])){
                        $probabilitas['pelatihan'][$latih->pelatihan]=[
                            'xkemunculan' => 0,
                            'nilai_prob' => 0
                        ];
                    }
                    $probabilitas['pelatihan'][$latih->pelatihan]['xkemunculan']++;
                }
            }

            if(empty($probabilitas['kategori']['jenis_kelamin'][$contoh->jenis_kelamin])){
                    $probabilitas['kategori']['jenis_kelamin'][$contoh->jenis_kelamin]=[
                        'xkemunculan' => 0,
                        'nilai_prob' => 0
                    ];
            }

            if(array_key_exists($contoh->jenis_kelamin, $probabilitas['kategori']['jenis_kelamin'])){
                // perlu dibuat dinamis
                switch ($contoh->jenis_kelamin) {
                    case 'P':
                    case 'L':
                        $probabilitas['kategori']['jenis_kelamin'][$contoh->jenis_kelamin]['xkemunculan']++;
                        break;
                }
            }

            if(empty($probabilitas['kategori']['tingkat'][$contoh->tingkat])){
                $probabilitas['kategori']['tingkat'][$contoh->tingkat]=[
                    'xkemunculan' => 0,
                    'nilai_prob' => 0
                ];
            }

            if(array_key_exists($contoh->tingkat, $probabilitas['kategori']['tingkat'])){
                // perlu dibuat dinamis
                switch ($contoh->tingkat) {
                    case 'SMP atau Sederajat':
                    case 'SMA atau Sederajat':
                    case 'SMK':
                    case 'S1':
                        $probabilitas['kategori']['tingkat'][$contoh->tingkat]['xkemunculan']++;
                        break;
                }
            }

            if(empty($probabilitas['kategori']['jurusan'][$contoh->jurusan])){
                $probabilitas['kategori']['jurusan'][$contoh->jurusan]=[
                    'xkemunculan' => 0,
                    'nilai_prob' => 0
                ];
            }

            if(array_key_exists($contoh->jurusan, $probabilitas['kategori']['jurusan'])){
                // perlu dibuat dinamis
                switch ($contoh->jurusan) {
                    case 'TATA BOGA':
                    case 'TEKNIK OTOMOTIF':
                    case 'PERHOTELAN':
                    case 'IPA/IPS':
                    case 'MANAJEMEN SDM':
                    case 'UMUM':
                        $probabilitas['kategori']['jurusan'][$contoh->jurusan]['xkemunculan']++;
                        break;
                }
            }

            if(empty($probabilitas['kategori']['kelompok'][$contoh->kelompok])){
                $probabilitas['kategori']['kelompok'][$contoh->kelompok]=[
                    'xkemunculan' => 0,
                    'nilai_prob' => 0
                ];
            }

            if(array_key_exists($contoh->kelompok, $probabilitas['kategori']['kelompok'])){
                // perlu dibuat dinamis
                switch ($contoh->kelompok) {
                    case 'PENCARI KERJA':
                    case 'BEKERJA':
                    case 'BURUH TANI TEMBAKAU':
                    case 'KELOMPOK MASYARAKAT':
                        $probabilitas['kategori']['kelompok'][$contoh->kelompok]['xkemunculan']++;
                        break;
                }
            }
        }

        foreach ($probabilitas['pelatihan'] as $key => $value_prob) {
            $probabilitas['pelatihan'][$key]['nilai_prob'] = $value_prob['xkemunculan'] / count($sample);
        }

        foreach ($probabilitas['kategori'] as $key0 => $value_kategori) {
            foreach ($value_kategori as $key1 => $value) {
                $probabilitas['kategori'][$key0][$key1]['nilai_prob'] = $probabilitas['kategori'][$key0][$key1]['xkemunculan'] / count($sample);
            }
        }
        dd($probabilitas);
    }
}
