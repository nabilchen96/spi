<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\NilaiEfektivitas;
use Auth;
use Illuminate\Support\Facades\Validator;

class NilaiEfektivitasController extends Controller
{
    public function index()
    {
        return view('backend.nilai_efektivitas.index');
    }

    public function data()
    {

        $data = DB::table('nilai_efektivitas as ne')
                ->join('profil_risikos as pr', 'pr.id', '=', 'ne.id_profil_risiko')
                ->join('risikos as r', 'r.id', '=', 'pr.id_risiko')
                ->select(
                    'ne.*', 
                    'pr.penyebab', 
                    'pr.dampak',
                    'r.identifikasi_risiko'
                );

                if(Auth::user()->role == 'Admin'){
                    $data = $data->get();
                }else{
                    $data = $data->where('ne.id_user', Auth::user()->id)->get();
                }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nilai_a' => 'required',
            'nilai_b' => 'required',
            'nilai_c' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = NilaiEfektivitas::UpdateOrcreate(
                [
                    'id_profil_risiko'  => $request->id_profil_risiko, 
                ],
                [
                    'id_profil_risiko'  => $request->id_profil_risiko, 
                    'nilai_a'   => $request->nilai_a,
                    'nilai_b'   => $request->nilai_b,
                    'nilai_c'   => $request->nilai_c, 
                    'jumlah'    => $request->nilai_a + $request->nilai_b + $request->nilai_c,
                    'id_user'   => Auth::id()
                ]
            );

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

            $data = NilaiEfektivitas::find($request->id);
            $data = $data->update([
                'id_profil_risiko'  => $request->id_profil_risiko, 
                'nilai_a'   => $request->nilai_a,
                'nilai_b'   => $request->nilai_b,
                'nilai_c'   => $request->nilai_c, 
                'jumlah'    => $request->nilai_a + $request->nilai_b + $request->nilai_c
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request){

        $data = NilaiEfektivitas::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
