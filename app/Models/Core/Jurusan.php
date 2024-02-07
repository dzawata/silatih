<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Jurusan extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'jurusan';

	public $sortable = ['jurusan'];
    protected $fillable = [ 'jurusan'];

    public function jurusan_display(){
                    $jurusan  = $this
                    ->sortable()
                    ->orderBy('jurusan', 'desc')
                ->paginate(10);

        return $jurusan;
    }

    public function insert($data)
    {
        $jurusan       = ucfirst($data['jurusan']);

        $in =    DB::table('jurusan')->insert([
                    'jurusan'          => $jurusan
                ]);
        return $in;        
    }

    public function edit($data)
    {
        $jurusan       = $data['jurusan'.$data['id_jurusan']];

        $update_data = [
            'jurusan' => $jurusan
        ];

        $up = DB::table('jurusan')->where('id_jurusan', $data['id_jurusan'])->update($update_data);
        return $up;
    }

    public function hapus($id)
    {
        $hapus = DB::table('jurusan')->where('id_jurusan', $id)->delete();

        return true;
    }

}
