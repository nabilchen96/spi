<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Http\Request;
use DB;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Facades\Validator;

class BerkasEvaluasiController extends Controller
{
    public function index()
    {
        return view('backend.berkas_evaluasi.index');
    }

    public function data()
    {

        $data = DB::table('berkas')
            ->whereIn('status', ['Sudah Direview']);

            if(Auth::user()->role == 'Admin'){
                $data = $data->get();
            }else{
                $data = $data->where('id_user', Auth::id())->get();
            }

        return response()->json(['data' => $data]);
    }
}
