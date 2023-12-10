<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class NilaiRisikoController extends Controller
{
    public function index()
    {
        return view('backend.nilai_risiko.index');
    }

    public function data()
    {

        $data = DB::table('profil_risikos as pr')
            ->join('risikos as r', 'r.id', '=', 'pr.id_risiko')
            ->join('nilai_efektivitas as ne', 'ne.id_profil_risiko', '=', 'pr.id')
            ->join('dampaks as d', 'd.id_profil_risiko', '=', 'pr.id')
            ->join('kemungkinans as k', 'k.id_profil_risiko', '=', 'pr.id')
            ->leftJoin('matriks', function ($join) {
                $join->on('matriks.tingkat_frekuensi', '=', 'k.level_kemungkinan')
                    ->on('matriks.tingkat_dampak', '=', 'd.kriteria_dampak');
            })
            ->select(
                'pr.*',
                'r.identifikasi_risiko',
                'ne.jumlah',
                'k.level_kemungkinan',
                'd.kriteria_dampak',
                'r.kategori_risiko'
                // DB::raw('COALESCE(matriks.nilai_matrik, (SELECT nilai_matrik FROM matriks WHERE id = 1)) AS nilai_matrik') // Ganti '1' dengan id yang sesuai
            );

            if(Auth::user()->role == 'Admin'){
                $data = $data->get();
            }else{
                $data = $data->where('r.id_user', Auth::id())->get();
            }

        $matrik = DB::table('matriks')->get();

        return response()->json(['data' => $data]);
    }
}
