<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Sample extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'sample';

	public $sortable = ['sample'];
    protected $fillable = [ 'sample'];

    public function sample_display(){
                    $sample = $this
                    ->Join('tingkat', 'tingkat.id_tingkat', '=','sample.id_tingkat')
                    ->Join('jurusan', 'jurusan.id_jurusan', '=','sample.id_jurusan')
                    ->Join('kelompok', 'kelompok.id_kelompok', '=','sample.id_kelompok')
                    ->Join('pelatihan', 'pelatihan.id_pelatihan', '=','sample.id_pelatihan')
                    ->sortable()
                    ->orderBy('id', 'asc')
                ->paginate(10);

        return $sample;
    }


    public function alljenis()
    {
        $jenis = DB::table('jenis')->get();
        return $jenis;
    }

    public function alljurusan()
    {
        $jurusan = DB::table('jurusan')->get();
        return $jurusan;
    }

    public function allkelompok()
    {
        $kelompok = DB::table('kelompok')->get();
        return $kelompok;
    }


    public function allpelatihan()
    {
        $pelatihan = DB::table('pelatihan')->get();
        return $pelatihan;
    }


    public function insert($data)
    {
        $nik       = ucfirst($data['nik']);
        $nama       = ucfirst($data['nama']);
        $email      = strtolower($data['email']);
        $kelamin      = strtolower($data['kelamin']);
        $alamat      = strtolower($data['alamat']);

        $in =    DB::table('sample')->insert([
                    'nik'          => $nik,
                    'nama'          => $nama,
                    'jenis_kelamin'          => $kelamin,
                    'email'         => $email,
                    'alamat'         => $alamat,
                    'hp'         => $data['hp'],
                    'id_jenis'          => $data['jenis'],
                    'id_jurusan'          => $data['jurusan'],
                    'id_kelompok'          => $data['kelompok']
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

}
