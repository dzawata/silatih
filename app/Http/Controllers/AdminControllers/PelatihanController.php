<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class PelatihanController extends Controller
{
    function __construct(Pelatihan $pelatihan)
    {
        $this->middleware('auth');
        
        $this->pelatihan = $pelatihan;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Pelatihan';
        $result['pelatihandata'] =   $this->pelatihan->pelatihan_display();

               if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.pelatihan.index')->with('result', $result);
    }

    public function add(Request $request)
    {
       $validatiing =  $this->pelatihan_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->pelatihan->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function pelatihan_validator(array $data){
        $messages = [
            'pelatihan.required' => 'Nama pelatihan harus diisi.',     
            'pelatihan.max' => 'Nama pelatihan tidak boleh lebih dari 250 karakter.'
        ];

        $validator = Validator::make($data, [
            'pelatihan'  => 'required|max:250'
        ], $messages);
        
        return $validator;
    }


    public function edit(Request $request)
    {
        $data = $request->all();

        $messages = [
            'pelatihan'.$data['id_pelatihan'].'.required' => 'Nama pelatihan harus diisi.'
         
        ];

        $validator = Validator::make($data, [
            'pelatihan'.$data['id_pelatihan']          => 'required|max:250'
        ], $messages);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->pelatihan->edit($request->all());
            if($in){
                return redirect()->back()->with('update', 'success');
            } else{
                return redirect()->back()->with('update', 'failed');
            }
       }

    }

    public function hapus(Request $request)
    {

        $hapus = $this->pelatihan->hapus($request->id_pelatihan);
            if($hapus){
                return redirect()->back()->with('delete', 'success');
            } else{
                return redirect()->back()->with('delete', 'failed');
            }
    }
}
