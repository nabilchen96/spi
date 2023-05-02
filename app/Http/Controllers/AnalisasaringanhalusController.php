<?php

namespace App\Http\Controllers;

use App\Models\AnalisaSaringanHalus;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnalisasaringanhalusController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'Admin') {
            $baru = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '0')->get();
            $verif = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '1')->get();
            $tolak = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '2')->get();
        } else if (Auth::user()->role == 'Pengguna') {
            $baru = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '0')->where('user_id', Auth::user()->id)->get();
            $verif = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '1')->where('user_id', Auth::user()->id)->get();
            $tolak = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '2')->where('user_id', Auth::user()->id)->get();
        } else if (Auth::user()->role == 'Verifikator') {
            $baru = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '0')->get();
            $verif = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '1')->where('user_verifikator_id', Auth::user()->id)->get();
            $tolak = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '2')->where('user_verifikator_id', Auth::user()->id)->get();
        }

        if (Auth::user()->role != 'Verifikator') {
            return view('backend.analisahalus.index', [
                'baru' => $baru->count(),
                'verif' => $verif->count(),
                'tolak' => $tolak->count(),
            ]);
        } else {
            return view('backend.verifikator.analisahalus.index', [
                'baru' => $baru->count(),
                'verif' => $verif->count(),
                'tolak' => $tolak->count(),
            ]);
        }
    }

    public function data()
    {

        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Verifikator') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '0');
        } else if (Auth::user()->role == 'Pengguna') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '0')->where('user_id', Auth::user()->id);
        }

        $beratisi = $beratisi->get();

        return response()->json(['data' => $beratisi]);
    }

    public function dataacc()
    {

        if (Auth::user()->role == 'Admin') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '1');
        } else if (Auth::user()->role == 'Pengguna') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '1')->where('user_id', Auth::user()->id);
        } else if (Auth::user()->role == 'Verifikator') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '1')->where('user_verifikator_id', Auth::user()->id);
        }

        $beratisi = $beratisi->get();

        return response()->json(['data' => $beratisi]);
    }

    public function datatolak()
    {

        if (Auth::user()->role == 'Admin') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '2');
        } else if (Auth::user()->role == 'Pengguna') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '2')->where('user_id', Auth::user()->id);
        } else if (Auth::user()->role == 'Verifikator') {
            $beratisi = DB::table('analisa_saringan_haluses')->where('status_verifikasi', '2')->where('user_verifikator_id', Auth::user()->id);
        }

        $beratisi = $beratisi->get();

        return response()->json(['data' => $beratisi]);
    }

    public function kode_uji()
    {
        $datas =  DB::select("SELECT MAX(RIGHT(kode_uji, 4)) as lastid FROM analisa_saringan_haluses");
        $rep = "";

        if ($datas) {
            foreach ($datas as $k) {
                $tmp = ((int)$k->lastid) + 1;
                $rep = sprintf("%04s", $tmp);
            }
        } else {

            $rep = "0001";
        }

        return $rep;
    }

    public function hitung(Request $request)
    {
        $inputan = array(
            'inputa_1' => $request->inputa_1,
            'inputa_2' => $request->inputa_2,
            'inputa_3' => $request->inputa_3,
            'inputa_4' => $request->inputa_4,
            'inputa_5' => $request->inputa_5,
            'inputa_6' => $request->inputa_6,
            'sisa_inputa' => $request->sisa_inputa
        );

        $jumlah_input_a = $inputan['inputa_1'] + $inputan['inputa_2'] + $inputan['inputa_3'] + $inputan['inputa_4'] + $inputan['inputa_5'] + $inputan['inputa_6'] + $inputan['sisa_inputa'];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputan_1'   => 'required',
            'inputan_2'      => 'required',
            'lampiran_bahan_uji' => 'required|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        } else {

            // inputa_1 dst itu diinput
            // berat_tinggal_inputa_1 dst itu dihitung
            $inputan = array(
                'inputan_1' => $request->inputan_1,
                'inputan_2' => $request->inputan_2,
                'inputan_3' => $request->inputan_3,
                'inputan_4' => $request->inputan_4,
                'inputan_5' => $request->inputan_5,
                'inputan_6' => $request->inputan_6
            );

            $inputan2 = array(
                'inputa_1' => $request->inputa_1,
                'inputa_2' => $request->inputa_2,
                'inputa_3' => $request->inputa_3,
                'inputa_4' => $request->inputa_4,
                'inputa_5' => $request->inputa_5,
                'inputa_6' => $request->inputa_6,
                'sisa_inputa' => $request->sisa_inputa
            );

            $jumlah_input_a = $inputan2['inputa_1'] + $inputan2['inputa_2'] + $inputan2['inputa_3'] + $inputan2['inputa_4'] + $inputan2['inputa_5'] + $inputan2['inputa_6'] + $inputan2['sisa_inputa'];

            $hitung_tertinggal = array(
                'berat_tinggal_inputa_1' => round($inputan2['inputa_1'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_2' => round($inputan2['inputa_2'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_3' => round($inputan2['inputa_3'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_4' => round($inputan2['inputa_4'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_5' => round($inputan2['inputa_5'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_6' => round($inputan2['inputa_6'] / $jumlah_input_a * 100, 3),
                'sisa_berat_tinggal_inputa' => round($inputan2['sisa_inputa'] / $jumlah_input_a * 100, 3),
            );

            $jumlah_berat_tinggal_inputa = round($hitung_tertinggal['berat_tinggal_inputa_1'] + $hitung_tertinggal['berat_tinggal_inputa_2'] + $hitung_tertinggal['berat_tinggal_inputa_3'] + $hitung_tertinggal['berat_tinggal_inputa_4'] + $hitung_tertinggal['berat_tinggal_inputa_5'] + $hitung_tertinggal['berat_tinggal_inputa_6'] + $hitung_tertinggal['sisa_berat_tinggal_inputa'], 2);

            $berat_kumu_1 = round($hitung_tertinggal['berat_tinggal_inputa_1'], 3);
            $berat_kumu_2 = round($berat_kumu_1 + $hitung_tertinggal['berat_tinggal_inputa_2'], 3);
            $berat_kumu_3 = round($berat_kumu_2 + $hitung_tertinggal['berat_tinggal_inputa_3'], 3);
            $berat_kumu_4 = round($berat_kumu_3 + $hitung_tertinggal['berat_tinggal_inputa_4'], 3);
            $berat_kumu_5 = round($berat_kumu_4 + $hitung_tertinggal['berat_tinggal_inputa_5'], 3);
            $berat_kumu_6 = round($berat_kumu_5 + $hitung_tertinggal['berat_tinggal_inputa_6'], 3);

            $hitung_berat_kumu_inputa = array(
                'berat_kumu_inputa_1' => $berat_kumu_1,
                'berat_kumu_inputa_2' => $berat_kumu_2,
                'berat_kumu_inputa_3' => $berat_kumu_3,
                'berat_kumu_inputa_4' => $berat_kumu_4,
                'berat_kumu_inputa_5' => $berat_kumu_5,
                'berat_kumu_inputa_6' => $berat_kumu_6,

            );

            $jumlah_berat_kumu_inputa = round($berat_kumu_1 + $hitung_berat_kumu_inputa['berat_kumu_inputa_2'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_3'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_4'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_5'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_6'], 2);

            $hitung_berat_kumu_la = array(
                'berat_kumu_la_1' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_1'],
                'berat_kumu_la_2' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_2'],
                'berat_kumu_la_3' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_3'],
                'berat_kumu_la_4' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_4'],
                'berat_kumu_la_5' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_5'],
                'berat_kumu_la_6' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_6'],

            );

            $jumlah_berat_kumu_la = round($hitung_berat_kumu_la['berat_kumu_la_1'] + $hitung_berat_kumu_la['berat_kumu_la_2'] + $hitung_berat_kumu_la['berat_kumu_la_3'] + $hitung_berat_kumu_la['berat_kumu_la_4'] + $hitung_berat_kumu_la['berat_kumu_la_5'] + $hitung_berat_kumu_la['berat_kumu_la_6'], 3);

            // dd($hitung_berat_kumu_la);
            // upload file
            $pathGambar = $request->file('lampiran_bahan_uji')->store('lampiran-analisa-saringan-halus');
            $data = AnalisaSaringanHalus::create([
                'kode_uji'              => "ASH - " . $this->kode_uji(),
                'pasir_asal'            => $request->pasir_asal,
                'berat_pasir'           => $request->berat_pasir,
                'inputa_1'              => $inputan2['inputa_1'],
                'inputa_2'              => $inputan2['inputa_2'],
                'inputa_3'              => $inputan2['inputa_3'],
                'inputa_4'              => $inputan2['inputa_4'],
                'inputa_5'              => $inputan2['inputa_5'],
                'inputa_6'              => $inputan2['inputa_6'],
                'sisa_inputa'           => $inputan2['sisa_inputa'],
                'jumlah_inputa'         => $jumlah_input_a,
                'berat_tinggal_inputa_1' => $hitung_tertinggal['berat_tinggal_inputa_1'],
                'berat_tinggal_inputa_2' => $hitung_tertinggal['berat_tinggal_inputa_2'],
                'berat_tinggal_inputa_3' => $hitung_tertinggal['berat_tinggal_inputa_3'],
                'berat_tinggal_inputa_4' => $hitung_tertinggal['berat_tinggal_inputa_4'],
                'berat_tinggal_inputa_5' => $hitung_tertinggal['berat_tinggal_inputa_5'],
                'berat_tinggal_inputa_6' => $hitung_tertinggal['berat_tinggal_inputa_6'],
                'sisa_berat_tinggal_inputa' => $hitung_tertinggal['sisa_berat_tinggal_inputa'],
                'jumlah_berat_tinggal_inputa' => $jumlah_berat_tinggal_inputa,
                'berat_kumu_inputa_1'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_1'],
                'berat_kumu_inputa_2'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_2'],
                'berat_kumu_inputa_3'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_3'],
                'berat_kumu_inputa_4'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_4'],
                'berat_kumu_inputa_5'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_5'],
                'berat_kumu_inputa_6'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_6'],
                'jumlah_berat_kumu_inputa' => $jumlah_berat_kumu_inputa,
                'berat_kumu_la_1' => $hitung_berat_kumu_la['berat_kumu_la_1'],
                'berat_kumu_la_2' => $hitung_berat_kumu_la['berat_kumu_la_2'],
                'berat_kumu_la_3' => $hitung_berat_kumu_la['berat_kumu_la_3'],
                'berat_kumu_la_4' => $hitung_berat_kumu_la['berat_kumu_la_4'],
                'berat_kumu_la_5' => $hitung_berat_kumu_la['berat_kumu_la_5'],
                'berat_kumu_la_6' => $hitung_berat_kumu_la['berat_kumu_la_6'],
                'jumlah_berat_kumu_la' => $jumlah_berat_kumu_la,
                'modulus_halus' =>  $jumlah_berat_kumu_inputa / 100,
                'lampiran_bahan_uji'    =>  $pathGambar,
                'user_id'               => Auth::user()->id,
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'    => 'required',
            'lampiran_bahan_uji' => 'mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        } else {
            // inputa_1 dst itu diinput
            // berat_tinggal_inputa_1 dst itu dihitung
            $inputan = array(
                'inputan_1' => $request->inputan_1,
                'inputan_2' => $request->inputan_2,
                'inputan_3' => $request->inputan_3,
                'inputan_4' => $request->inputan_4,
                'inputan_5' => $request->inputan_5,
                'inputan_6' => $request->inputan_6
            );

            $inputan2 = array(
                'inputa_1' => $request->inputa_1,
                'inputa_2' => $request->inputa_2,
                'inputa_3' => $request->inputa_3,
                'inputa_4' => $request->inputa_4,
                'inputa_5' => $request->inputa_5,
                'inputa_6' => $request->inputa_6,
                'sisa_inputa' => $request->sisa_inputa
            );

            $jumlah_input_a = $inputan2['inputa_1'] + $inputan2['inputa_2'] + $inputan2['inputa_3'] + $inputan2['inputa_4'] + $inputan2['inputa_5'] + $inputan2['inputa_6'] + $inputan2['sisa_inputa'];

            $hitung_tertinggal = array(
                'berat_tinggal_inputa_1' => round($inputan2['inputa_1'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_2' => round($inputan2['inputa_2'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_3' => round($inputan2['inputa_3'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_4' => round($inputan2['inputa_4'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_5' => round($inputan2['inputa_5'] / $jumlah_input_a * 100, 3),
                'berat_tinggal_inputa_6' => round($inputan2['inputa_6'] / $jumlah_input_a * 100, 3),
                'sisa_berat_tinggal_inputa' => round($inputan2['sisa_inputa'] / $jumlah_input_a * 100, 3),
            );

            $jumlah_berat_tinggal_inputa = round($hitung_tertinggal['berat_tinggal_inputa_1'] + $hitung_tertinggal['berat_tinggal_inputa_2'] + $hitung_tertinggal['berat_tinggal_inputa_3'] + $hitung_tertinggal['berat_tinggal_inputa_4'] + $hitung_tertinggal['berat_tinggal_inputa_5'] + $hitung_tertinggal['berat_tinggal_inputa_6'] + $hitung_tertinggal['sisa_berat_tinggal_inputa'], 2);


            $berat_kumu_1 = round($hitung_tertinggal['berat_tinggal_inputa_1'], 3);
            $berat_kumu_2 = round($berat_kumu_1 + $hitung_tertinggal['berat_tinggal_inputa_2'], 3);
            $berat_kumu_3 = round($berat_kumu_2 + $hitung_tertinggal['berat_tinggal_inputa_3'], 3);
            $berat_kumu_4 = round($berat_kumu_3 + $hitung_tertinggal['berat_tinggal_inputa_4'], 3);
            $berat_kumu_5 = round($berat_kumu_4 + $hitung_tertinggal['berat_tinggal_inputa_5'], 3);
            $berat_kumu_6 = round($berat_kumu_5 + $hitung_tertinggal['berat_tinggal_inputa_6'], 3);

            $hitung_berat_kumu_inputa = array(
                'berat_kumu_inputa_1' => $berat_kumu_1,
                'berat_kumu_inputa_2' => $berat_kumu_2,
                'berat_kumu_inputa_3' => $berat_kumu_3,
                'berat_kumu_inputa_4' => $berat_kumu_4,
                'berat_kumu_inputa_5' => $berat_kumu_5,
                'berat_kumu_inputa_6' => $berat_kumu_6,

            );

            $jumlah_berat_kumu_inputa = round($berat_kumu_1 + $hitung_berat_kumu_inputa['berat_kumu_inputa_2'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_3'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_4'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_5'] + $hitung_berat_kumu_inputa['berat_kumu_inputa_6'], 2);

            $hitung_berat_kumu_la = array(
                'berat_kumu_la_1' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_1'],
                'berat_kumu_la_2' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_2'],
                'berat_kumu_la_3' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_3'],
                'berat_kumu_la_4' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_4'],
                'berat_kumu_la_5' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_5'],
                'berat_kumu_la_6' => 100 - $hitung_berat_kumu_inputa['berat_kumu_inputa_6'],

            );

            $jumlah_berat_kumu_la = round($hitung_berat_kumu_la['berat_kumu_la_1'] + $hitung_berat_kumu_la['berat_kumu_la_2'] + $hitung_berat_kumu_la['berat_kumu_la_3'] + $hitung_berat_kumu_la['berat_kumu_la_4'] + $hitung_berat_kumu_la['berat_kumu_la_5'] + $hitung_berat_kumu_la['berat_kumu_la_6'], 3);

            // dd($jumlah_berat_kumu_inputa/100);

            $user = AnalisaSaringanHalus::find($request->id);

            if ($request->file('lampiran_bahan_uji')) {

                // hapus file lamanya
                Storage::delete($user->lampiran_bahan_uji);

                // upload file baru
                $pathGambar = $request->file('lampiran_bahan_uji')->store('lampiran-analisa-saringan-halus');
            } else {
                // kalo tidak upload, ambil nilai lama pd field lampiran_bahan_uji
                $pathGambar = $user->lampiran_bahan_uji; //kota-images/namafile.ekstensi
            }

            $data = $user->update([
                'pasir_asal'            => $request->pasir_asal,
                'berat_pasir'           => $request->berat_pasir,
                'inputa_1'              => $inputan2['inputa_1'],
                'inputa_2'              => $inputan2['inputa_2'],
                'inputa_3'              => $inputan2['inputa_3'],
                'inputa_4'              => $inputan2['inputa_4'],
                'inputa_5'              => $inputan2['inputa_5'],
                'inputa_6'              => $inputan2['inputa_6'],
                'sisa_inputa'           => $inputan2['sisa_inputa'],
                'jumlah_inputa'         => $jumlah_input_a,
                'berat_tinggal_inputa_1' => $hitung_tertinggal['berat_tinggal_inputa_1'],
                'berat_tinggal_inputa_2' => $hitung_tertinggal['berat_tinggal_inputa_2'],
                'berat_tinggal_inputa_3' => $hitung_tertinggal['berat_tinggal_inputa_3'],
                'berat_tinggal_inputa_4' => $hitung_tertinggal['berat_tinggal_inputa_4'],
                'berat_tinggal_inputa_5' => $hitung_tertinggal['berat_tinggal_inputa_5'],
                'berat_tinggal_inputa_6' => $hitung_tertinggal['berat_tinggal_inputa_6'],
                'sisa_berat_tinggal_inputa' => $hitung_tertinggal['sisa_berat_tinggal_inputa'],
                'jumlah_berat_tinggal_inputa' => $jumlah_berat_tinggal_inputa,
                'berat_kumu_inputa_1'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_1'],
                'berat_kumu_inputa_2'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_2'],
                'berat_kumu_inputa_3'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_3'],
                'berat_kumu_inputa_4'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_4'],
                'berat_kumu_inputa_5'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_5'],
                'berat_kumu_inputa_6'   => $hitung_berat_kumu_inputa['berat_kumu_inputa_6'],
                'jumlah_berat_kumu_inputa' => $jumlah_berat_kumu_inputa,
                'berat_kumu_la_1' => $hitung_berat_kumu_la['berat_kumu_la_1'],
                'berat_kumu_la_2' => $hitung_berat_kumu_la['berat_kumu_la_2'],
                'berat_kumu_la_3' => $hitung_berat_kumu_la['berat_kumu_la_3'],
                'berat_kumu_la_4' => $hitung_berat_kumu_la['berat_kumu_la_4'],
                'berat_kumu_la_5' => $hitung_berat_kumu_la['berat_kumu_la_5'],
                'berat_kumu_la_6' => $hitung_berat_kumu_la['berat_kumu_la_6'],
                'jumlah_berat_kumu_la' => $jumlah_berat_kumu_la,
                'lampiran_bahan_uji' => $pathGambar,
                'modulus_halus' =>  $jumlah_berat_kumu_inputa / 100,
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function verifikasi(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'    => 'required',
            'status_verifikasi' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        } else {

            $user = AnalisaSaringanHalus::find($request->id);

            $data = $user->update([
                'status_verifikasi'         => $request->status_verifikasi,
                'alasan'                    => $request->alasan,
                'user_verifikator_id'       => Auth::user()->id,
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = AnalisaSaringanHalus::find($request->id);

        // hapus filenya jika ada
        if ($data->lampiran_bahan_uji) {
            // hapus filenya
            Storage::delete($data->lampiran_bahan_uji);
        }

        $data->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function cetakBerat(Request $request)
    {

        $data = AnalisaSaringanHalus::find($request->id);

        return view('backend.analisahalus.cetak', compact('data'));
    }
}
