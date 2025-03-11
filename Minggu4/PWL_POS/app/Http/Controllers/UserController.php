<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //tambah data user dengan Eloquent Model
        // $data = [
        //     // 'username' => 'customer-1',
        //     // 'nama' => 'Pelanggan',
        //     // 'password' => Hash::make('12345'),
        //     // 'level_id' => 5

        //     'nama' => 'Pelanggan Pertama',
        // ];
        // // UserModel::insert($data); // tambahkan data ke tabel m_user
        // UserModel::where('username','customer-1')->update($data); // update data user

        // //coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data
        // return view('user', ['data' => $user]);

        #js4 prak 1.1
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);


        #js4 prak 1.2
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        #js4 prak 2.1
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);

        #js4 prak 2.2
        // $user = UserModel::where('level_id', 1)->first();
        // return view('user', ['data' => $user]);

        #js4 prak 2.3
        // $user = UserModel::firstWhere('level_id',1);
        // return view('user', ['data' => $user]);
        
        #js4 prak 2.4
        // $user = UserModel::findOr(1, ['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view('user', ['data' => $user]);
        
        #js4 prak 2.5
        $user = UserModel::findOr(20, ['username', 'nama'], function(){
            abort(404);
        });
        return view('user', ['data' => $user]);
    }
}
