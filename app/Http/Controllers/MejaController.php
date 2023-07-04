<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\meja;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MejaController extends Controller
{
    //show post data
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nomor_meja' => 'required',
                'status'     => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
            }
        $simpan = meja::create([
            'nomor_meja' => $request->nomor_meja,
            'status' => $request->status
            ]);
        if($simpan)
        {
        return Response()->json(['status' => 1]);
        }
        else
        {
        return Response()->json(['status' => 0]);
        }
    }


    //show tampil data
    public function show()
    {
        return meja::all();
    }


    //show detail data
    public function detail($id)
    {
        if(meja::where('id_meja', $id)->exists()) {
        $data = DB::table('meja')->where('meja.id_meja', '=', $id)->get();
        return Response()->json($data);
        }
        else {
        return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }


    //show update data
    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nomor_meja' => 'required',
            'status' => 'required'
        ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah =  meja::where('id_meja', $id)->update([
            'nomor_meja' => $request->nomor_meja,
            'status' => $request->status
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }


    //show hapus data
    public function destroy($id)
    {
        $hapus = meja::where('id_meja', $id)->delete();
        if($hapus) {
        return Response()->json(['status' => 1]);
        }
        else {
        return Response()->json(['status' => 0]);
        }
    }


    //  //filtering
    // public function get(Request $request){
    //     $get=meja::when($request->search, function ($query, $search) {
    //             return $query->where('status', 'like', "%{$search}%");
    //         })
    //         ->get();
    //     return response()->json($get);
    // }

}
