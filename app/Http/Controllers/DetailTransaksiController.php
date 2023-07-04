<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detail_transaksi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    public function show()
    {

        return detail_transaksi::all();
    }

    public function detail($id)
    {
    if(detail_transaksi::where('id_detail_transaksi', $id)->exists()) {
    $data = DB::table('detail_transaksi')
           ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
           ->join('menu', 'detail_transaksi.id_menu', '=', 'menu.id_menu')
           ->select('detail_transaksi.id_detail_transaksi', 'transaksi.id_transaksi', 'menu.id_menu', 'detail_transaksi.qty', 'detail_transaksi.subtotal')
           ->where('detail_transaksi.id_detail_transaksi', '=', $id)
           ->get();
    return Response()->json($data);
   }
    else {
     return Response()->json(['message' => 'Tidak ditemukan' ]);

    }
}

    //show post data
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                
            'id_transaksi' => 'required',
            'id_menu' => 'required',
            'qty' => 'required',
            'subtotal' => 'required'
                
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = detail_transaksi::create([
            'id_transaksi' => $request->id_transaksi,
            'id_menu' => $request-> id_menu,
            'qty' => $request-> qty,
            'subtotal' => $request-> subtotal
            
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

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [   
            'id_transaksi' => 'required',
            'id_menu' => 'required',
            'qty' => 'required',
            'subtotal' => 'required'
        ]);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $id_menu = $request->id_menu;
        $qty = $request->qty;
        $harga = DB::table('menu')->where('id_menu', $id_menu)->value('harga');
        $subtotal= $harga * $qty;
        
        $ubah = detail_transaksi::where('id_detail_transaksi', $id)->update([
            'id_transaksi' => $request->id_transaksi,
            'id_menu' => $id_menu,
            'qty' => $qty,
            'subtotal' => $subtotal
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }else{
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy($id)
    {
        $hapus = detail_transaksi::where('id_detail_transaksi', $id)->delete();
        if($hapus) {
        return Response()->json(['status' => 1]);
        }
        else {
        return Response()->json(['status' => 0]);
        }
    }

    //filtering
    public function get(Request $request){
        $get=detail_transaksi::when($request->search, function ($query, $search) {
                return $query->where('qty', 'like', "%{$search}%");
            })
            ->get();
        return response()->json($get);
    }
}
