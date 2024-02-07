<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Probabilitas extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table = 'Probabilitas';

	public $sortable = ['Probabilitas'];
    protected $fillable = [ 'Probabilitas'];

    public function probabilitas_display(){
                    $probabilitas = $this
                    ->sortable()
                ->paginate(10);

        return $probabilitas;
    }

    public function kelamin()
    {
        $kelamin = DB::table('probabilitas')->where('kolom', '=', 'KELAMIN')->get();
        return $kelamin;
    }

    public function pendidikan()
    {
        $pendidikan = DB::table('probabilitas')->where('kolom', '=', 'PENDIDIKAN')->get();
        return $pendidikan;
    }

    public function jurusan()
    {
        $jurusan = DB::table('probabilitas')->where('kolom', '=', 'JURUSAN')->get();
        return $jurusan;
    }

    public function status()
    {
        $status = DB::table('probabilitas')->where('kolom', '=', 'STATUS')->get();
        return $status;
    }
   

}
