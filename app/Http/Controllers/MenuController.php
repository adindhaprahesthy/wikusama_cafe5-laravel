<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    
    //show post data
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_menu' => 'required',
                'jenis'     => 'required',
                'deskripsi' => 'required',
                'gambar'    => 'required',
                'harga'     => 'required'
                
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = menu::create([
            'nama_menu' => $request->nama_menu,
            'jenis'     => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $request->gambar,
            'harga'     => $request->harga
            
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
        return menu::all();
    }

    
    //show detail data
    public function detail($id)
    {
    if(menu::where('id_menu', $id)->exists()) {
    $data = DB::table('menu')->where('menu.id_menu', '=', $id)->get();
    return Response()->json($data);
    }
    else {
        return Response()->json(['message' => 'Tidak ditemukan' ]);
    }
    }
    
    
    //show ubah data
    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nama_menu' => 'required',
            'jenis'     => 'required',
            'deskripsi' => 'required',
            'gambar'    => 'required',
            'harga'     => 'required'
        ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = menu::where('id_menu', $id)->update([
            'nama_menu' => $request->nama_menu,
            'jenis'     => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $request->gambar,
            'harga'     => $request->harga
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
        $hapus = menu::where('id_menu', $id)->delete();
        if($hapus) {
        return Response()->json(['status' => 1]);
        }
        else {
        return Response()->json(['status' => 0]);
        }
    }


    //filtering
    public function get(Request $request){
        $get=menu::when($request->search, function ($query, $search) {
                return $query->where('jenis', 'like', "%{$search}%")
                ->orWhere('harga', 'like', "%{$search}%");
            })
            ->get();
        return response()->json($get);
    }

}
