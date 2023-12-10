<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\RencanaPenanganan;
use Auth;
use Illuminate\Support\Facades\Validator;

class RencanaPenangananController extends Controller
{
    public function index()
    {
        return view('backend.rencana_penanganan.index');
    }

    public function data()
    {

        $data = DB::table('rencana_penanganans as rp')
            ->join('profil_risikos as pr', 'pr.id', '=', 'rp.id_profil_risiko')
            ->join('risikos as r', 'r.id', '=', 'pr.id_risiko')
            ->select(
                'r.identifikasi_risiko',
                'pr.sistem_pengendalian',
                'rp.*'
            );

            if(Auth::user()->role == 'Admin'){
                $data = $data->get();
            }else{
                $data = $data->where('r.id_user', Auth::id())->get();
            }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {


        $data = RencanaPenanganan::UpdateOrcreate(
            [
                'id_profil_risiko' => $request->id_profil_risiko
            ],
            [
                'id_profil_risiko' => $request->id_profil_risiko,
                'opsi_penanganan' => $request->opsi_penanganan,
                'penanganan_lain' => $request->penanganan_lain,
                'jumlah_kegiatan' => $request->jumlah_kegiatan,
                'jadwal' => $request->jadwal,
                'level_kemungkinan' => $request->level_kemungkinan,
                'level_dampak' => $request->level_dampak,
                'nilai_risiko' => $request->level_kemungkinan + $request->level_dampak,
                'id_user'   => Auth::id()
            ]
        );

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Ditambah'
        ];


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

            $data = RencanaPenanganan::find($request->id);
            $data = $data->update([
                'id_profil_risiko' => $request->id_profil_risiko,
                'opsi_penanganan' => $request->opsi_penanganan,
                'penanganan_lain' => $request->penanganan_lain,
                'jumlah_kegiatan' => $request->jumlah_kegiatan,
                'jadwal' => $request->jadwal,
                'level_kemungkinan' => $request->level_kemungkinan,
                'level_dampak' => $request->level_dampak,
                'nilai_risiko' => $request->level_kemungkinan + $request->level_dampak
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

        $data = RencanaPenanganan::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
