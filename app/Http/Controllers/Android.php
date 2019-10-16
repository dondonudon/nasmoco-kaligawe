<?php

namespace App\Http\Controllers;

use App\kepuasanPelanggan;
use App\msUser;
use App\msVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Android extends Controller
{
    public function login(Request $request) {
        $username = $request->username;
        $password = $request->password;

        $check = DB::table('ms_user')->where('username','=',$username);
        if ($check->exists()) {
            $user = $check->first();
            $userPassword = Crypt::decryptString($user->password);
            if ($userPassword == $password) {
                $result[] = [
                    'status' => 'success',
                    'username' => $user->username,
                    'nama_lengkap' => $user->nama_lengkap,
                ];
            } else {
                $result[] = [
                    'status' => 'failed',
                    'reason' => 'Password Salah',
                ];
            }
        } else {
            $result[] = [
                'status' => 'failed',
                'reason' => 'Username tidak terdaftar',
            ];
        }
        return $result;
    }

    public function add(Request $request) {
        $username = $request->username;
        $password = Crypt::encryptString($request->password);
        $namaLengkap = $request->nama_lengkap;

        $user = new msUser;
        $user->username = $username;
        $user->password = $password;
        $user->nama_lengkap = $namaLengkap;

        if ($user->save()) {
            $result[] = [
                'status' => 'success',
            ];
        } else {
            $result[] = [
                'status' => 'failed',
                'reason' => 'Password Salah',
            ];
        }
        return $result;
    }

    public function masterVote(Request $request) {
        $nama = $request->nama;

        $vote = new msVote;
        $vote->nama = $nama;

        if ($vote->save()) {
            $result[] = [
                'status' => 'success',
            ];
        } else {
            $result[] = [
                'status' => 'failed',
                'reason' => 'Password Salah',
            ];
        }
        return $result;
    }

    public function vote(Request $request) {
        $workOrder = $request->work_order;
        $username = $request->username;
        $idVote = $request->vote;

        $vote = new kepuasanPelanggan;
        $vote->work_order = $workOrder;
        $vote->username = $username;
        $vote->id_vote = $idVote;

        if ($vote->save()) {
            $result[] = [
                'status' => 'success',
            ];
        } else {
            $result[] = [
                'status' => 'failed',
                'reason' => 'Password Salah',
            ];
        }
        return $result;
    }

    public function masterUrl(Request $request) {
        $nama = $request->nama;
        $sysDetail = DB::table('sys_detail')->where('nama','=',$nama)->get();
        return $sysDetail->toJson();
    }

    public function getArea() {
        return DB::table('ms_area')->get()->toJson();
    }

    public function image(Request $request) {
        $area = $request->id_area;

        $dbArea = DB::table('ms_image')->get();

        $store = [];
        foreach ($dbArea as $a) {
            $store[] = [
                'id_area' => $a->id_area,
                'url' => asset('storage/'.$a->file),
            ];
        }
        return json_encode($store);
    }
}
