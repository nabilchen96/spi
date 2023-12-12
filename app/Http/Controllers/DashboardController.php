<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {

        //TOTAL USER
        $user = DB::table('users')->count();

        //TOTAL UNIT
        $unit = DB::table('units')->count();

        //TOTAL RISIKO
        $risiko = DB::table('risikos')->count();
        
        //TOTAL RENCANA PENANGANAN
        $rp = DB::table('rencana_penanganans')->count();

        //BERKAS BELUM PROSES
        $audit = DB::table('berkas')->where('status', 'Belum Proses')->count();

        //BERKAS SEDANG REVIEW
        $review = DB::table('berkas')->where('status', 'Tahap Review')->count();

        //BERKAS EVALUASI
        $evaluasi = DB::table('berkas')->where('status', 'Sudah Direview')->count();

        //BERKAS DITOLAK
        $ditolak = DB::table('berkas')->where('status', 'Berkas Ditolak')->count();

        //DOKUMEN SPI
        $dokumen = DB::table('dokumen_spis')->where('status', 'Publik')->get();
        
        return view('backend.dashboard', [
            'user' => $user, 
            'unit' => $unit, 
            'risiko' => $risiko, 
            'rp' => $rp,
            'audit' => $audit, 
            'review' => $review, 
            'evaluasi' => $evaluasi, 
            'dokumen' => $dokumen,
            'ditolak'   => $ditolak
        ]);
    }
}