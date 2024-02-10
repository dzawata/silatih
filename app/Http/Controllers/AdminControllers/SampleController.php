<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class SampleController extends Controller
{
    public $sample;

    function __construct(Sample $sample)
    {
        $this->middleware('auth');

        $this->sample = $sample;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Sample';
        $result['sampledata'] =   $this->sample->sample_display();
        $result['jenis_data'] = $this->sample->alljenis();
        $result['jurusan_data'] = $this->sample->alljurusan();
        $result['kelompok_data'] = $this->sample->allkelompok();
        $result['pelatihan_data'] = DB::table('pelatihan')->get();
        $result['tingkat_data'] = DB::table('tingkat')->get();

        if (isset($request->page)) {
            $result['i'] = (($request->page - 1) * 10) + 1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.sample.index')->with('result', $result);
    }

    public function add(Request $request)
    {
        $validatiing =  $this->sample_validator($request->all());

        if ($validatiing->fails()) {
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
        } else {
            $in =  $this->sample->insert($request->all());
            if ($in) {
                return redirect()->back()->with('insert', 'success');
            } else {
                return redirect()->back()->with('insert', 'failed');
            }
        }
    }

    public function sample_validator(array $data)
    {
        $messages = [
            'nik.required' => 'NIK harus diisi.',

            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 50 karakter.',

            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Email tidak valid.',

            'jenis.required' => 'Jenis harus diisi.',
            'jenis.exists' => 'Jenis tidak valid',

            'hp.required' => "No. Telp harus diisi.",
            'hp.numeric' => 'No. Telp tidak valid.',
            'hp.max' => 'No. Telp tidak valid.',
            'hp.min' => 'No. Telp tidak valid.'
        ];

        $validator = Validator::make($data, [
            'nik'  => 'required|max:50',
            'nama'  => 'required|max:50',
            'email' => '|required|unique:users,email',
            'hp' => 'required|min:99999999|max:999999999999999|numeric',
        ], $messages);

        return $validator;
    }


    public function edit($id)
    {
        return view('admin.sample.edit', [
            'result' => [
                'judul' => 'Edit Data Sample'
            ],
            'data' => DB::table('sample')->find($id),
            'jenis_data' => DB::table('jenis')->orderBy('id_jenis')->get(),
            'jurusan_data' => DB::table('jurusan')->orderBy('id_jurusan')->get(),
            'kelompok_data' => DB::table('kelompok')->orderBy('id_kelompok')->get(),
            'pelatihan_data' => DB::table('pelatihan')->orderBy('id_pelatihan')->get(),
            'tingkat_data' => DB::table('tingkat')->orderBy('id_tingkat')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama harus diisi.',
            'nik.required' => 'NIK harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'email.required' => 'Email harus  diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'jenis.required' => 'Jenis harus dipilih.',
            'kelompok.required' => 'Kelompok harus dipilih.',
            'pelatihan.required' => 'Pelatihan harus dipilih.',
            'tingkat.required' => 'Tingkat harus dipilih.',
        ];

        $validator = Validator::make([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'hp' => $request->hp,
            'jenis' => $request->jenis,
            'jurusan' => $request->jurusan,
            'kelompok' => $request->kelompok,
            'pelatihan' => $request->pelatihan,
            'tingkat' => $request->tingkat,
        ], [
            'nama' => 'required|max:50',
            'nik' => 'required',
            'jenis_kelamin' =>  'required',
            'email' =>  'required',
            'alamat' =>  'required',
            'jenis' =>  'required',
            'kelompok' =>  'required',
            'pelatihan' =>  'required',
            'tingkat' =>  'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('update', 'failed');
        } else {
            $update = DB::table('sample')->where('id', $request->id)->update([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'hp' => $request->hp,
                'id_jenis' => $request->jenis,
                'id_jurusan' => $request->jurusan,
                'id_kelompok' => $request->kelompok,
                'id_pelatihan' => $request->pelatihan,
                'id_tingkat' => $request->tingkat,
            ]);
            if ($update) {
                return redirect()->back()->with('update', 'success');
            } else {
                return redirect()->back()->with('update', 'failed');
            }
        }
    }

    public function hapus(Request $request)
    {
        // $hapus = $this->user->hapus($request->id);
        // if ($hapus) {
        //     return redirect()->back()->with('delete', 'success');
        // } else {
        //     return redirect()->back()->with('delete', 'failed');
        // }
    }
}
