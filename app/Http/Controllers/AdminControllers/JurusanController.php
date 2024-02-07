<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class JurusanController extends Controller
{
    function __construct(Jurusan $jurusan)
    {
        $this->middleware('auth');
        
        $this->jurusan = $jurusan;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Jurusan';
        $result['jurusandata'] =   $this->jurusan->jurusan_display();

               if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.jurusan.index')->with('result', $result);
    }

    public function add(Request $request)
    {
       $validatiing =  $this->jurusan_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->jurusan->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function jurusan_validator(array $data){
        $messages = [
            'jurusan.required' => 'Nama jursan harus diisi.',     
            'jurusan.max' => 'Nama jurusan tidak boleh lebih dari 250 karakter.'
        ];

        $validator = Validator::make($data, [
            'jurusan'  => 'required|max:250'
        ], $messages);
        
        return $validator;
    }


    public function edit(Request $request)
    {
        $data = $request->all();

        $messages = [
            'jurusan'.$data['id_jurusan'].'.required' => 'Nama jurusan harus diisi.'
         
        ];

        $validator = Validator::make($data, [
            'jurusan'.$data['id_jurusan']          => 'required|max:250'
        ], $messages);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->jurusan->edit($request->all());
            if($in){
                return redirect()->back()->with('update', 'success');
            } else{
                return redirect()->back()->with('update', 'failed');
            }
       }

    }

    public function hapus(Request $request)
    {

        $hapus = $this->jurusan->hapus($request->id);
            if($hapus){
                return redirect()->back()->with('delete', 'success');
            } else{
                return redirect()->back()->with('delete', 'failed');
            }
    }
}
