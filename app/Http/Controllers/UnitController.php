<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        return view('backend.unit.index');
    }

    public function data()
    {

        $data = DB::table('units')->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'unit' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Unit::create([
                'unit' => $request->unit,
                'keterangan' => $request->keterangan,
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

            $data = Unit::find($request->id);
            $data = $data->update([
                'unit' => $request->unit,
                'keterangan' => $request->keterangan,
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request){

        $data = Unit::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
