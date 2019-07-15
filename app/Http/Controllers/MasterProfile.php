<?php

namespace App\Http\Controllers;

use App\msUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterProfile extends Controller
{
    public function index() {
        $viewName = 'master_profile';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-profile');
        } else {
            return abort('403');
        }
    }

    public function detail() {
        $username = Session::get('username');
        $detail = DB::table('ms_user')
            ->select('username','nama_lengkap','created_at')
            ->where('username','=',$username)
            ->get();
        return $detail->toJson();
    }

    public function edit(Request $request) {
        $username = Session::get('username');
        $namaLengkap = $request->nama;
        $oldPassword = $request->old_password;
        $newPassword = Crypt::encryptString($request->new_password);

        $data = [
            'nama_lengkap' => $namaLengkap,
            'password' => $newPassword
        ];

        $check = DB::table('ms_user')->select('password')
            ->where('username','=',$username)
            ->first();
        $savedPassword = Crypt::decryptString($check->password);
        if ($savedPassword == $oldPassword) {
            $user = clone msUser::where('username',$username)
                ->where('username','=',$username);
            if ($user->update($data)) {
                $result = [
                    'status' => 'success',
                ];
            } else {
                $result = [
                    'status' => 'failed',
                    'reason' => 'Gagal tersimpan',
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'reason' => 'Password lama salah. Silahkan cek password lama anda',
            ];
        }
        return json_encode($result);
    }
}
