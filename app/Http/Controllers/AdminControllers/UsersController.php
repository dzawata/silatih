<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class UsersController extends Controller
{
    function __construct(User $user)
    {
        $this->middleware('auth');
        
        $this->user = $user;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Pengguna';
        $result['userdata'] =   $this->user->user_display();

        if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.users.index')->with('result', $result)->with('by', "")->with('parameter', "");
    }

    function filter(Request $request){
        $result['judul'] = 'Data Pengguna';

        $filterBy = $request->by;
        $parameter = $request->parameter;

        $result['userdata'] =   $this->user->filter($parameter);
        $result['role_data'] = $this->user->allrole();
        if(isset($request->page)){
            $result['i'] = (($request->page - 1) * 10)+1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.users.index')->with('result', $result)->with('by', $filterBy)->with('parameter', $parameter);  


    }

    public function export_excel(Request $request)
    {
        $data = new UserExport($this->user, $request->all());
        
        return Excel::download($data, 'users'.date('H:i:s_DmY').'.xlsx');
    }
// uses
    public function export_pdf(Request $request)
    {
        $result['judul'] = "Data User ";
        $result['users'] = $this->user->export($request->all());
        
        $pdf = PDF::loadview('admin.users.user_pdf',['result'=> $result])->setPaper('A4', 'landscape');
    	return $pdf->download('users'.''.date('H:i:s d-m-Y').'.pdf');
    }

    public function add(Request $request)
    {
       $validatiing =  $this->user_validator($request->all());
       
       if($validatiing->fails()){
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
       } else{
            $in =  $this->user->insert($request->all());
            if($in){
                return redirect()->back()->with('insert', 'success');
            } else{
                return redirect()->back()->with('insert', 'failed');
            }
       }        
    }
    
    public function user_validator(array $data){
        $messages = [
            'nama.required' => 'Nama harus diisi.',     
            'nama.max' => 'Nama tidak boleh lebih dari 50 karakter.',     
            
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            
            'password1.required' => 'Password harus diisi.',
            'password1.min' => 'Minimal password berjumlah 8 karakter.',
            
            'password2.required' => 'Verifikasi password harus diisi.',
            'password2.same' => 'Verifikasi password tidak sesuai.',

            'telp.required' => "No. Telp harus diisi.",
            'telp.numeric' => 'No. Telp tidak valid.',
            'telp.max' => 'No. Telp tidak valid.',
            'telp.min' => 'No. Telp tidak valid.'
        ];

        $validator = Validator::make($data, [
            'nama'  => 'required|max:50',
            'email' => '|required|unique:users,email',
            'password1' => 'required|min:8',
            'password2' =>  'same:password1|required',
            'telp' =>'required|min:99999999|max:999999999999999|numeric',
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
