<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Probabilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class ProbabilitasController extends Controller
{
    function __construct(Probabilitas $probabilitas)
    {
        $this->middleware('auth');
        
        $this->probabilitas = $probabilitas;

    }

  

    public function display(Request $request)
    {
        $result['judul'] = 'Data Probabilitas';
        $result['kelamin'] = $this->probabilitas->kelamin();
        $result['pendidikan'] = $this->probabilitas->pendidikan();
        $result['jurusan'] = $this->probabilitas->jurusan();
        $result['status'] = $this->probabilitas->status();
        
        if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }


        return view('admin.probabilitas.index')->with('result', $result);
    }
  
}
