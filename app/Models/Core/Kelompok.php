<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Kelompok extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'kelompok';

	public $sortable = ['kelompok'];
    protected $fillable = [ 'kelompok'];

    public function kelompok_display(){
                    $kelompok = $this
                    ->sortable()
                    ->orderBy('kelompok', 'desc')
                ->paginate(10);

        return $kelompok;
    }

    

    public function insert($data)
    {
        $kelompok      = ucfirst($data['kelompok']);

        $in =    DB::table('kelompok')->insert([
                    'kelompok'          => $kelompok
                ]);
        return $in;        
    }

    public function edit($data)
    {
        $kelompok       = $data['kelompok'.$data['id_kelompok']];

        $update_data = [
            'kelompok' => $kelompok
        ];

        $up = DB::table('kelompok')->where('id_kelompok', $data['id_kelompok'])->update($update_data);
        return $up;
    }

    public function hapus($id)
    {
        $hapus = DB::table('kelompok')->where('id_kelompok', $id)->delete();

        return true;
    }

}
