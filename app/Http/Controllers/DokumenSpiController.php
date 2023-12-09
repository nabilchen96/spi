<?php

namespace App\Http\Controllers;

use App\Models\DokumenSpi;
use Illuminate\Http\Request;
use DB;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Facades\Validator;

class DokumenSpiController extends Controller
{
    public function index()
    {
        return view('backend.dokumen_spi.index');
    }

    public function data()
    {

        $data = DB::table('dokumen_spis')->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        //UPLOAD BERKAS
        if ($request->dokumen_spi) {
            $dokumen_spi = $request->dokumen_spi;
            $nama_dokumen_spi = '1' . date('YmdHis.') . $dokumen_spi->extension();
            $dokumen_spi->move('dokumen_spi', $nama_dokumen_spi);
        }

        $data = DokumenSpi::create([
            'nama_dokumen' => $request->nama_dokumen,
            'file_dokumen' => $nama_dokumen_spi ?? 0,
            'status' => $request->status,
            'keterangan' => $request->keterangan,

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

            //UPLOAD BERKAS
            if ($request->dokumen_spi) {
                $dokumen_spi = $request->dokumen_spi;
                $nama_dokumen_spi = '1' . date('YmdHis.') . $dokumen_spi->extension();
                $dokumen_spi->move('dokumen_spi', $nama_dokumen_spi);
            }

            $data = DokumenSpi::find($request->id);
            $data = $data->update([
                'nama_dokumen' => $request->nama_dokumen,
                'file_dokumen' => $nama_dokumen_spi ?? 0,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
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

        $data = DokumenSpi::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
