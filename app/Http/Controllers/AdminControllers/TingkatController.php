<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class TingkatController extends Controller
{
    function __construct(Tingkat $tingkat)
    {
        $this->middleware('auth');
        
        $this->tingkat = $tingkat;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Tingkat Pendidikan';
        $result['tingkatdata'] =   $this->tingkat->tingkat_display();

               if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.tingkat.index')->with('result', $result);
    }

    public function add(Request $request)
    {
       $validatiing =  $this->tingkat_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->tingkat->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function tingkat_validator(array $data){
        $messages = [
            'tingkat.required' => 'Nama harus diisi.',     
            'tingkat.max' => 'Nama tidak boleh lebih dari 250 karakter.'
        ];

        $validator = Validator::make($data, [
            'tingkat'  => 'required|max:250',
        ], $messages);
        
        return $validator;
    }


    public function edit(Request $request)
    {
        $data = $request->all();
            
            $messages = [
            'tingkat'.$data['id_tingkat'].'.required' => 'Tingkat Pendidikan harus diisi.',     
            ];
            $validator = Validator::make($data, [
                'tingkat'.$data['id_tingkat']          => 'required|max:250'
            ], $messages);
       
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->tingkat->edit($request->all());
            if($in){
                return redirect()->back()->with('update', 'success');
            } else{
                return redirect()->back()->with('update', 'failed');
            }
       }

    }

    public function hapus(Request $request)
    {

        $hapus = $this->tingkat->hapus($request->id);
            if($hapus){
                return redirect()->back()->with('delete', 'success');
            } else{
                return redirect()->back()->with('delete', 'failed');
            }
    }
}
