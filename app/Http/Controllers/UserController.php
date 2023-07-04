<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\HomeController;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
        if(! $token = JWTAuth::attempt($credentials))
        {
        return response()->json(['error' => 'invalid_credentials'], 400);
        }
        } catch (JWTException $e) {
        return response()->json(['error' => 'could_not_create_token', 500]);
        }
        // return response()->json(compact('token'));
        $data = User::where('username', '=', $request->username)->get();
        return Response() -> json([
            'status' => 1,
            'message' => 'Success Login!',
            'token' => $token,
            'data' => $data,
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'nama_user' => 'required|string|max:255',
        'role'      => 'required|string|between:2,100', 
        'username'  => 'required|string|max:255',
        'password'  => 'required|string|min:6|confirmed',
        
        ]);
        if($validator->fails()){
        return response()->json($validator->errors()->toJson(), 400);
        }
        $User = User::create([
        'nama_user' => $request->get('nama_user'),
        'role'      => $request->get('role'),
        'username'  => $request->get('username'),
        'password'  => Hash::make($request->get('password')),
        
    ]);
        $token = JWTAuth::fromUser($User);
        return response()->json(compact('User','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try
        {
        if (! $User = JWTAuth::parseToken()->authenticate()) {
        return response()->json(['User_not_found'], 404);
        }
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e)
        {
        return response()->json(['token_expired'], $e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
        return response()->json(['token_invalid'], $e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e)
        {
        return response()->json(['token_absent'], $e->getStatusCode());
        }
        // return response()->json(compact('User'));

         return response()->json([
        'status' => 1,
        'message' => 'Succes login!',
        'data' => $User
         ]);
    }




    //show post data
    public function store(Request $request)
     {
    $validator=Validator::make($request->all(),
            [
               'nama_user' => 'required',
                'role'     => 'required',
                'username' => 'required',
                'password'    => 'required'
               
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = User::create([
            'nama_user' => $request->nama_user,
            'role'     => $request->role,
            'username' => $request->username,
            'password'    => $request->password
         
           
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
        return User::all();
        }


     //show detail data
     public function detail($id)
     {
         if(User::where('id', $id)->exists()){
             $data_User= User::select('nama_user', 'role', 'username', 'password')->where('id', '=', $id)->get();
             return Response()->json($data_User);
         }
         else{
             return Response()->json(['message' => 'Tidak ditemukan']);
         }
     }

    //  //show detail data
    //  public function detail($id)
    //  {
    //      if(User::where('id', $id)->exists()) {
    //      $data = DB::table('User')->where('User.id', '=', $id)->get();
    //      return Response()->json($data);
    //      }
    //      else {
    //      return Response()->json(['message' => 'Tidak ditemukan' ]);
    //      }
    //  }

    //show update data
    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nama_user' => 'required',
            'role' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = User::where('id', $id)->update([
            'nama_user' => $request->nama_user,
            'role' => $request->role,
            'username' => $request->username,
            'password' => $request->password
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
        $hapus = User::where('id', $id)->delete();
        if($hapus) {
        return Response()->json(['status' => 1]);
        }
        else {
        return Response()->json(['status' => 0]);
        }
    }


    public function get(Request $request){
        $get=User::when($request->search, function ($query, $search) {
                return $query->where('role', 'like', "%{$search}%");
            })
            ->get();
        return response()->json($get);
    }

}