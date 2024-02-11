<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Tenagakerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use PDF;

class TenagakerjaController extends Controller
{
    public $tenagakerja;

    function __construct(Tenagakerja $tenagakerja)
    {
        $this->middleware('auth');

        $this->tenagakerja = $tenagakerja;
    }

    public function display(Request $request)
    {
        $result['judul'] = 'Data Tenaga Kerja';
        $result['tenagakerjadata'] =   $this->tenagakerja->tenagakerja_display();
        $result['jenis_data'] = $this->tenagakerja->alljenis();
        $result['tingkat'] = $this->tenagakerja->alltingkat();
        $result['jurusan_data'] = $this->tenagakerja->alljurusan();
        $result['kelompok_data'] = $this->tenagakerja->allkelompok();

        if (isset($request->page)) {
            $result['i'] = (($request->page - 1) * 10) + 1;
        } else {
            $result['i'] = 1;
        }
        return view('admin.tenagakerja.index')->with('result', $result);
    }

    public function add(Request $request)
    {
        $validatiing =  $this->tenagakerja_validator($request->all());

        if ($validatiing->fails()) {
            return redirect()->back()->withErrors($validatiing)->withInput()->with('insert', 'failed');
        } else {
            $in =  $this->tenagakerja->insert($request->all());
            if ($in) {
                return redirect()->back()->with('insert', 'success');
            } else {
                return redirect()->back()->with('insert', 'failed');
            }
        }
    }

    public function tenagakerja_validator(array $data)
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
        return view('admin.tenagakerja.edit', [
            'result' => [
                'judul' => 'Edit Data tenaga Kerja'
            ],
            'data' => DB::table('tenagakerja')->find($id),
            'tingkat_data' => DB::table('tingkat')->orderBy('id_tingkat')->get(),
            'jurusan_data' => DB::table('jurusan')->orderBy('id_jurusan')->get(),
            'kelompok_data' => DB::table('kelompok')->orderBy('id_kelompok')->get(),
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
            'tingkat.required' => 'Tingkat harus dipilih.',
            'jurusan.required' => 'Jurusan harus dipilih.',
            'kelompok.required' => 'Kelompok harus dipilih.',
        ];

        $validator = Validator::make([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'jurusan' => $request->jurusan,
            'tingkat' => $request->tingkat,
            'kelompok' => $request->kelompok,
        ], [
            'nama' => 'required|max:50',
            'nik' => 'required',
            'jenis_kelamin' =>  'required',
            'email' =>  'required',
            'alamat' =>  'required',
            'jurusan' =>  'required',
            'tingkat' =>  'required',
            'kelompok' =>  'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('update', 'failed');
        } else {
            $update = DB::table('tenagakerja')->where('id', $request->id)->update([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'hp' => $request->hp,
                'id_jurusan' => $request->jurusan,
                'id_tingkat' => $request->tingkat,
                'id_kelompok' => $request->kelompok,
            ]);
            if ($update) {
                return redirect()->back()->with('update', 'success');
            } else {
                return redirect()->back()->with('update', 'failed');
            }
        }
    }

    public function delete($id)
    {
        $hapus = DB::table('tenagakerja')
            ->where('id', $id)
            ->delete();

        if ($hapus) {
            return redirect()->back()->with('delete', 'success');
        } else {
            return redirect()->back()->with('delete', 'failed');
        }
    }
}
