<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Risiko;
use Auth;
use Illuminate\Support\Facades\Validator;

class RisikoController extends Controller
{
    public function index()
    {
        return view('backend.risiko.index');
    }

    public function data()
    {

        $data = DB::table('risikos');

        if(Auth::user()->role == 'Admin'){
            $data = $data->get();
        }else{
            $data = $data->where('id_user', Auth::user()->id)->get();
        }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'proses_bisnis' => 'required',
            'identifikasi_risiko' => 'required',
            'pengelola_risiko' => 'required',
            'kategori_risiko' => 'required',
            'uraian' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Risiko::create([
                'proses_bisnis' => $request->proses_bisnis,
                'identifikasi_risiko' => $request->identifikasi_risiko,
                'pengelola_risiko' => $request->pengelola_risiko,
                'kategori_risiko' => $request->kategori_risiko,
                'uraian' => $request->uraian,
                'id_user' => Auth::id()
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $data = Risiko::find($request->id);
            $data = $data->update([
                'proses_bisnis' => $request->proses_bisnis,
                'identifikasi_risiko' => $request->identifikasi_risiko,
                'pengelola_risiko' => $request->pengelola_risiko,
                'kategori_risiko' => $request->kategori_risiko,
                'uraian' => $request->uraian,
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Risiko::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
