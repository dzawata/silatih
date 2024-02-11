<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Tenagakerja extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'tenagakerja';

    public $sortable = ['tenagakerja'];
    protected $fillable = ['tenagakerja'];

    public function tenagakerja_display(){
                    $tenagakerja = $this
                    ->Join('tingkat', 'tingkat.id_tingkat', '=','tenagakerja.id_tingkat')
                    ->Join('jurusan', 'jurusan.id_jurusan', '=','tenagakerja.id_jurusan')
                    ->Join('kelompok', 'kelompok.id_kelompok', '=','tenagakerja.id_kelompok')
                    ->sortable()
                    ->orderBy('id', 'asc')
                ->paginate(10);

        return $tenagakerja;
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

    public function alltingkat()
    {
        $tingkat = DB::table('tingkat')->get();
        return $tingkat;
    }

    public function insert($data)
    {
        $nik       = $data['nik'];
        $nama      = strtoupper($data['nama']);
        $email     = strtolower($data['email']);
        $kelamin   = $data['kelamin'];
        $alamat    = strtolower($data['alamat']);

        $in = DB::table('tenagakerja')->insert([
            'nik'           => $nik,
            'nama'          => $nama,
            'jenis_kelamin' => $kelamin,
            'email'         => $email,
            'alamat'        => $alamat,
            'hp'            => $data['hp'],
            'id_tingkat'    => $data['tingkat'],
            'id_jurusan'    => $data['jurusan'],
            'id_kelompok'   => $data['kelompok']
        ]);
        return $in;
    }

    public function edit($data, $with_password)
    {
        $name       = ucfirst($data['nama' . $data['id']]);
        $email      = strtolower($data['email' . $data['id']]);
        $created    = date('Y-m-d H:i:s');

        if ($with_password) {
            $update_data = [
                'name' => $name,
                'email' => $email,
                'created_at' => $created
            ];
        } else {
            $update_data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($data['password1_' . $data['id']], PASSWORD_DEFAULT),
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
            'role'  => '3',
            'email' => $data['email'],
            'telp' => $data['telp'],
            'opd'   => $data['opd'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $in;
    }

    public function edit_operator($data)
    {
        $id = $data['id'];


        if ($data['verifikasi_ed' . $id] == 1) {
            $very = date('Y-m-d H:i:s');
        } else {
            $very = null;
        }

        if ($data['password_ed' . $id] == NULL) {
            $in = DB::table('users')->where('id', $id)->update([
                'name'  => $data['nama_ed' . $id],
                'email' => $data['email_ed' . $id],
                'telp'  => $data['telp_ed' . $id],
                'email_verified_at' => $very
            ]);
        } else {
            $in = DB::table('users')->where('id', $id)->update([
                'name'  => $data['nama_ed' . $id],
                'email' => $data['email_ed' . $id],
                'telp'  => $data['telp_ed' . $id],
                'email_verified_at' => $very,
                'password' => password_hash($data['password_ed' . $id], PASSWORD_DEFAULT)
            ]);
        }

        return $in;
    }
}
