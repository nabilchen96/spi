<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\ProfilRisiko;
use Auth;
use Illuminate\Support\Facades\Validator;

class ProfilRisikoController extends Controller
{
    public function index()
    {
        return view('backend.profil_risiko.index');
    }

    public function data()
    {

        $data = DB::table('profil_risikos as pr')
                ->join('risikos as r', 'r.id', '=', 'pr.id_risiko')
                ->select(
                    'pr.*', 
                    'r.identifikasi_risiko', 
                    'r.kategori_risiko'
                )
                ->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'penyebab' => 'required',
            'dampak' => 'required',
            'sistem_pengendalian' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = ProfilRisiko::create([
                'id_risiko' => $request->id_risiko,
                'penyebab' => $request->penyebab,
                'dampak' => $request->dampak,
                'sistem_pengendalian' => $request->sistem_pengendalian
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

            $data = ProfilRisiko::find($request->id);
            $data = $data->update([
                'id_risiko' => $request->id_risiko,
                'penyebab' => $request->penyebab,
                'dampak' => $request->dampak,
                'sistem_pengendalian' => $request->sistem_pengendalian
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request){

        $data = ProfilRisiko::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
