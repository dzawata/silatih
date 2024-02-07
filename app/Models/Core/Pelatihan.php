<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Pelatihan extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'pelatihan';

	public $sortable = ['nama'];
    protected $fillable = [ 'nama'];

    public function pelatihan_display(){
                    $pelatihan = $this
                    ->sortable()
                    ->orderBy('pelatihan', 'desc')
                ->paginate(10);

        return $pelatihan;
    }

    
    public function insert($data)
    {
        $pelatihan      = ucfirst($data['pelatihan']);

        $in =    DB::table('pelatihan')->insert([
                    'pelatihan'          => $pelatihan
                ]);
        return $in;        
    }

    public function edit($data)
    {
        $pelatihan       = $data['pelatihan'.$data['id_pelatihan']];

        $update_data = [
            'pelatihan' => $pelatihan
        ];

        $up = DB::table('pelatihan')->where('id_pelatihan', $data['id_pelatihan'])->update($update_data);
        return $up;
    }

    public function hapus($id)
    {
        $hapus = DB::table('pelatihan')->where('id_pelatihan', $id)->delete();

        return true;
    }

}
