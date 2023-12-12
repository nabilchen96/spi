<?php

namespace App\Http\Controllers;

use App\Models\Dampak;
use Illuminate\Http\Request;
use DB;
use App\Models\Jadwal;
use Auth;
use Illuminate\Support\Facades\Validator;

class DampakController extends Controller
{
    public function index()
    {
        return view('backend.dampak.index');
    }

    public function data()
    {

        $data = DB::table('dampaks as k')
            ->leftjoin('profil_risikos as pr', 'pr.id', '=', 'k.id_profil_risiko')
            ->leftjoin('risikos as r', 'r.id', '=', 'pr.id_risiko')
            ->select(
                'r.identifikasi_risiko',
                'k.*'
            );

            if(Auth::user()->role == 'Admin'){
                $data = $data->get();
            }else{
                $data = $data->where('k.id_user', Auth::id())->get();
            }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $bn = 0;
        if ($request->beban_keuangan_negara === "Tidak Signifikan") {
            $bn = 1;
        } else if ($request->beban_keuangan_negara === "Minor") {
            $bn = 2;
        } else if ($request->beban_keuangan_negara === "Moderat") {
            $bn = 3;
        } else if ($request->beban_keuangan_negara === "Signifikan") {
            $bn = 4;
        } else if ($request->beban_keuangan_negara === "Sangat Signifikan") {
            $bn = 5;
        }

        $pr = 0;
        if ($request->penurunan_reputasi === "Tidak Signifikan") {
            $pr = 1;
        } else if ($request->penurunan_reputasi === "Minor") {
            $pr = 2;
        } else if ($request->penurunan_reputasi === "Moderat") {
            $pr = 3;
        } else if ($request->penurunan_reputasi === "Signifikan") {
            $pr = 4;
        } else if ($request->penurunan_reputasi === "Sangat Signifikan") {
            $pr = 5;
        }

        $dh = 0;
        if ($request->dampak_hukum === "Tidak Signifikan") {
            $dh = 1;
        } else if ($request->dampak_hukum === "Minor") {
            $dh = 2;
        } else if ($request->dampak_hukum === "Moderat") {
            $dh = 3;
        } else if ($request->dampak_hukum === "Signifikan") {
            $dh = 4;
        } else if ($request->dampak_hukum === "Sangat Signifikan") {
            $dh = 5;
        }

        $sk = 0;
        if ($request->sasaran_kinerja === "Tidak Signifikan") {
            $sk = 1;
        } else if ($request->sasaran_kinerja === "Minor") {
            $sk = 2;
        } else if ($request->sasaran_kinerja === "Moderat") {
            $sk = 3;
        } else if ($request->sasaran_kinerja === "Signifikan") {
            $sk = 4;
        } else if ($request->sasaran_kinerja === "Sangat Signifikan") {
            $sk = 5;
        }

        $kt = 0;
        if ($request->keselamatan_transportasi === "Tidak Signifikan") {
            $kt = 1;
        } else if ($request->keselamatan_transportasi === "Minor") {
            $kt = 2;
        } else if ($request->keselamatan_transportasi === "Moderat") {
            $kt = 3;
        } else if ($request->keselamatan_transportasi === "Signifikan") {
            $kt = 4;
        } else if ($request->keselamatan_transportasi === "Sangat Signifikan") {
            $kt = 5;
        }

        $data = Dampak::UpdateOrcreate(
            [
                'id_profil_risiko' => $request->id_profil_risiko
            ],
            [
                'id_profil_risiko' => $request->id_profil_risiko,
                'beban_keuangan_negara' => $request->beban_keuangan_negara,
                'penurunan_reputasi' => $request->penurunan_reputasi,
                'dampak_hukum' => $request->dampak_hukum,
                'sasaran_kinerja' => $request->sasaran_kinerja,
                'keselamatan_transportasi' => $request->keselamatan_transportasi,
                'kriteria_dampak' => $bn + $pr + $dh + $sk + $kt,
                'id_user'   => Auth::id()
            ]);

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

            $bn = 0;
            if ($request->beban_keuangan_negara === "Tidak Signifikan") {
                $bn = 1;
            } else if ($request->beban_keuangan_negara === "Minor") {
                $bn = 2;
            } else if ($request->beban_keuangan_negara === "Moderat") {
                $bn = 3;
            } else if ($request->beban_keuangan_negara === "Signifikan") {
                $bn = 4;
            } else if ($request->beban_keuangan_negara === "Sangat Signifikan") {
                $bn = 5;
            }

            $pr = 0;
            if ($request->penurunan_reputasi === "Tidak Signifikan") {
                $pr = 1;
            } else if ($request->penurunan_reputasi === "Minor") {
                $pr = 2;
            } else if ($request->penurunan_reputasi === "Moderat") {
                $pr = 3;
            } else if ($request->penurunan_reputasi === "Signifikan") {
                $pr = 4;
            } else if ($request->penurunan_reputasi === "Sangat Signifikan") {
                $pr = 5;
            }

            $dh = 0;
            if ($request->dampak_hukum === "Tidak Signifikan") {
                $dh = 1;
            } else if ($request->dampak_hukum === "Minor") {
                $dh = 2;
            } else if ($request->dampak_hukum === "Moderat") {
                $dh = 3;
            } else if ($request->dampak_hukum === "Signifikan") {
                $dh = 4;
            } else if ($request->dampak_hukum === "Sangat Signifikan") {
                $dh = 5;
            }

            $sk = 0;
            if ($request->sasaran_kinerja === "Tidak Signifikan") {
                $sk = 1;
            } else if ($request->sasaran_kinerja === "Minor") {
                $sk = 2;
            } else if ($request->sasaran_kinerja === "Moderat") {
                $sk = 3;
            } else if ($request->sasaran_kinerja === "Signifikan") {
                $sk = 4;
            } else if ($request->sasaran_kinerja === "Sangat Signifikan") {
                $sk = 5;
            }

            $kt = 0;
            if ($request->keselamatan_transportasi === "Tidak Signifikan") {
                $kt = 1;
            } else if ($request->keselamatan_transportasi === "Minor") {
                $kt = 2;
            } else if ($request->keselamatan_transportasi === "Moderat") {
                $kt = 3;
            } else if ($request->keselamatan_transportasi === "Signifikan") {
                $kt = 4;
            } else if ($request->keselamatan_transportasi === "Sangat Signifikan") {
                $kt = 5;
            }

            $data = Dampak::find($request->id);
            $data = $data->update([
                'id_profil_risiko' => $request->id_profil_risiko,
                'beban_keuangan_negara' => $request->beban_keuangan_negara,
                'penurunan_reputasi' => $request->penurunan_reputasi,
                'dampak_hukum' => $request->dampak_hukum,
                'sasaran_kinerja' => $request->sasaran_kinerja,
                'keselamatan_transportasi' => $request->keselamatan_transportasi,
                'kriteria_dampak' => $bn + $pr + $dh + $sk + $kt
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

        $data = Dampak::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
