<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Matrik;
use Auth;
use Illuminate\Support\Facades\Validator;

class MatrikController extends Controller
{
    public function index()
    {
        return view('backend.matrik.index');
    }

    public function data()
    {

        $data = DB::table('matriks')->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tingkat_dampak' => 'required',
            'tingkat_frekuensi' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Matrik::UpdateOrcreate(
                [
                    'tingkat_dampak' => $request->tingkat_dampak, 
                    'tingkat_frekuensi' => $request->tingkat_frekuensi, 
                ],
                [
                    'tingkat_dampak' => $request->tingkat_dampak, 
                    'tingkat_frekuensi' => $request->tingkat_frekuensi, 
                    'nilai_matrik' => $request->nilai_matrik, 
                    'level_risiko' => '-'
                ]
            );

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request){

        $data = Matrik::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
