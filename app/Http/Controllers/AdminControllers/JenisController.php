<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class JenisController extends Controller
{
    function __construct(Jenis $jenis)
    {
        $this->middleware('auth');
        
        $this->jenis = $jenis;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Jenis Pelatihan';
        $result['jenisdata'] =   $this->jenis->jenis_display();

               if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.jenis.index')->with('result', $result);
    }
    public function add(Request $request)
    {
       $validatiing =  $this->jenis_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->jenis->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function jenis_validator(array $data){
        $messages = [
            'jenis.required' => 'Jenis pelatihan harus diisi.',     
            'jenis.max' => 'Jenis pelatihan tidak boleh lebih dari 250 karakter.'
        ];

        $validator = Validator::make($data, [
            'jenis'  => 'required|max:250'
        ], $messages);
        
        return $validator;
    }


    public function edit(Request $request)
    {
        $data = $request->all();

        $messages = [
            'jenis'.$data['id_jenis'].'.required' => 'Jenis pelatihan harus diisi.'
         
        ];

        $validator = Validator::make($data, [
            'jenis'.$data['id_jenis']          => 'required|max:250'
        ], $messages);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->jenis->edit($request->all());
            if($in){
                return redirect()->back()->with('update', 'success');
            } else{
                return redirect()->back()->with('update', 'failed');
            }
       }

    }

    public function hapus(Request $request)
    {

        $hapus = $this->jenis->hapus($request->id);
            if($hapus){
                return redirect()->back()->with('delete', 'success');
            } else{
                return redirect()->back()->with('delete', 'failed');
            }
    }
}
