<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class User extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'users';

	public $sortable = ['name', 'email', 'telp'];
    protected $fillable = [ 'name', 'email' ];

    public function user_display(){
                    $users = $this
                    ->sortable()
                    ->select('users.*')
                    ->orderBy('users.id', 'desc')
                ->paginate(10);

        return $users;
    }

    function export( $data){

        if(!empty($data['by'])){
            $parameter = $data['parameter'];
            $user = $this
                ->leftJoin('role', 'role.id_role', '=','users.role')
                ->where('users.email', 'LIKE', '%'.$parameter.'%')
                ->where('role', '!=', '3')
                ->orwhere('users.name', 'LIKE' ,'%'.$parameter.'%')
                ->where('role', '!=', '3')
                ->orwhere('role.role_nama', 'LIKE' ,'%'.$parameter.'%')
                ->where('role', '!=', '3')
                ->select('users.id','users.name','role.role_nama','users.telp','users.email')
                ->orderBy('users.id', 'DESC')
                ->get();
        } else {
            $user  = DB::table('users')->where('role', '!=', '3')
                    ->leftJoin('role', 'role.id_role', '=', 'users.role')
                    ->select('users.id','users.name','role.role_nama','users.telp','users.email')
                    ->orderBy('users.id', 'DESC')
                    ->get();
        }

        return $user;
    }

    public function filter($parameter){

            $users = $this
                ->sortable()
                ->leftJoin('role', 'role.id_role', '=','users.role')
                ->where('users.email', 'LIKE', '%'.$parameter.'%')
                ->where('role', '!=', '3')
                ->orwhere('users.name', 'LIKE' ,'%'.$parameter.'%')
                ->where('role', '!=', '3')
                ->orwhere('role.role_nama', 'LIKE' ,'%'.$parameter.'%')
                ->where('role', '!=', '3')
                ->select('users.*', 'role.role_nama as role_name')
                ->orderBy('users.id', 'desc')
                ->sortable()
                ->paginate(10);
            return $users;

    }

    public function allrole()
    {
        $role = DB::table('role')->where('id_role', '!=', '3')->get();
        return $role;
    }

    public function insert($data)
    {
        $name       = ucfirst($data['nama']);
        $email      = strtolower($data['email']);
        $password   = password_hash($data['password1'], PASSWORD_DEFAULT);
        $created    = date('Y-m-d H:i:s');

        $in =    DB::table('users')->insert([
                    'name'          => $name,
                    'email'         => $email,
                    'telp'          => $data['telp'],
                    'password'      => $password,
                    'created_at'    => $created
                ]);
        return $in;        
    }

    public function edit($data, $with_password)
    {
        $name       = ucfirst($data['nama'.$data['id']]);
        $email      = strtolower($data['email'.$data['id']]);
        $created    = date('Y-m-d H:i:s');

        if($with_password){
            $update_data = [
                'name' => $name,
                'email' => $email,
                'created_at' => $created
            ];
        } else {
            $update_data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($data['password1_'.$data['id']], PASSWORD_DEFAULT),
                'created_at' => $created
            ];
        }

        $up = DB::table('users')->where('id', $data['id'])->update($update_data);

        return $up;
    }

    public function hapus($id)
    {
        $hapus = DB::table('users')->where('id', $id)->delete();

        return true;
    }

    public function operator_add($data)
    {
        $in = DB::table('users')->insert([
                'name' => $data['nama'],
                'email' => $data['email'],
                'telp' => $data['telp'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        return $in;
    }

    public function edit_operator($data)
    {
        $id = $data['id'];
        
        
        if($data['verifikasi_ed'.$id] == 1){
            $very = date('Y-m-d H:i:s');
        } else {
            $very = null;
        }
       
        if($data['password_ed'.$id] == NULL){
            $in = DB::table('users')->where('id', $id)->update([
                'name'  => $data['nama_ed'.$id],
                'email' => $data['email_ed'.$id],
                'telp'  => $data['telp_ed'.$id],
                'email_verified_at' => $very
            ]);
        } else {
            $in = DB::table('users')->where('id', $id)->update([
                'name'  => $data['nama_ed'.$id],
                'email' => $data['email_ed'.$id],
                'telp'  => $data['telp_ed'.$id],
                'email_verified_at' => $very,
                'password' => password_hash($data['password_ed'.$id], PASSWORD_DEFAULT)
            ]);
        }

        return $in;
    }
}
