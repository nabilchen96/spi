<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Kemungkinan;
use Auth;
use Illuminate\Support\Facades\Validator;

class KemungkinanController extends Controller
{
    public function index()
    {
        return view('backend.kemungkinan.index');
    }

    public function data()
    {

        $data = DB::table('kemungkinans as k')
            ->leftjoin('profil_risikos as pr', 'pr.id', '=', 'k.id_profil_risiko')
            ->leftjoin('risikos as r', 'r.id', '=', 'pr.id_risiko')
            ->select(
                'r.identifikasi_risiko',
                'k.*'
            )
            ->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_profil_risiko' => 'required',
            'jumlah_kemungkinan' => 'required',
            'total_aktivitas' => 'required',
            'frekuensi' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            //RUMUS PERSENTASE
            $persen = 0;

            if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.05) {
                $persen = 1;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.1) {
                $persen = 2;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.2) {
                $persen = 3;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.5) {
                $persen = 4;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 1) {
                $persen = 5;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) === "") {
                $persen = 0;
            }

            //RUMUS FREKUENSI
            $frekuensi = 0;

            if ($request->frekuensi <= 0) {
                $frekuensi = 0;
            } else if ($request->frekuensi == "< 2 kali dalam 1 tahun") {
                $frekuensi = 1;
            } else if ($request->frekuensi == "2 sd 5 kali dalam 1 tahun") {
                $frekuensi = 2;
            } else if ($request->frekuensi == "6 sd 9 kali dalam 1 tahun") {
                $frekuensi = 3;
            } else if ($request->frekuensi == "10 sd 12 kali dalam 1 tahun") {
                $frekuensi = 4;
            } else if ($request->frekuensi == "Lebih dari 12 kali dalam 1 tahun") {
                $frekuensi = 5;
            } else {
                $frekuensi = 0;
            }

            //RUMUS TOLERANSI
            $toleransi = 0;

            if ($request->kejadian <= 0) {
                $toleransi = 0;
            } else if ($request->kejadian == "1 kejadian dalam 1 tahun terakhir") {
                $toleransi = 5;
            } else if ($request->kejadian == "1 kejadian dalam 2 tahun terakhir") {
                $toleransi = 4;
            } else if ($request->kejadian == "1 kejadian dalam 3 tahun terakhir") {
                $toleransi = 3;
            } else if ($request->kejadian == "1 kejadian dalam 4 tahun terakhir") {
                $toleransi = 2;
            } else if ($request->kejadian == "1 kejadian dalam 5 tahun terakhir") {
                $toleransi = 1;
            }

            $data = Kemungkinan::UpdateOrcreate(
                [
                    'id_profil_risiko' => $request->id_profil_risiko
                ],
                [
                    'id_profil_risiko' => $request->id_profil_risiko,
                    'jumlah_kemungkinan' => $request->jumlah_kemungkinan,
                    'total_aktivitas' => $request->total_aktivitas,
                    'frekuensi' => $request->frekuensi,
                    'kejadian' => $request->kejadian, 
                    'level_kemungkinan' => $persen + $frekuensi + $toleransi
                ]
            );

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

            //RUMUS PERSENTASE
            $persen = 0;

            if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.05) {
                $persen = 1;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.1) {
                $persen = 2;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.2) {
                $persen = 3;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 0.5) {
                $persen = 4;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) <= 1) {
                $persen = 5;
            } else if (($request->jumlah_kemungkinan / $request->total_aktivitas) === "") {
                $persen = 0;
            }

            //RUMUS FREKUENSI
            $frekuensi = 0;

            if ($request->frekuensi == "< 2 kali dalam 1 tahun") {
                $frekuensi = 1;
            } else if ($request->frekuensi == "2 sd 5 kali dalam 1 tahun") {
                $frekuensi = 2;
            } else if ($request->frekuensi == "6 sd 9 kali dalam 1 tahun") {
                $frekuensi = 3;
            } else if ($request->frekuensi == "10 sd 12 kali dalam 1 tahun") {
                $frekuensi = 4;
            } else if ($request->frekuensi == "Lebih dari 12 kali dalam 1 tahun") {
                $frekuensi = 5;
            }

            //RUMUS TOLERANSI
            $toleransi = 0;

            if ($request->kejadian <= 0) {
                $toleransi = 0;
            } else if ($request->kejadian == "1 kejadian dalam 1 tahun terakhir") {
                $toleransi = 5;
            } else if ($request->kejadian == "1 kejadian dalam 2 tahun terakhir") {
                $toleransi = 4;
            } else if ($request->kejadian == "1 kejadian dalam 3 tahun terakhir") {
                $toleransi = 3;
            } else if ($request->kejadian == "1 kejadian dalam 4 tahun terakhir") {
                $toleransi = 2;
            } else if ($request->kejadian == "1 kejadian dalam 5 tahun terakhir") {
                $toleransi = 1;
            }

            // dd($frekuensi);

            $data = Kemungkinan::find($request->id);
            $data = $data->update([
                'id_profil_risiko' => $request->id_profil_risiko,
                'jumlah_kemungkinan' => $request->jumlah_kemungkinan,
                'total_aktivitas' => $request->total_aktivitas,
                'frekuensi' => $request->frekuensi,
                'kejadian' => $request->kejadian, 
                'level_kemungkinan' => $persen + $frekuensi + $toleransi
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

        $data = Kemungkinan::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
