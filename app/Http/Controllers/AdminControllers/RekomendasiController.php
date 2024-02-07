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

    public function proses(Request $request)
    {   
        $proses = true;
        if($proses){
            $sql = DB::table('probabilitas')->select('kolom','data')->get();
            foreach ($sql as $hsl )
            $data[$hsl->kolom] = json_decode($hsl->data);
            foreach($data as $p => $q) foreach($q->ITEM as $k => $v) $ovale[$p][$v] = $q->NILAI[$k];
            $mhs = DB::table('view_tenagakerja')->get();
            foreach ($mhs as $row) {
                $beasiswa = end($data)->PELATIHAN;
                foreach($beasiswa as $key =>$val){
                    foreach($data as $p => $q){
                        $hasil[$p][$val]['VAL'] = (array_key_exists($row->$p, $ovale[$p]))?$ovale[$p][$row->$p][$key-1]:0;
                            $hasil[$p][$val]['TOTAL'] = $q->TOTAL[$key-1];
                            $hasil[$p][$val]['NILAI'] = $hasil[$p][$val]['VAL'] / $q->TOTAL[$key-1];
                }
            }
            foreach($beasiswa as $key =>$val){
                $ping = null;
                foreach($data as $p => $q){
                    $ping[$val][] = $hasil[$p][$val]['NILAI'];
                }
                $hasil['LIKELIHOOD'][$val] = array_product($ping[$val]);
            }
            foreach($beasiswa as $key =>$val){
                $hasil['PROBABILITY'][$val]['TOTAL'] = array_sum($hasil['LIKELIHOOD']);
                if(end($beasiswa)==$val):
                    $hasil['PROBABILITY']['TIDAK']['TOTAL'] = array_sum($hasil['LIKELIHOOD']);
                endif;

                if(array_sum($hasil['LIKELIHOOD'])>0):
                    $hasil['PROBABILITY'][$val]['NILAI'] = $hasil['LIKELIHOOD'][$val] / $hasil['PROBABILITY'][$val]['TOTAL'];
                    if(end($beasiswa)==$val):
                        $hasil['PROBABILITY']['TIDAK']['NILAI'] = $hasil['LIKELIHOOD']['TIDAK'] / $hasil['PROBABILITY']['TIDAK']['TOTAL'];
                    endif;
                else:
                    $hasil['PROBABILITY'][$val]['NILAI'] = 0;
                    if(end($beasiswa)==$val):
                        $hasil['PROBABILITY']['TIDAK']['NILAI'] = 0;
                    endif;
                endif;
            }
            

            if(max($hasil['LIKELIHOOD'])>0)
                $hasil['REKOMENDASI'] = array_search(max($hasil['LIKELIHOOD']), $hasil['LIKELIHOOD']);
            else
                $hasil['REKOMENDASI'] = "UNKNOWN";

                //$result[$row->NIM] = $hasil;
                $rets = json_encode($hasil);
                $query = DB::table('rekomendasi')->where('nik', '=', $row->nik);
                
                if( $query->count() == 0)
                {
                    DB::table('rekomendasi')
                    ->insert(['nik' => $row->nik, 'DATA' => $rets, 'REKOMENDASI' =>$hasil['REKOMENDASI']]);
                    return redirect()->back()->with('delete', 'success');
                }
                else 
                {
                DB::table('rekomendasi')
                ->update(['DATA' => $rets, 'REKOMENDASI'=>$hasil['REKOMENDASI']]);
                return redirect()->back()->with('delete', 'success');
                }
            }
        }
    }
}
