<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\User;
use App\Models\Core\Opd;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(User $user, Opd $opd)
    {
        $this->user = $user;
        $this->opd  = $opd;
    }
    
    public function register(Request $request)
    {
        if(auth()->user() !== null){

            if(auth()->user()->role == 3){
                return redirect('operator/dashboard');
            } elseif(auth()->user()->role == 1 OR auth()->user()->role == 2) {
                return redirect('/dashboard');
            }
        } 
        $result['judul'] = 'Registrasi';        
        $result['opd'] = $this->opd->getall();
        return view('admin.registration')->with('result', $result);

    }

    public function do_register(Request $request)
    {
        $data = $request->all();

        $messages = [
            'nama.required' => 'Nama harus diisi.',     
            'nama.max'      => 'Nama tidak boleh lebih dari 50 karakter.',     
            'nama.min'      => 'Nama tidak boleh kurang dari 2 karakter.',   

            'email.required'    => 'Email harus diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'email.email'       => 'Email tidak valid.',
            
            'telp.min'      => 'Telepon tidak boleh kurang dari 6 karakter.', 
            'telp.max'      => 'Telepon tidak boleh lebih dari 15 karakter.',   
            'telp.required' => 'Telepon harus harus diisi.',   
            'telp.numeric'  => 'Telepon tidak valid.',   
            
            'password.required'  => 'Password harus diisi.',
            'password.gt'  => 'Password minimal 8 karakter.',
            
            'password2.required' => 'Verifikasi password harus diisi.',
            'password2.same' => 'Password tidak sesuai.',

            'opd.exists'    => 'OPD tidak valid',
            'opd.required'    => 'OPD harus diisi',
        ];

        $validator = Validator::make($data, [
            'nama'  => 'required|max:50|min:2',
            'email' => 'required|unique:users,email',
            'telp'  => 'required|min:10|numeric',
            'password'  => 'required|min:7',
            'password2' => 'required|same:password',
            'opd'   => 'required|exists:tb_opd,kdx' 
        ], $messages);
       
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        else{
           $cek_opd = $this->cek_opd($data['opd']);
           if($cek_opd < 1){
               $in =  $this->user->operator_add($data);
               if($in){
                   return redirect('login')->with('registration', "success");
               } else{
                   return redirect()->back()->with('registration', 'failed');
               }

           } else {
            return redirect()->back()->with('opd', 'failed');

           }
        }
    }
    
    public function cek_opd($kdx){
        $operator = DB::table('users')->where('role', '3')->where('opd', $kdx)->get();

        return count($operator);
    }

}
