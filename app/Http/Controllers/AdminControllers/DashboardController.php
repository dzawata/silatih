<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {

        $result['judul'] = 'Dashboard';
        
        $result['pengguna'] = DB::table('users')->count();
        $result['pelatihan'] = DB::table('pelatihan')->count();
        $result['sample'] = DB::table('sample')->count();
        $result['rekomendasi'] = DB::table('rekomendasi')->count();
        return view('admin.dashboard')->with('result', $result);
    }

}
