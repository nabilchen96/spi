<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Http\Request;
use DB;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Facades\Validator;

class BerkasReviewController extends Controller
{
    public function index()
    {
        return view('backend.berkas_review.index');
    }

    public function data()
    {

        $data = DB::table('berkas')
            ->whereIn('status', ['Tahap Review']);

            if(Auth::user()->role == 'Admin'){
                $data = $data->get();
            }else{
                $data = $data->where('id_user', Auth::id())->get();
            }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        //UPLOAD BERKAS
        if ($request->file_berkas) {
            $file_berkas = $request->file_berkas;
            $nama_file_berkas = '1' . date('YmdHis.') . $file_berkas->extension();
            $file_berkas->move('file_berkas', $nama_file_berkas);
        }

        $data = Berkas::create([
            'nama_berkas' => $request->nama_berkas,
            'file_berkas' => $nama_file_berkas ?? 0,
            'status' => 'Belum Proses',
            'keterangan' => '',
            'id_user' => Auth::id()

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
            if ($request->file_berkas) {
                $file_berkas = $request->file_berkas;
                $nama_file_berkas = '1' . date('YmdHis.') . $file_berkas->extension();
                $file_berkas->move('file_berkas', $nama_file_berkas);
            }

            $data = Berkas::find($request->id);
            $data = $data->update([
                'nama_berkas' => $request->nama_berkas,
                'file_berkas' => $nama_file_berkas ?? 0,
                'status' => 'Belum Proses',
                'keterangan' => '',
                'id_user' => Auth::id()
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

        $data = Berkas::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function response(Request $request)
    {

        $data = Berkas::find($request->id);
        $data = $data->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Ditambah'
        ];

        return response()->json($data);
    }
}
