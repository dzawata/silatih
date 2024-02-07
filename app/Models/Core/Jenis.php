<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Jenis extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'jenis';

	public $sortable = ['jenis'];
    protected $fillable = [ 'jenis'];

    public function jenis_display(){
                    $jenis = $this
                    ->sortable()
                    ->orderBy('jenis', 'desc')
                ->paginate(10);

        return $jenis;
    }

    

    public function insert($data)
    {
        $jenis       = ucfirst($data['jenis']);

        $in =    DB::table('jenis')->insert([
                    'jenis'          => $jenis
                ]);
        return $in;        
    }

    public function edit($data)
    {
        $jenis       = $data['jenis'.$data['id_jenis']];

        $update_data = [
            'jenis' => $jenis
        ];

        $up = DB::table('jenis')->where('id_jenis', $data['id_jenis'])->update($update_data);
        return $up;
    }

    public function hapus($id)
    {
        $hapus = DB::table('jenis')->where('id_jenis', $id)->delete();

        return true;
    }

}
