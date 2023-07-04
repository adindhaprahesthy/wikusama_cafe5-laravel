<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\transaksi;
use App\Models\detail_transaksi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    //show post data
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'tgl_transaksi' => 'required',
                'id'       => 'required',
                'id_meja'       => 'required',
                'nama_pelanggan'=> 'required',
                'status'        => 'required'
                
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = transaksi::create([
            'tgl_transaksi' => $request->tgl_transaksi,
            'id'       => $request->id,
            'id_meja'       => $request->id_meja,
            'nama_pelanggan'=> $request->nama_pelanggan,
            'status'        => $request->status
            
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
        return transaksi::all();
    }

    

    // //show detail data
     public function detail($id)
     {
         if(transaksi::where('id_transaksi', $id)->exists()) {
         $data_transaksi = DB::table('transaksi')
             //->join('User', 'transaksi.id', '=', 'User.id')
             ->join('meja', 'transaksi.id_meja', '=', 'meja.id_meja')
             ->select('transaksi.id_transaksi', 'transaksi.tgl_transaksi', 'meja.id_meja', 'transaksi.nama_pelanggan', 'transaksi.status')
             ->where('transaksi.id_transaksi', '=', $id)
             ->get();
         return Response()->json($data_transaksi);
     }
         else {
         return Response()->json(['message' => 'Tidak ditemukan' ]);
         }
         }


    //show ubah data
    public function update($id, Request $request)  {
        $validator=Validator::make($request->all(),
        [
            'tgl_transaksi'     => 'required',
            'id'           => 'required',
            'id_meja'           => 'required',
            'nama_pelanggan'    => 'required',
            'status'            => 'required'
        ]);
       
        if($validator->fails()) {
        return Response()->json($validator->errors());
        }
       
        $ubah = transaksi::where('id_transaksi', $id)->update([
            'tgl_transaksi'    => $request->tgl_transaksi,
            'id'          => $request->id,
            'id_meja'          => $request->id_meja,
            'nama_pelanggan'   => $request->nama_pelanggan,
            'status'           => $request->status
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
       $hapus = transaksi::where('id_transaksi', $id)->delete();
       if($hapus) {
       return Response()->json(['status' => 1]);
    }
       else {
       return Response()->json(['status' => 0]);
    }
    }
    
    //filtering
    public function get(Request $request){
        $get=transaksi::when($request->search, function ($query, $search) {
                return $query->where('tgl_transaksi', 'like', "%{$search}%");
            })
            ->get();
        return response()->json($get);
    }
}