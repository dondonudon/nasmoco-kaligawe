<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Dashboard extends Controller
{
    public function index() {
        if (!Session::has('username')) {
            return redirect('dashboard/login');
        } else {
            return view('dashboard-overview');
        }
    }

    public function login() {
        if (Session::has('username')) {
            return redirect('dashboard');
        } else {
            return view('dashboard-login');
        }
    }

    public function sessionFlush() {
        Session::flush();
        if(Session::has('username')) {
            $result = [
                'status' => 'failed'
            ];
        } else {
            $result = [
                'status' => 'success'
            ];
        }
        return json_encode($result);
    }

    public function loginCheck(Request $request) {
        $username = $request->username;
        $password = $request->password;

        try {
            $check = DB::table('ms_user')->where('username','=',$username);
            if ($check->exists()) {
                $user = $check->first();
                $userPassword = Crypt::decryptString($user->password);
                if ($userPassword == $password) {
                    Session::put('username',$username);
                    Session::put('nama_lengkap',$user->nama_lengkap);

                    $result = [
                        'status' => 'success',
                    ];
                } else {
                    $result = [
                        'status' => 'failed',
                        'reason' => 'Password Salah',
                    ];
                }
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'Username tidak terdaftar',
                ];
            }
            return json_encode($result);
        } catch (\Exception $ex) {
            dd('Exception Block',$ex);
        }
    }
}
