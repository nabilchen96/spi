<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Jadwal;
use Auth;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index()
    {
        return view('backend.jadwal.index');
    }

    public function data()
    {

        $data = DB::table('jadwals')->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tahun' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Jadwal::create([
                'tahun' => $request->tahun,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai, 
                'status' => $request->status
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'id'    => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        }else{

            $data = Jadwal::find($request->id);
            $data = $data->update([
                'tahun' => $request->tahun,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai, 
                'status' => $request->status
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request){

        $data = Jadwal::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
