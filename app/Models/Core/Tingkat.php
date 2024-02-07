<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Tingkat extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'tingkat';

	public $sortable = ['tingkat'];
    protected $fillable = [ 'tingkat'];

    public function tingkat_display(){
                    $tingkat = $this
                    ->sortable()
                    ->orderBy('tingkat', 'asc')
                ->paginate(10);
        return $tingkat;
    }

    public function insert($data)
    {
        $tingkat       = ucfirst($data['tingkat']);

        $in =    DB::table('tingkat')->insert([
                    'tingkat'          => $tingkat
                ]);
        return $in;        
    }

    public function edit($data)
    {
        $tingkat       = $data['tingkat'.$data['id_tingkat']];
        $update_data = [
            'tingkat' => $tingkat
        ];
        $up = DB::table('tingkat')->where('id_tingkat', $data['id_tingkat'])->update($update_data);
        return $up;
    }

    public function hapus($id)
    {
        $hapus = DB::table('tingkat')->where('id_tingkat', $id)->delete();
        return true;
    }

    
}
