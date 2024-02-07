<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class KelompokController extends Controller
{
    function __construct(Kelompok $kelompok)
    {
        $this->middleware('auth');
        
        $this->kelompok = $kelompok;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Kelompok Pelatihan';
        $result['kelompokdata'] =   $this->kelompok->kelompok_display();

               if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.kelompok.index')->with('result', $result);
    }
    public function add(Request $request)
    {
       $validatiing =  $this->kelompok_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->kelompok->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function kelompok_validator(array $data){
        $messages = [
            'kelompok.required' => 'Kelompok pelatihan harus diisi.',     
            'kelompok.max' => 'Kelompok pelatihan tidak boleh lebih dari 250 karakter.'
        ];

        $validator = Validator::make($data, [
            'kelompok'  => 'required|max:250'
        ], $messages);
        
        return $validator;
    }


    public function edit(Request $request)
    {
        $data = $request->all();

        $messages = [
            'kelompok'.$data['id_kelompok'].'.required' => 'Kelompok pelatihan harus diisi.'
         
        ];

        $validator = Validator::make($data, [
            'kelompok'.$data['id_kelompok']          => 'required|max:250'
        ], $messages);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->kelompok->edit($request->all());
            if($in){
                return redirect()->back()->with('update', 'success');
            } else{
                return redirect()->back()->with('update', 'failed');
            }
       }

    }

    public function hapus(Request $request)
    {

        $hapus = $this->kelompok->hapus($request->id);
            if($hapus){
                return redirect()->back()->with('delete', 'success');
            } else{
                return redirect()->back()->with('delete', 'failed');
            }
    }
}
