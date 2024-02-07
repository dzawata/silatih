<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Tenagakerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class TenagakerjaController extends Controller
{
    function __construct(Tenagakerja $tenagakerja)
    {
        $this->middleware('auth');
        
        $this->tenagakerja = $tenagakerja;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Tenaga Kerja';
        $result['tenagakerjadata'] =   $this->tenagakerja->tenagakerja_display();
        $result['jenis_data'] = $this->tenagakerja->alljenis();
        $result['tingkat'] = $this->tenagakerja->alltingkat();
        $result['jurusan_data'] = $this->tenagakerja->alljurusan();
        $result['kelompok_data'] = $this->tenagakerja->allkelompok();

        if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.tenagakerja.index')->with('result', $result);
    }

    public function add(Request $request)
    {
       $validatiing =  $this->tenagakerja_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->tenagakerja->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function tenagakerja_validator(array $data){
        $messages = [
            'nik.required' => 'NIK harus diisi.',     

            'nama.required' => 'Nama harus diisi.',     
            'nama.max' => 'Nama tidak boleh lebih dari 50 karakter.',     
            
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Email tidak valid.',

            'jenis.required' => 'Jenis harus diisi.',
            'jenis.exists' => 'Jenis tidak valid',
 
            'hp.required' => "No. Telp harus diisi.",
            'hp.numeric' => 'No. Telp tidak valid.',
            'hp.max' => 'No. Telp tidak valid.',
            'hp.min' => 'No. Telp tidak valid.'
        ];

        $validator = Validator::make($data, [
            'nik'  => 'required|max:50',
            'nama'  => 'required|max:50',
            'email' => '|required|unique:users,email',
            'hp' =>'required|min:99999999|max:999999999999999|numeric',
        ], $messages);
        
        return $validator;
    }


    public function edit(Request $request)
    {
        $data = $request->all();
        $pw1 = $data['password1_'.$data['id']];
        $pw2 = $data['password2_'.$data['id']];

        if(empty($pw1) and empty($pw2)){
            $with_password = FALSE;

            $messages = [
                'nama'.$data['id'].'.required' => 'Nama harus diisi.',     
                'nama'.$data['id'].'.max' => 'Nama tidak boleh lebih dari 50 karakter.',     
                'email'.$data['id'].'.required' => 'Email harus diisi.',
                'email'.$data['id'].'.unique' => 'Email sudah digunakan.',
                'email'.$data['id'].'.email' => 'Email tidak valid.',
             
            ];
    
            $validator = Validator::make($data, [
                'nama'.$data['id']          => 'required|max:50',
                'email'.$data['id']         => 'required|unique:users,email,'.$data['email'.$data['id']].',email',
            ], $messages); 

        } else {
            $with_password = true;
            $messages = [
                'nama'.$data['id'].'.required' => 'Nama harus diisi.',     
                'nama'.$data['id'].'.max' => 'Nama tidak boleh lebih dari 50 karakter.',     
                'email'.$data['id'].'.required' => 'Email harus diisi.',
                'email'.$data['id'].'.unique' => 'Email sudah digunakan.',
                'email'.$data['id'].'.email' => 'Email tidak valid.',
              
                'password1_'.$data['id'].'.required' => 'Password harus diisi.',
                'password2_'.$data['id'].'.required' => 'Verifikasi password harus diisi.',
                'password1_'.$data['id'].'.min' => 'Minimal password berjumlah 8 karakter.',
                'password2_'.$data['id'].'.same' => 'Verifikasi password tidak sesuai.',
            ];
    
            $validator = Validator::make($data, [
                'nama'.$data['id']          => 'required|max:50',
                'email'.$data['id']         => 'required|unique:users,email,'.$data['email'.$data['id']].',email',
                'password1_'.$data['id']    => 'required|min:8',
                'password2_'.$data['id']    =>  'same:password1_'.$data['id'].'|required'
            ], $messages);
       
        }
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->user->edit($request->all(), $with_password);
            if($in){
                return redirect()->back()->with('update', 'success');
            } else{
                return redirect()->back()->with('update', 'failed');
            }
       }


    }

    public function hapus(Request $request)
    {

        $hapus = $this->user->hapus($request->id);
            if($hapus){
                return redirect()->back()->with('delete', 'success');
            } else{
                return redirect()->back()->with('delete', 'failed');
            }
    }
}
